<?php
//Import constants file
require_once dirname(__DIR__,2).'/constants.php';
require_once REPO_PATH;
$catCount = countCategories();
$couCount = countCourses();
session_start();
if (empty($_SESSION['logged'])){
	header('Location: '.SITE_URL.'/admin/login',true);
	exit;
}
$title = 'Dashboard';
ob_start();
?>
<div class="px-4 py-8 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
	<div class="grid grid-cols-2 gap-8 md:grid-cols-2">
		<div class="text-center md:border-r">
			<h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl"><?=$catCount[0]['total']?></h6>
			<p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
				Categories
			</p>
		</div>
		<div class="text-center ">
			<h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl"><?=$couCount[0]['total']?></h6>
			<p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
				Courses
			</p>
		</div>
	</div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../partials/admin_layout.php';
?>