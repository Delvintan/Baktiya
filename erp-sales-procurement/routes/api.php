<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProcurementController;

// ── PUBLIC ──
Route::post('/login', [AuthController::class, 'login']);

// ── PROTECTED ──
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // ── SALES (sales + admin) ──
    Route::middleware('role:sales,admin')->group(function () {
        Route::get   ('/sales-requests',               [SalesController::class, 'index']);
        Route::post  ('/sales-requests',               [SalesController::class, 'store']);
        Route::get   ('/sales-requests/{id}',          [SalesController::class, 'show']);
        Route::patch ('/sales-requests/{id}/status',   [SalesController::class, 'updateStatus']);
        Route::delete('/sales-requests/{id}',          [SalesController::class, 'destroy']);
    });

    // ── PROCUREMENT (procurement + admin) ──
    Route::middleware('role:procurement,admin')->group(function () {
        Route::get   ('/purchase-orders',              [ProcurementController::class, 'index']);
        Route::post  ('/purchase-orders',              [ProcurementController::class, 'store']);
        Route::get   ('/purchase-orders/{id}',         [ProcurementController::class, 'show']);
        Route::patch ('/purchase-orders/{id}/status',  [ProcurementController::class, 'updateStatus']);

        // Procurement bisa lihat semua SR
        Route::get   ('/procurement/sales-requests',   [ProcurementController::class, 'salesRequests']);
    });
});
