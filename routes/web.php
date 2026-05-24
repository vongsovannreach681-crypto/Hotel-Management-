<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\ProfileController as UserProfileController;

Route::get('/', [UserHomeController::class, 'index'])->name('user.home');
Route::get('/rooms', [UserHomeController::class, 'rooms'])->name('user.rooms.index');
Route::get('/rooms/{hotel}', [UserHomeController::class, 'show'])->name('user.hotels.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('account')->name('user.')->group(function () {
    Route::get('/bookings', [UserBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{hotel}/create', [UserBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/{hotel}', [UserBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/details/{booking}', [UserBookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/payment/status', [UserBookingController::class, 'paymentStatus'])->name('bookings.payment.status');
    Route::post('/bookings/{booking}/payment/check', [UserBookingController::class, 'checkPayment'])->name('bookings.payment.check');
    Route::post('/bookings/{booking}/cancel', [UserBookingController::class, 'cancel'])->name('bookings.cancel');

    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('hotels', HotelController::class);
    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store']);
    Route::resource('guests', GuestController::class)->except(['show']);
});

Route::get('/sample', [SampleController::class, 'index']);
