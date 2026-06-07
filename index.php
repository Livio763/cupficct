<?php

/**
 * Laravel - Azure App Service Bridge
 * 
 * This file serves as a bridge so Azure can serve Laravel from the root
 * while Laravel's actual entry point is in the public/ directory.
 */

// Serve the actual Laravel application from the public folder
$publicPath = __DIR__ . '/public';

if (is_dir($publicPath)) {
    // Change to public directory
    chdir($publicPath);
    
    // Include Laravel's front controller
    require $publicPath . '/index.php';
} else {
    // Fallback: try to serve directly
    require __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    $response->send();
    $kernel->terminate($request, $response);
}
