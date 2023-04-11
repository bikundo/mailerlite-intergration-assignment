<?php

use App\Http\Controllers\MailerLiteController;
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
    Route::get('/home', [MailerLiteController::class, 'home'])->name('mailerlite.home');
    Route::get('/index', [MailerLiteController::class, 'index'])->name('mailerlite.index');
    Route::get('/api-token', [MailerLiteController::class, 'createApiToken'])->name('mailerlite.token.create');
    Route::post('/api-token', [MailerLiteController::class, 'storeApiToken'])->name('mailerlite.token.validate');
});

