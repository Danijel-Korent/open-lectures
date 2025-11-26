<?php
/**
 * Helper functions for URL and path generation
 */

// Ensure SITE_PATH is defined
if (!defined('SITE_PATH')) {
    define('SITE_PATH', __DIR__);
}

/**
 * Get the base path of the application dynamically.
 * Detects subdirectory deployment by comparing constants.php location with document root.
 * @return string Base path (e.g., '/git/open-lectures')
 */
function getBasePath() {
    static $basePath = null;

    if ($basePath !== null) {
        return $basePath;
    }

    $appRoot = str_replace('\\', '/', SITE_PATH);
    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) : '';

    if (!empty($docRoot) && strpos($appRoot, $docRoot) === 0) {
        $basePath = substr($appRoot, strlen($docRoot));
    } else {
        $basePath = '';
    }

    $basePath = trim($basePath, '/');
    if (!empty($basePath) && substr($basePath, 0, 1) !== '/') {
        $basePath = '/' . $basePath;
    }

    return $basePath;
}

/**
 * Generate a URL path relative to the base path.
 * @param string $path Path to append (should start with /)
 * @return string Full path relative to base
 */
function baseUrl($path = '') {
    $base = getBasePath();
    if (empty($path)) {
        return $base . '/';
    }

    if (substr($path, 0, 1) !== '/') {
        $path = '/' . $path;
    }

    return $base . $path;
}

