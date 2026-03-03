<?php

/**
 * API Routes — standard Laravel routing
 *
 * This is just Laravel. No CMS magic.
 * OctoberCMS plugins can define any Laravel routes here.
 */

use Demo\Api\Http\Controllers\TodoController;

// Redirect site root to admin panel
Route::get('/', function () {
    return redirect(Backend::url('demo/api/todos'));
});

Route::prefix('api/v1')->middleware('api')->group(function () {

    // Handle OPTIONS preflight for CORS
    Route::options('{any}', function () {
        return response('', 200);
    })->where('any', '.*');

    // Todos API (full CRUD)
    Route::get('/todos', [TodoController::class, 'index']);
    Route::post('/todos', [TodoController::class, 'store']);
    Route::put('/todos/{id}', [TodoController::class, 'update']);
    Route::delete('/todos/{id}', [TodoController::class, 'destroy']);

    // Health check
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'cms_module' => str_contains(env('LOAD_MODULES', ''), 'Cms') ? 'enabled' : 'disabled',
            'message' => 'OctoberCMS headless API is running!',
        ]);
    });

});
