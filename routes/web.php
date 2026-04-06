<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MomoController;

Route::get('/checkout',[MomoController::class,'checkout']);
