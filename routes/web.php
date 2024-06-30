<?php

use App\Http\Controllers\LoanCategoryController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/upload-image', [App\Http\Controllers\ImageUploadController::class, 'index']);
Route::get('/test', [App\Http\Controllers\TestController::class, 'testPaymentStatusTracker']);
Route::get('/test-mail-content', [App\Http\Controllers\TestController::class, 'testMailcontent']);
Route::get('/site-map', [App\Http\Controllers\TestController::class, 'generateSiteMap']);
Route::get('/test-mail', [App\Http\Controllers\TestController::class, 'sendMail']);

Auth::routes();
Route::middleware(['auth'])->group(function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('loan-category')->group(function() {
        Route::get('/', [LoanCategoryController::class, 'index'])->name('loan-category');
        Route::post('/addOrEdit', [LoanCategoryController::class, 'modalAddEdit'])->name('loan-category.add.edit');
        Route::post('/status', [LoanCategoryController::class, 'changeStatus'])->name('loan-category.status');
        Route::post('/delete', [LoanCategoryController::class, 'delete'])->name('loan-category.delete');
        Route::post('/save', [LoanCategoryController::class, 'saveForm'])->name('loan-category.save');
    });

    Route::get('/loans', [LoanController::class, 'index'])->name('loans');
    Route::post('/status', [LoanController::class, 'changeStatus'])->name('loans.status');
    Route::post('/delete', [LoanController::class, 'delete'])->name('loans.delete');

    Route::prefix('my-profile')->group(function(){
        Route::get('/', [App\Http\Controllers\MyProfileController::class, 'index'])->name('my-profile');
        Route::get('/password', [App\Http\Controllers\MyProfileController::class, 'getPasswordTab'])->name('my-profile.password');
        Route::post('/getTab', [App\Http\Controllers\MyProfileController::class, 'getTab'])->name('my-profile.get.tab');
        Route::post('/save', [App\Http\Controllers\MyProfileController::class, 'saveForm'])->name('my-profile.save');
    });
});