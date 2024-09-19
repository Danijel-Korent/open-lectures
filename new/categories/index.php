<?php
//Import constants file
require_once dirname(__DIR__).'/constants.php';
$title = 'Categories';
// Repo Functions here
require_once REPO_PATH;
$data = selectKategorije();
ob_start();
?>
<div>
	Categories Page
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layout.php';