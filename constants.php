<?php
// var_dump(dirname(__DIR__));
//Constants
//Set the site url
define('SITE_URL',"http://localhost/op/");
//Set the site name
define('SITE_NAME',"Open Lectures");

/// DO NOT EDIT ///////////////////////
//Set the site path
define('SITE_PATH',__DIR__);
//Ser DB Config path
define('DB_PATH',SITE_PATH.'/database/config.php');
//Set Repo Path
define('REPO_PATH',SITE_PATH.'/database/repo.php');
define('STORAGE_REPO_PATH',SITE_PATH.'/database/storage.php');

define("ASSET_PATH",SITE_URL."/assets");