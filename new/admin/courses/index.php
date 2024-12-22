<?php
//Import constants file
require_once dirname(__DIR__,2).'/constants.php';
session_start();
if (empty($_SESSION['logged'])){
	header('Location: '.SITE_URL.'/admin/login',true);
	exit;
}
$title = 'Course';
ob_start();
?>
Add Courses

<?php
$content = ob_get_clean();
include __DIR__ . '/../../partials/admin_layout.php';
?>