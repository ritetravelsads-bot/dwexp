<?php
/**
 * Load environment variables from .env file
 * 
 * This file helps load credentials securely from a .env file
 * instead of hardcoding them in the PHP code.
 */

// Function to load environment variables
function loadEnv() {
    $envFile = __DIR__ . '/.env';
    
    if (!file_exists($envFile)) {
        return;
    }
    
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Skip comments
        if (strpos($line, '#') === 0) {
            continue;
        }
        
        // Parse KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Set as environment variable
            if (!getenv($key)) {
                putenv("{$key}={$value}");
            }
        }
    }
}

// Load environment variables on include
loadEnv();
?>