<?php

use App\Http\Controllers\MailerLiteTokenController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::prefix('mailerlite')->group(function () {

    Route::get('/', [MailerLiteTokenController::class, 'index'])->name('mailerlite.index');
    Route::get('/api-token', [MailerLiteTokenController::class, 'create'])->name('mailerlite.token.create');
    Route::post('/api-token', [MailerLiteTokenController::class, 'store'])->name('mailerlite.token.validate');

    Route::get('/datatables/subscribers', [SubscriberController::class, 'datatables'])->name('mailerlite.subscribers.table');

    Route::resource('subscribers', SubscriberController::class);

});

