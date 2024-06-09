<?php

use App\Http\Controllers\Dashboard\BlogCategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\LanguageController;
use App\Http\Controllers\Dashboard\LeadController;
use App\Http\Controllers\Dashboard\PortfolioController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\ServiceCategoryController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\TranslationController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->as('dashboard.')->middleware('auth:web')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('index');

    // Users Management
    Route::resource('users', UserController::class);
    Route::put('users/update_password/{id}', [UserController::class, 'updatePassword'])->name('users.updatePassword');

    // Roles Management
    Route::resource('roles', RoleController::class);

    // Settings Management
    Route::resource('settings', SettingController::class);
    Route::resource('languages', LanguageController::class);
    Route::get('/remove_image/{language}', [LanguageController::class, 'removeImage'])->name('languages.removeImage');
    Route::resource('translations', TranslationController::class);

    // Categories Management
    Route::resource('blogs_categories', BlogCategoryController::class);
    Route::get('/remove_image/{category}', [BlogCategoryController::class, 'removeImage'])->name('blogs_categories.removeImage');
    Route::resource('services_categories', ServiceCategoryController::class);
    Route::get('/remove_image/{category}', [ServiceCategoryController::class, 'removeImage'])->name('services_categories.removeImage');

    // Services Management
    Route::resource('services', ServiceController::class);
    Route::get('/remove_image/{service}', [ServiceController::class, 'removeImage'])->name('services.removeImage');

    // Portfolio Management
    Route::resource('portfolios', PortfolioController::class);
    Route::get('/remove_image/{portfolio}', [PortfolioController::class, 'removeImage'])->name('portfolios.removeImage');

    // lead Management
    Route::resource('leads', LeadController::class);


});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
