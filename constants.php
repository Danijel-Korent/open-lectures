<?php
// var_dump(dirname(__DIR__));
//Constants
//Set the site url
define('SITE_URL',"http://localhost/git/open-lectures/");
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

define("ASSET_PATH",SITE_URL."/assets");

//show php errors
// SECURITY ISSUE: ERROR INFORMATION DISCLOSURE
// Displaying PHP errors in production exposes sensitive information
// FIX: Set display_errors to 0 in production, use logging instead
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// echo 'Using '.DB.' database type.';