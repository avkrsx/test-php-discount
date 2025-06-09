<?php

spl_autoload_register(function ($class) {
    
    $prefixes = [
        'App\\Controllers\\' => __DIR__ . '/App/Controllers/',
        'App\\Models\\'      => __DIR__ . '/App/Models/',
        'App\\Services\\'    => __DIR__ . '/App/Services/',
    ];
    
    foreach ($prefixes as $prefix => $baseDir) {
        $len = strlen($prefix);
        
        if (!str_starts_with($class, $prefix)) {
            continue;
        }
        
        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
    
});
