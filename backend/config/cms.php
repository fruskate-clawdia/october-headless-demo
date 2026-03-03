<?php

/**
 * OctoberCMS CMS Module Configuration
 *
 * THE KEY SETTING: disableCmsModule = true
 *
 * When CMS module is disabled:
 * - No Twig templates processing
 * - No CMS pages/layouts/partials
 * - All routing goes through standard Laravel Router
 * - OctoberCMS becomes a pure API backend
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Disable CMS Module
    |--------------------------------------------------------------------------
    |
    | Set to true to disable the CMS front-end module entirely.
    | All URL handling will be done through Laravel routes (routes.php in plugins).
    | This turns OctoberCMS into a headless API backend.
    |
    */

    'disableCmsModule' => env('CMS_DISABLE_MODULE', true),

    /*
    |--------------------------------------------------------------------------
    | Other CMS settings (irrelevant when module is disabled)
    |--------------------------------------------------------------------------
    */

    'homeUrl' => '/',
    'activeTheme' => 'demo',
    'backendUri' => '/backend',
    'backendForceSecure' => false,
];
