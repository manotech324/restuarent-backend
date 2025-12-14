<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\Menu\CategoryController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\TableController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me',      [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh',[AuthController::class, 'refresh']);
});


Route::middleware(['auth:api', 'superadmin'])->group(function () {
    Route::apiResource('branch', BranchController::class);
});
Route::middleware(['auth:api','checkRole:superadmin,branch_supervisor'])->group(function () {
});
    Route::apiResource('menu-items', MenuController::class);

Route::middleware(['auth:api','checkRole:superadmin,branch_supervisor'])->group(function () {
    Route::apiResource('menu-category', CategoryController::class);
});
Route::apiResource('orders', OrderController::class);
Route::patch('orders/{order}/status/{status}', [OrderController::class, 'updateStatus']);

Route::apiResource('tables', TableController::class);

