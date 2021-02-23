<?php

use App\Http\Controllers\Admin;
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

Route::prefix('api/admin')->middleware(['localization'])->name('admin.')->group(function () {
    Route::post('/login', [Admin\Auth\AuthenticatedSessionController::class, 'store'])
        ->middleware('admin.guest');
    Route::post('/forgot-password', [Admin\Auth\PasswordResetLinkController::class, 'store'])
        ->middleware(['admin.guest'])
        ->name('password.email');
    Route::post('/reset-password', [Admin\Auth\NewPasswordController::class, 'store'])
        ->middleware(['admin.guest'])
        ->name('password.update');
    Route::post('/logout', [Admin\Auth\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout')
        ->middleware('admin.auth');
    Route::get('/me', [Admin\Auth\AuthenticatedSessionController::class, 'show'])
        ->name('me')
        ->middleware('admin.auth');


    Route::middleware(['admin.auth'])->group(function ($router) {

        Route::get('home',[Admin\HomeController::class,'index']);
        Route::resources([
            'permissions' => Admin\PermissionController::class,
            'roles' => Admin\RoleController::class,
            'admins' => Admin\AdminController::class,
            'addresses' => Admin\AddressController::class,
            'agents' => Admin\AgentController::class,
            'car-types' => Admin\CarTypeController::class,
            'categories' => Admin\CategoryController::class,
            'cities' => Admin\CityController::class,
            'deliveries' => Admin\DeliveryController::class,
            'marks' => Admin\MarkController::class,
            'promocodes' => Admin\PromocodeController::class,
            'products' => Admin\ProductController::class,
            'users' => Admin\UserController::class,
            'providers' => Admin\ProviderController::class,
            'invoices' => Admin\InvoiceController::class,
        ], ['except' => ['create', 'edit']]);
        Route::resource('settings', Admin\SettingController::class)->except('create', 'store', 'destroy');
        Route::patch('categories/{category}/block', [Admin\CategoryController::class, 'block']);
        Route::patch('users/{user}/block', [Admin\UserController::class, 'block']);
        Route::patch('marks/{mark}/block', [Admin\MarkController::class, 'block']);
        Route::patch('agents/{agent}/block', [Admin\AgentController::class, 'block']);
        Route::patch('deliveries/{delivery}/block', [Admin\DeliveryController::class, 'block']);

        Route::get('chats/{mode_type}/{model_id}', [Admin\ChatController::class, 'show']);
        Route::resource('chats', Admin\ChatController::class)->only('index', 'store');
        Route::resource('messages', \App\Http\Controllers\MessageController::class)->only('store');
        Route::post('fcm-tokens', [\App\Http\Controllers\FcmTokenController::class, 'store']);
    });
});
