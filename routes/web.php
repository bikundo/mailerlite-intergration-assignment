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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('mailerlite')->group(function () {
    Route::get('/home', [MailerLiteTokenController::class, 'home'])->name('mailerlite.home');
    Route::get('/index', [MailerLiteTokenController::class, 'index'])->name('mailerlite.index');
    Route::get('/api-token', [MailerLiteTokenController::class, 'create'])->name('mailerlite.token.create');
    Route::post('/api-token', [MailerLiteTokenController::class, 'store'])->name('mailerlite.token.validate');

    Route::resource('subscribers', SubscriberController::class);

});

