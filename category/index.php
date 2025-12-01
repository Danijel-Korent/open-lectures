<?php
//Import constants file
require_once dirname(__DIR__).'/config.php';
$title = 'Categories';
// Repo Functions here
require_once REPO_PATH;
if(!isset($_GET['id'])){
	//redirect to main categories page
	header("Location: ".baseUrl('/categories'));
}
$data = selectCoursesByCategory($_GET['id']);
ob_start();
?>
<?php
	//Check if category has courses
if(count($data['courses']) > 1):?>
<?php
$courseData = transformCoursesForDisplay($data['courses']);
$list = $courseData['courses'];
$all_courses = $courseData['total_courses'];
$all_total_length = $courseData['total_hours'];
?>
<!-- CSS import -->
<link rel="stylesheet" href="../assets/css/tooltip.css?l=" .<?=date("d m Y")?>>
<h1 class="font-bold text-4xl my-5 text-center text-primary"> <?=$data['category']["name"]?></h1>
<?php
$total_courses = $all_courses;
$total_hours = $all_total_length;
include SITE_PATH . '/partials/course_stats.php';
?>

<?php
$courses = $list;
include SITE_PATH . '/partials/course_grid.php';
?>
<?php
// if there are courses in the category
else:?>
<div class="w-full flex flex-col justify-center items-center gap-2">
	<h1 class="font-bold text-3xl mt-5 text-center text-primary">No courses in this category</h1>
	<a href="<?=baseUrl('/categories')?>" role="button"
		class="cursor-pointer whitespace-nowrap rounded-md bg-primary opacity- px-4 py-2 text-base font-medium tracking-wide text-white transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
		Go Back</a>
</div>
<?php endif?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layout.php';
?>