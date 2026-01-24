<?php
/**
 * Configuration helper functions and setup
 * 
 * This file contains helper functions and setup code for the application configuration.
 * It requires config.php to be loaded first to access $appConfig.
 */

// Ensure SITE_PATH is defined
if (!defined('SITE_PATH')) {
    define('SITE_PATH', dirname(__DIR__));
}

// Load helper functions
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/course_helpers.php';

// Update assets URL now that getBasePath() is available
global $appConfig;
if (function_exists('getBasePath')) {
    $appConfig['urls']['assets'] = getBasePath() . '/assets';
}

/**
 * Retrieve configuration using dot-notation keys.
 * Supports nested array access using dot notation (e.g., 'database.mysql.host').
 * 
 * @param string|null $key Configuration key in dot notation (e.g., 'app.name', 'database.mysql.host').
 *                         If null or empty string, returns entire configuration array.
 * @param mixed $default Default value to return if key is not found
 * @return mixed Configuration value if found, default value if not found, or entire config array if key is null
 * 
 * @example
 * config('app.name') // Returns 'Open Lectures'
 * config('database.mysql.host') // Returns 'localhost'
 * config('nonexistent.key', 'default') // Returns 'default'
 * config() // Returns entire $appConfig array
 */
function config($key = null, $default = null) {
    global $appConfig;

    if ($key === null || $key === '') {
        return $appConfig;
    }

    $segments = explode('.', $key);
    $value = $appConfig;

    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

// Backwards compatibility constants
define('SITE_NAME', config('app.name'));
define('DB', config('database.driver')); // 'mysql' or 'sqlite'
define('DB_PATH', config('paths.db_config'));
define('REPO_PATH', config('paths.repo'));
define('STORAGE_REPO_PATH', config('paths.storage_repo'));
define('ASSET_PATH', config('urls.assets', getBasePath() . '/assets'));

// PHP error reporting configuration
if (config('app.display_errors', true)) {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}

if (config('app.display_startup_errors', true)) {
    ini_set('display_startup_errors', 1);
} else {
    ini_set('display_startup_errors', 0);
}

error_reporting(config('app.error_reporting_level', E_ALL));

