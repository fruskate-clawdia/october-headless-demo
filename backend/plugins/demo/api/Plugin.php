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

    public function registerNavigation(): array
    {
        return [
            'todos' => [
                'label'       => 'Todo List',
                'url'         => \Backend::url('demo/api/todos'),
                'icon'        => 'icon-check-square',
                'permissions' => ['demo.api.*'],
                'order'       => 100,
                'sideMenu'    => [
                    'todos' => [
                        'label' => 'All Todos',
                        'icon'  => 'icon-list',
                        'url'   => \Backend::url('demo/api/todos'),
                    ],
                ],
            ],
        ];
    }

    public function boot(): void
    {
        // CORS headers for Vue.js frontend (localhost:5173 in dev)
        \Event::listen('Illuminate\Routing\Events\RouteMatched', function () {
            $allowedOrigins = [
                'http://localhost:5173',
                'http://localhost:3000',
                env('FRONTEND_URL', ''),
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
