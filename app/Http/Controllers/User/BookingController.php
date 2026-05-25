<?php

namespace App\Http\Controllers\User;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Helpers\Utils;
use Throwable;

class BookingController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'all');
        $user = auth()->user();

        $bookingsQuery = $user->bookings()->with('hotel')->latest();

        if (in_array($filter, ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'], true)) {
            $bookingsQuery->where('status', $filter);
        }

        $bookings = $bookingsQuery->paginate(10);

        $summary = [
            'all' => $user->bookings()->count(),
            'upcoming' => $user->bookings()
                ->where('status', '!=', 'checked_out')
                ->where('status', '!=', 'cancelled')
                ->where('check_in_date', '>', Carbon::today())
                ->count(),
            'active' => $user->bookings()
                ->whereIn('status', ['confirmed', 'checked_in'])
                ->where('check_in_date', '<=', Carbon::today())
                ->where('check_out_date', '>=', Carbon::today())
                ->count(),
            'past' => $user->bookings()
                ->where('check_out_date', '<', Carbon::today())
                ->count(),
        ];

        return view('user.bookings.index', compact('bookings', 'summary', 'filter'));
    }

    public function create(Hotel $hotel)
    {
        if ($hotel->status !== 'available') {
            return redirect()->route('user.home')->with('error', 'This hotel is not available for booking.');
        }

        return view('user.bookings.create', compact('hotel'));
    }

    public function store(Request $request, Hotel $hotel)
    {
        if ($hotel->status !== 'available') {
            return redirect()->route('user.home')->with('error', 'This hotel is not available for booking.');
        }

        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:2000',
        ]);

        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = max(1, $checkIn->diffInDays($checkOut));

        $totalPrice = (float) $hotel->price_per_night * $nights;
        $bookingNo = $this->generateBookingNo();

        $booking = auth()->user()->bookings()->create([
            'hotel_id' => $hotel->id,
            'booking_no' => $bookingNo,
            'guest_name' => auth()->user()->name,
            'guest_email' => auth()->user()->email,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'guests' => $validated['guests'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('user.bookings.show', $booking)
            ->with('success', 'Booking created successfully. Booking #' . $booking->booking_no);
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $paymentQrSvg = null;
        $paymentQrError = null;
        $paymentQrMd5 = null;

        if (! in_array($booking->status, ['cancelled'], true)) {
            try {
                $paymentData = $this->buildBookingPaymentData($booking);
                $paymentQrError = $paymentData['error'];
                $paymentQrMd5 = $paymentData['md5'];

                if (! $paymentQrError && isset($paymentData['payload'])) {
                    $renderer = new ImageRenderer(
                        new RendererStyle(320),
                        new SvgImageBackEnd()
                    );
                    $writer = new Writer($renderer);
                    $paymentQrSvg = $writer->writeString($paymentData['payload']);
                }
            } catch (Throwable $e) {
                report($e);
                $paymentQrError = 'Unable to generate Bakong QR at the moment.';
            }
        }

        return view('user.bookings.show', compact('booking', 'paymentQrSvg', 'paymentQrError', 'paymentQrMd5'));
    }

    public function checkPayment(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $result = $this->verifyPaymentForBooking($booking);

        if (! $result['ok']) {
            return back()->with('error', $result['message']);
        }

        if (! $result['paid']) {
            return back()->with('error', $result['message']);
        }

        return back()
            ->with('success', 'Payment successful. Your booking is confirmed.')
            ->with('payment_successful', true);
    }

    public function paymentStatus(Booking $booking): JsonResponse
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json([
                'ok' => false,
                'paid' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $result = $this->verifyPaymentForBooking($booking);

        return response()->json([
            'ok' => $result['ok'],
            'paid' => $result['paid'],
            'message' => $result['message'],
            'booking_status' => $booking->fresh()->status,
        ], $result['ok'] ? 200 : 422);
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if (in_array($booking->status, ['checked_in', 'checked_out', 'cancelled'])) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }

    private function generateBookingNo(): string
    {
        do {
            $candidate = 'BK-' . now()->format('Ymd') . '-' . random_int(1000, 9999);
        } while (Booking::where('booking_no', $candidate)->exists());

        return $candidate;
    }

    private function buildStrictKhqrPayload(
        string $bakongAccountId,
        string $merchantName,
        string $merchantCity,
        int $currency,
        float $amount
    ): string {
        $merchantName = mb_substr(trim($merchantName), 0, 25);
        $merchantCity = mb_substr(trim($merchantCity), 0, 15);

        $pointOfInitiation = $amount > 0 ? '12' : '11';
        $currencyCode = (string) $currency;
        $amountValue = $this->formatKhqrAmount($amount, $currency);

        $accountInfo = $this->tlv('00', $bakongAccountId);
        $payload = '';
        $payload .= $this->tlv('00', '01');
        $payload .= $this->tlv('01', $pointOfInitiation);
        $payload .= $this->tlv('29', $accountInfo);
        $payload .= $this->tlv('52', '5999');
        $payload .= $this->tlv('53', $currencyCode);

        if ($amountValue !== null) {
            $payload .= $this->tlv('54', $amountValue);
        }

        $payload .= $this->tlv('58', 'KH');
        $payload .= $this->tlv('59', $merchantName);
        $payload .= $this->tlv('60', $merchantCity);

        $base = $payload . '6304';
        $crc = Utils::crc16($base);
        // Convert CRC to 4-character uppercase hex string
        $crcHex = strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));

        return $base . $crcHex;
    }

    private function buildBookingPaymentData(Booking $booking): array
    {
        $bakongAccountId = trim((string) config('services.bakong.account_id'));
        if ($bakongAccountId === '') {
            return ['error' => 'Bakong account is not configured.', 'is_static' => true];
        }

        $currencyKey = strtoupper((string) config('services.bakong.currency', 'USD'));
        $currency = $currencyKey === 'KHR' ? KHQRData::CURRENCY_KHR : KHQRData::CURRENCY_USD;
        $amount = (float) $booking->total_price;
        $forceStatic = (bool) config('services.bakong.force_static', true);

        if ($currency === KHQRData::CURRENCY_KHR) {
            $amount = (float) round($amount);
        }

        $dynamicAmount = $forceStatic ? 0.0 : $amount;
        $payload = $this->buildStrictKhqrPayload(
            bakongAccountId: $bakongAccountId,
            merchantName: (string) config('services.bakong.merchant_name', config('app.name')),
            merchantCity: (string) config('services.bakong.merchant_city', 'PHNOM PENH'),
            currency: $currency,
            amount: $dynamicAmount
        );

        return [
            'payload' => $payload,
            'md5' => md5($payload),
            'is_static' => $dynamicAmount <= 0,
            'error' => null,
        ];
    }

    private function isBakongPaymentSuccessful(array $response): bool
    {
        if (($response['responseCode'] ?? null) !== 0) {
            return false;
        }

        $data = $response['data'] ?? null;
        if ($data === null) {
            return false;
        }

        if (is_array($data) && array_key_exists('status', $data)) {
            $status = strtoupper((string) $data['status']);
            if (in_array($status, ['SUCCESS', 'COMPLETED', 'PAID'], true)) {
                return true;
            }
        }

        if (is_array($data) && isset($data['hash'])) {
            return true;
        }

        if (is_array($data) && array_is_list($data)) {
            foreach ($data as $item) {
                if (is_array($item) && isset($item['status'])) {
                    $itemStatus = strtoupper((string) $item['status']);
                    if (in_array($itemStatus, ['SUCCESS', 'COMPLETED', 'PAID'], true)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function verifyPaymentForBooking(Booking $booking): array
    {
        if (in_array($booking->status, ['cancelled', 'checked_out'], true)) {
            return [
                'ok' => false,
                'paid' => false,
                'message' => 'This booking cannot be paid in the current status.',
            ];
        }

        if ($booking->status === 'confirmed') {
            return [
                'ok' => true,
                'paid' => true,
                'message' => 'Payment already confirmed.',
            ];
        }

        $token = trim((string) config('services.bakong.token'));
        if ($token === '') {
            return [
                'ok' => false,
                'paid' => false,
                'message' => 'Bakong token is not configured.',
            ];
        }

        $paymentData = $this->buildBookingPaymentData($booking);
        if (! empty($paymentData['error'])) {
            return [
                'ok' => false,
                'paid' => false,
                'message' => (string) $paymentData['error'],
            ];
        }

        if (($paymentData['is_static'] ?? false) === true) {
            return [
                'ok' => false,
                'paid' => false,
                'message' => 'Static QR cannot confirm a specific booking payment. Set BAKONG_FORCE_STATIC=false.',
            ];
        }

        try {
            $client = new BakongKHQR($token);
            $response = $client->checkTransactionByMD5((string) $paymentData['md5']);

            if (! $this->isBakongPaymentSuccessful($response)) {
                return [
                    'ok' => true,
                    'paid' => false,
                    'message' => 'Waiting for payment confirmation...',
                ];
            }

            if ($booking->status === 'pending') {
                $booking->update(['status' => 'confirmed']);
            }

            return [
                'ok' => true,
                'paid' => true,
                'message' => 'Payment successful.',
            ];
        } catch (Throwable $e) {
            report($e);
            return [
                'ok' => false,
                'paid' => false,
                'message' => 'Unable to verify payment right now. Please try again.',
            ];
        }
    }

    private function tlv(string $tag, string $value): string
    {
        return $tag . str_pad((string) strlen($value), 2, '0', STR_PAD_LEFT) . $value;
    }

    private function formatKhqrAmount(float $amount, int $currency): ?string
    {
        if ($amount <= 0) {
            return null;
        }

        if ($currency === KHQRData::CURRENCY_KHR) {
            return (string) (int) round($amount);
        }

        return number_format($amount, 2, '.', '');
    }
}
