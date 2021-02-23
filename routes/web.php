<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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


//require __DIR__ . '/auth.php';

Route::view('/', 'welcome');
Route::get('/test', function () {

    $admin = \App\Models\Admin::first();
    $messsage = \App\Models\Message::first();

    $admin->notify(new \App\Notifications\PushChatMessage($messsage->load('sender')));
});
Route::post('file/uploader', [Controllers\FileUploadController::class, 'create']);
Route::post('file/remove', [Controllers\FileUploadController::class, 'destroy']);
Route::post('fcm-tokens', [Controllers\FcmTokenController::class, 'store']);
Route::get('/{any}', Controllers\ApplicationController::class)->where('any', '.*');
