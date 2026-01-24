<?php
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
            'file' => __DIR__ . '/database/op.sqlite',
            'schema' => __DIR__ . '/database/sqlite_schema.sql',
            'permissions' => 0666,
        ],
    ],
    'paths' => [
        'db_config' => __DIR__ . '/database/config.php',
        'repo' => __DIR__ . '/database/repo.php',
        'storage_repo' => __DIR__ . '/database/storage.php',
        'assets_dir' => __DIR__ . '/assets',
        'uploads' => [
            'categories' => __DIR__ . '/assets/images/categories',
            'lecturer' => __DIR__ . '/assets/images/lecturer',
            'university' => __DIR__ . '/assets/images/uni',
        ],
    ],
    'urls' => [
        'assets' => '', // Will be set by config_helpers.php after getBasePath() is available
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

// Load configuration helpers (defines constants, functions, and sets up error reporting)
require_once __DIR__ . '/helpers/config_helpers.php';

