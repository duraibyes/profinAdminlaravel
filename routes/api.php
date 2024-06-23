<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Middleware\CorsMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the 'api' middleware group. Enjoy building your API!
|
*/
Route::middleware([CorsMiddleware::class])->group(function () {
    Route::get('loan-category', [LoanController::class, 'getLoanCategoryList']);
    Route::post('send-otp', [AuthController::class, 'sendOTP']);
    Route::post('submit-otp', [AuthController::class, 'submitOtp']);
    
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('loan-category/{slug}', [LoanController::class, 'getLoanCategoryInfo']);
        Route::post('loan-category', [LoanController::class, 'SubmitLoanInformation']);
    });
});

