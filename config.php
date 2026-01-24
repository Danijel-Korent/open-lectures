<?php
// Core path constant
define('SITE_PATH', __DIR__);

// Load helper functions
require_once __DIR__ . '/helpers/helpers.php';
require_once __DIR__ . '/helpers/course_helpers.php';

// Unified application configuration
$appConfig = [
    'app' => [
        'name' => 'Open Lectures',
        'display_errors' => true,
        'display_startup_errors' => true,
        'error_reporting_level' => E_ALL,
    ],
    'database' => [
        'driver' => 'sqlite', // Supported: mysql, sqlite
        'mysql' => [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'op',
            'port' => 3306,
            'charset' => 'utf8mb4',
        ],
        'sqlite' => [
            'file' => SITE_PATH . '/database/op.sqlite',
            'schema' => SITE_PATH . '/database/sqlite_schema.sql',
            'permissions' => 0666,
        ],
    ],
    'paths' => [
        'db_config' => SITE_PATH . '/database/config.php',
        'repo' => SITE_PATH . '/database/repo.php',
        'storage_repo' => SITE_PATH . '/database/storage.php',
        'assets_dir' => SITE_PATH . '/assets',
        'uploads' => [
            'categories' => SITE_PATH . '/assets/images/categories',
            'lecturer' => SITE_PATH . '/assets/images/lecturer',
            'university' => SITE_PATH . '/assets/images/uni',
        ],
    ],
    'urls' => [
        'assets' => getBasePath() . '/assets',
    ],
    'analytics' => [
        'code' => <<<'ANALYTICS'

        <script>
        // Paste your analytics JavaScript code here
        // Leave empty to disable tracking
        </script>
        
        ANALYTICS
    ],
];

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
define('ASSET_PATH', config('urls.assets'));

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

