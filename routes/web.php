<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| الصفحة الرئيسية (الداشبورد)
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| القاعات
|--------------------------------------------------------------------------
*/

Route::resource('halls', HallController::class);

/*
|--------------------------------------------------------------------------
| الحجوزات
|--------------------------------------------------------------------------
*/

Route::resource('bookings', BookingController::class);

Route::get('/bookings/{id}/print', [BookingController::class, 'print'])
    ->name('bookings.print');

Route::get('/contract/{id}', [BookingController::class, 'print'])
    ->name('contract.view');

Route::get('/send-whatsapp/{id}', [BookingController::class, 'sendWhatsApp'])
    ->name('bookings.whatsapp');

/*
|--------------------------------------------------------------------------
| الدفعات
|--------------------------------------------------------------------------
*/

Route::get('/payments/create/{booking_id}', [PaymentController::class, 'create'])
    ->name('payments.create');

Route::post('/payments/store', [PaymentController::class, 'store'])
    ->name('payments.store');

Route::get('/payments/{booking_id}', [PaymentController::class, 'show'])
    ->name('payments.show');

/*
|--------------------------------------------------------------------------
| التقارير
|--------------------------------------------------------------------------
*/

Route::view('/reports', 'reports.index')
    ->name('reports.index');

Route::get('/reports/daily', [PaymentController::class, 'dailyReport'])
    ->name('reports.daily');

Route::get('/reports/monthly', [PaymentController::class, 'monthlyReport'])
    ->name('reports.monthly');

Route::get('/reports/yearly', [PaymentController::class, 'yearlyReport'])
    ->name('reports.yearly');

/*
|--------------------------------------------------------------------------
| العملاء
|--------------------------------------------------------------------------
*/

Route::get('/clients', [ClientController::class, 'index'])
    ->name('clients.index');
use App\Http\Controllers\ReportController;

Route::get('/reports', [ReportController::class, 'index'])
    ->name('reports.index');