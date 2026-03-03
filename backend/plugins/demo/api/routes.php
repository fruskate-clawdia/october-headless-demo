<?php

/**
 * API Routes — standard Laravel routing
 *
 * This is just Laravel. No CMS magic.
 * OctoberCMS plugins can define any Laravel routes here.
 */

use Demo\Api\Http\Controllers\PostController;

Route::prefix('api/v1')->middleware('api')->group(function () {

    // Handle OPTIONS preflight for CORS
    Route::options('{any}', function () {
        return response('', 200);
    })->where('any', '.*');

    // Posts API
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{slug}', [PostController::class, 'show']);

    // Health check
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'cms_module' => config('cms.disableCmsModule') ? 'disabled' : 'enabled',
            'message' => 'OctoberCMS headless API is running!',
        ]);
    });

});
