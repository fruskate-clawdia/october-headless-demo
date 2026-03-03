<?php namespace Demo\Api;

use System\Classes\PluginBase;

/**
 * Demo API Plugin
 *
 * This plugin demonstrates OctoberCMS as a headless API backend.
 * No CMS templates. No Twig. Just a clean Laravel API.
 */
class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name'        => 'Demo API',
            'description' => 'Headless API backend demo — OctoberCMS without CMS module',
            'author'      => 'Fruskate',
            'icon'        => 'icon-code',
        ];
    }

    public function boot(): void
    {
        // CORS headers for Vue.js frontend (localhost:5173 in dev)
        app('router')->matched(function () {
            $response = app('response');
            $allowedOrigins = [
                'http://localhost:5173',  // Vite dev server
                'http://localhost:3000',  // Alternative dev port
                env('FRONTEND_URL', ''), // Production frontend URL
            ];

            $origin = request()->header('Origin', '');
            if (in_array($origin, $allowedOrigins)) {
                header("Access-Control-Allow-Origin: {$origin}");
                header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
                header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
                header('Access-Control-Allow-Credentials: true');
            }
        });
    }
}
