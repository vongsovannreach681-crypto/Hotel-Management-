@extends('user.layout')

@section('title', 'Booking ' . $booking->booking_no)

@section('extra_css')
<style>
    .shell { width:min(1020px, calc(100% - 2rem)); margin:2rem auto 0; }
    .card { background:#fff; border:1px solid #eadfce; border-radius:20px; box-shadow:0 18px 30px rgba(10,20,30,.08); overflow:hidden; }
    .head { padding:1.1rem 1.2rem; background:#132132; color:#fff; display:flex; justify-content:space-between; gap:0.8rem; align-items:center; flex-wrap:wrap; }
    .body { padding:1.2rem; display:grid; gap:1rem; }
    .status { padding:0.35rem .65rem; border-radius:999px; font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; }
    .pending { background:#fff6dd; color:#7c560e; }
    .confirmed { background:#eaf7ee; color:#225f42; }
    .checked_in { background:#e8f2ff; color:#255ea8; }
    .checked_out { background:#edf0f3; color:#4c5f71; }
    .cancelled { background:#fdecec; color:#923b3b; }
    .grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:0.8rem; }
    .item { background:#fcf8f2; border:1px solid #eadfce; border-radius:14px; padding:0.8rem; }
    .item small { color:#6a7b8b; display:block; margin-bottom:0.2rem; }
    .item strong { color:#1f2a3a; font-size:1.02rem; }
    .payment-box { background:#fffef9; border:1px solid #eadfce; border-radius:16px; padding:1rem; display:grid; gap:0.75rem; }
    .qr-wrap { width: min(300px, 100%); background:#fff; border:1px solid #e4d7c5; border-radius:12px; padding:0.6rem; }
    .qr-wrap svg { width:100%; height:auto; display:block; }
    .qr-actions { display:flex; gap:0.55rem; flex-wrap:wrap; }
    .qr-thumb { width:min(180px, 100%); }
    .helper { color:#6d7f90; font-size:0.85rem; }
    .actions { display:flex; gap:0.6rem; flex-wrap:wrap; }
    .qr-modal-backdrop { position:fixed; inset:0; background:radial-gradient(circle at top, rgba(44,74,120,.55), rgba(9,16,28,.86)); backdrop-filter:blur(5px); display:none; align-items:center; justify-content:center; padding:1rem; z-index:9999; }
    .qr-modal-backdrop.open { display:flex; }
    .qr-modal { width:min(440px, 100%); color:#fff; background:linear-gradient(160deg, #0f3566 0%, #04264f 58%, #032140 100%); border:1px solid rgba(255,255,255,.2); border-radius:22px; padding:1rem; box-shadow:0 32px 52px rgba(0,0,0,.42); }
    .qr-modal-head { display:flex; align-items:center; justify-content:space-between; gap:0.8rem; margin-bottom:0.85rem; }
    .aba-brand { display:inline-flex; align-items:center; gap:0.5rem; font-weight:700; letter-spacing:.07em; font-size:.82rem; color:#e7f2ff; }
    .aba-dot { width:9px; height:9px; border-radius:999px; background:#fd4a4a; box-shadow:12px 0 0 #fff, 24px 0 0 #fd4a4a; margin-right:18px; }
    .qr-close { border:none; background:rgba(255,255,255,.18); color:#fff; border-radius:999px; width:34px; height:34px; font-size:1.1rem; cursor:pointer; }
    .aba-amount { font-size:1.7rem; font-weight:800; letter-spacing:.01em; line-height:1.1; margin-bottom:.15rem; }
    .aba-booking { color:rgba(230,240,252,.86); font-size:.85rem; margin-bottom:0.7rem; }
    .qr-modal-body .qr-wrap { width:100%; background:#fff; border:1px solid #d9e5f5; padding:0.8rem; border-radius:16px; }
    .aba-hint { color:#bed5ef; font-size:.82rem; text-align:center; margin-top:0.7rem; margin-bottom:0; }

    @media (max-width: 720px) {
        .grid { grid-template-columns:1fr; }
        .qr-modal { padding:0.9rem; border-radius:20px; }
        .aba-amount { font-size:1.48rem; }
    }
</style>
@endsection

@section('content')
<div class="shell">
    <article class="card reveal">
        <header class="head">
            <div>
                <h1 style="font-family:'Poppins',sans-serif; font-size:2rem; line-height:0.95;">Booking {{ $booking->booking_no }}</h1>
                <p style="opacity:.9;">{{ $booking->hotel?->name ?? 'Hotel' }}</p>
            </div>
            <span class="status {{ $booking->status }}">{{ str_replace('_', ' ', $booking->status) }}</span>
        </header>

        <div class="body">
            <div class="grid">
                <div class="item"><small>Guest Name</small><strong>{{ $booking->guest_name }}</strong></div>
                <div class="item"><small>Guest Email</small><strong>{{ $booking->guest_email }}</strong></div>
                <div class="item"><small>Check In</small><strong>{{ $booking->check_in_date->format('F d, Y') }}</strong></div>
                <div class="item"><small>Check Out</small><strong>{{ $booking->check_out_date->format('F d, Y') }}</strong></div>
                <div class="item"><small>Guests</small><strong>{{ $booking->guests }}</strong></div>
                <div class="item"><small>Total Price</small><strong>${{ number_format((float) $booking->total_price, 2) }}</strong></div>
            </div>

            <div class="item">
                <small>Notes</small>
                <strong style="font-size:0.94rem; font-weight:600;">{{ $booking->notes ?: 'No special notes.' }}</strong>
            </div>

            <div class="payment-box">
                <small style="color:#6a7b8b;">Bakong Payment QR</small>
                @if ($paymentQrSvg)
                    <div class="qr-wrap qr-thumb">{!! $paymentQrSvg !!}</div>
                    <p class="helper">Scan this QR with your Bakong-supported banking app to pay for booking {{ $booking->booking_no }}.</p>
                    <div class="qr-actions">
                        <button type="button" class="btn btn-primary" id="openQrModal">Open QR Popup</button>
                    </div>
                @elseif ($paymentQrError)
                    <p class="helper" style="color:#9a3528;">{{ $paymentQrError }}</p>
                @else
                    <p class="helper">Payment QR is not available for this booking status.</p>
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('user.bookings.index') }}" class="btn btn-soft">Back To My Bookings</a>
                @if (!in_array($booking->status, ['checked_in', 'checked_out', 'cancelled'], true))
                    <form method="POST" action="{{ route('user.bookings.cancel', $booking) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Cancel Booking</button>
                    </form>
                @endif
            </div>
        </div>
    </article>
</div>

@if ($paymentQrSvg)
    <div class="qr-modal-backdrop" id="qrModalBackdrop" aria-hidden="true">
        <div class="qr-modal" role="dialog" aria-modal="true" aria-label="Bakong QR Payment">
            <div class="qr-modal-head">
                <div class="aba-brand"><span class="aba-dot"></span><span>ABA PAYWAY</span></div>
                <button type="button" class="qr-close" id="closeQrModal" aria-label="Close QR popup">&times;</button>
            </div>
            <div class="aba-amount">${{ number_format((float) $booking->total_price, 2) }}</div>
            <p class="aba-booking">Booking {{ $booking->booking_no }}</p>
            <div class="qr-modal-body">
                <div class="qr-wrap">{!! $paymentQrSvg !!}</div>
                <p class="aba-hint">Scan with ABA, Bakong, or supported banking app</p>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
@if ($paymentQrSvg)
<script>
    const qrModalBackdrop = document.getElementById('qrModalBackdrop');
    const openQrModal = document.getElementById('openQrModal');
    const closeQrModal = document.getElementById('closeQrModal');

    const showQrModal = () => {
        if (!qrModalBackdrop) return;
        qrModalBackdrop.classList.add('open');
        qrModalBackdrop.setAttribute('aria-hidden', 'false');
    };

    const hideQrModal = () => {
        if (!qrModalBackdrop) return;
        qrModalBackdrop.classList.remove('open');
        qrModalBackdrop.setAttribute('aria-hidden', 'true');
    };

    if (openQrModal) {
        openQrModal.addEventListener('click', showQrModal);
    }

    if (closeQrModal) {
        closeQrModal.addEventListener('click', hideQrModal);
    }

    if (qrModalBackdrop) {
        qrModalBackdrop.addEventListener('click', (event) => {
            if (event.target === qrModalBackdrop) {
                hideQrModal();
            }
        });
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            hideQrModal();
        }
    });

    const bookingStatus = @json($booking->status);
    const paymentStatusUrl = @json(route('user.bookings.payment.status', $booking));
    let paymentPollingTimer = null;
    let paymentPollTries = 0;
    let paymentAlertShown = false;
    const maxPollTries = 60; // 5 minutes at 5s interval

    const stopPaymentPolling = () => {
        if (paymentPollingTimer) {
            clearInterval(paymentPollingTimer);
            paymentPollingTimer = null;
        }
    };

    const PAYMENT_SUCCESS_STORAGE_KEY = 'booking_payment_success_message';

    const onPaymentSuccess = () => {
        if (paymentAlertShown) return;
        paymentAlertShown = true;
        stopPaymentPolling();
        hideQrModal();
        const successMessage = 'Payment successful. Your booking is confirmed.';
        let showImmediateAlert = true;
        try {
            sessionStorage.setItem(PAYMENT_SUCCESS_STORAGE_KEY, successMessage);
            showImmediateAlert = false;
        } catch (error) {
            // Ignore storage failures and fallback to immediate alert.
        }
        if (showImmediateAlert) {
            alert(successMessage);
        }
        window.location.reload();
    };

    const pollPaymentStatus = async () => {
        if (paymentAlertShown) return;
        paymentPollTries += 1;

        if (paymentPollTries > maxPollTries) {
            stopPaymentPolling();
            return;
        }

        try {
            const response = await fetch(paymentStatusUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });

            const data = await response.json();
            if (data && data.paid === true) {
                onPaymentSuccess();
            }
        } catch (error) {
            // Keep silent and continue polling.
        }
    };

    const canAutoPoll = !['confirmed', 'cancelled', 'checked_out'].includes(bookingStatus);
    if (canAutoPoll) {
        paymentPollingTimer = setInterval(pollPaymentStatus, 5000);
        setTimeout(() => { pollPaymentStatus(); }, 1500);
    }
</script>
@endif
@if (session('payment_successful'))
<script>
    alert('Payment successful. Your booking is confirmed.');
</script>
@endif
<script>
    try {
        const successMessage = sessionStorage.getItem('booking_payment_success_message');
        if (successMessage) {
            alert(successMessage);
            sessionStorage.removeItem('booking_payment_success_message');
        }
    } catch (error) {
        // Ignore storage read errors.
    }
</script>
@endpush
