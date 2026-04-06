<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MomoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\ShowtimeController;




Route::get('/movies', [MovieController::class, 'index']);
Route::post('/movies', [MovieController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/checkout', [OrderController::class, 'checkout']);
Route::get('/admin/stats', [OrderController::class, 'stats']);
Route::get('/user/{id}',[UserController::class,'show']);
Route::put('/user/{id}',[UserController::class,'update']);
Route::post('/admin/movies',[AdminMovieController::class,'store']);
Route::get('/users',[UserController::class,'index']);
Route::post('/users/{id}/toggle-status',[UserController::class,'toggleStatus']);
Route::post('/register',[AuthController::class,'register']);
Route::get('/employees',[EmployeeController::class,'index']);
Route::delete('/employees/{id}',[EmployeeController::class,'destroy']);
Route::post('/employees',[EmployeeController::class,'store']);
Route::put('/employees/{id}',[EmployeeController::class,'update']);
Route::post('/momo_payment',[MomoController::class,'momo_payment']);
Route::post('/user/change-password/{id}', [UserController::class, 'changePassword']);
Route::get('/tickets/{user_id}',[TicketController::class,'userTickets']);
Route::post('/tickets',[TicketController::class,'store']);
Route::post('/payments', [PaymentController::class,'store']);
Route::get('/payments', [PaymentController::class,'index']);
Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);
Route::delete('/tickets/{id}', [TicketController::class,'destroy']);
Route::get('/revenue-chart', [TicketController::class, 'revenueChart']);
Route::post('/vouchers', [VoucherController::class, 'store']);
Route::get('/vouchers', [VoucherController::class, 'index']);
Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy']);
Route::post('/employees/{id}/toggle-status', [EmployeeController::class, 'toggleStatus']);
Route::post('/save-voucher', [VoucherController::class, 'saveVoucher']);
Route::get('/user-voucher/{id}', [VoucherController::class, 'getUserVoucher']);
Route::delete('/delete-voucher/{code}',[VoucherController::class,'deleteVoucher']);
Route::get('/showtimes', [ShowtimeController::class,'index']);
Route::post('/showtimes', [ShowtimeController::class,'store']);
Route::put('/showtimes/{id}', [ShowtimeController::class,'update']);
Route::delete('/showtimes/{id}', [ShowtimeController::class,'destroy']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
Route::prefix('admin')->group(function () {


    Route::get('/dashboard', function () {
        return response()->json([
            'message' => 'Admin dashboard'
        ]);
    });

    Route::get('/movies',[AdminMovieController::class,'index']);
    Route::post('/movies',[AdminMovieController::class,'store']);
    Route::put('/movies/{id}',[AdminMovieController::class,'update']);
    Route::delete('/movies/{id}',[AdminMovieController::class,'destroy']);

});
