<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Api\PatientApiController;

// Authentication required routes
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UsersController::class, 'user']);
    
    // Patient API routes for AJAX optimization
    Route::prefix('patients')->group(function () {
        Route::get('/search', [PatientApiController::class, 'search']);
        Route::get('/recent', [PatientApiController::class, 'recent']);
        Route::get('/statistics', [PatientApiController::class, 'statistics']);
        Route::get('/{id}', [PatientApiController::class, 'show']);
        Route::post('/quick-create', [PatientApiController::class, 'quickCreate']);
    });
    
    // Facture API routes
    Route::prefix('factures')->group(function () {
        Route::get('/statistics', 'Api\FactureApiController@statistics');
        Route::get('/search', 'Api\FactureApiController@search');
        Route::get('/monthly-report/{year?}', 'Api\FactureApiController@monthlyReport');
    });
    
    // Dashboard API routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/stats', 'Api\DashboardApiController@stats');
        Route::get('/recent-activity', 'Api\DashboardApiController@recentActivity');
        Route::get('/charts-data', 'Api\DashboardApiController@chartsData');
    });
});

// Public API routes (with rate limiting)
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toISOString(),
            'version' => config('app.version', '1.0.0')
        ]);
    });
});
