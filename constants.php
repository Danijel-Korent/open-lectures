<?php
// var_dump(dirname(__DIR__));
//Constants
//Set the site name
define('SITE_NAME',"Open Lectures");
//Set DB type
define('DB','sqlite'); // 'mysql' or 'sqlite'

/// DO NOT EDIT ///////////////////////
//Set the site path
define('SITE_PATH',__DIR__);
//Ser DB Config path
define('DB_PATH',SITE_PATH.'/database/config.php');
//Set Repo Path
define('REPO_PATH',SITE_PATH.'/database/repo.php');
define('STORAGE_REPO_PATH',SITE_PATH.'/database/storage.php');

/**
 * Get the base path of the application dynamically
 * Detects subdirectory deployment by comparing constants.php location with document root
 * @return string Base path (e.g., '/git/open-lectures')
 */
function getBasePath() {
    static $basePath = null;
    
    // Cache the result to avoid recalculating
    if ($basePath !== null) {
        return $basePath;
    }
    
    // Get the directory where constants.php is located (application root)
    $appRoot = str_replace('\\', '/', SITE_PATH);
    
    // Get document root
    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) : '';
    
    // Calculate relative path from document root to application root
    if (!empty($docRoot) && strpos($appRoot, $docRoot) === 0) {
        $basePath = substr($appRoot, strlen($docRoot));
    } else {
        // Fallback: empty string (assume root deployment)
        $basePath = '';
    }
    
    // Normalize: ensure leading slash, remove trailing slash
    $basePath = trim($basePath, '/');
    if (!empty($basePath) && substr($basePath, 0, 1) !== '/') {
        $basePath = '/' . $basePath;
    }
    
    return $basePath;
}

/**
 * Generate a URL path relative to the base path
 * @param string $path Path to append (should start with /)
 * @return string Full path relative to base
 */
function baseUrl($path = '') {
    $base = getBasePath();
    if (empty($path)) {
        return $base . '/';
    }
    
    // Ensure path starts with /
    if (substr($path, 0, 1) !== '/') {
        $path = '/' . $path;
    }
    
    return $base . $path;
}

define("ASSET_PATH", getBasePath()."/assets");

//show php errors
// SECURITY ISSUE: ERROR INFORMATION DISCLOSURE
// Displaying PHP errors in production exposes sensitive information
// FIX: Set display_errors to 0 in production, use logging instead
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// echo 'Using '.DB.' database type.';
