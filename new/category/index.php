<?php
//Import constants file
require_once dirname(__DIR__).'/constants.php';
$title = 'Categories';
// Repo Functions here
require_once REPO_PATH;
if(!isset($_GET['id'])){
	//redirect to main categories page
	header("Location: ".SITE_URL."/categories");
}
$data = selectCoursesByCategory($_GET['id']);
ob_start();
?>
<?php
	//Check if category has courses
if(count($data['courses']) > 1):?>
<?php
$all_total_length = 0;
$all_courses = 0;
//Get University list
$university_list = selectUstanove();
$list =[];
//Loop through the array and calculate the total length of all courses
foreach ($data['courses'] as $course)
{
  $course_totalLength  = $course['ukupno_trajanje'];
  $all_courses++;
  $all_total_length += $course_totalLength;
  $university_index  = $course['ustanova'] - 1;
  $course_university = $university_list[$university_index]['naziv_ustanove'];
  $f_data=[
	'course_name' => $course['naziv_predavanja'],
	'course_description' => $course['opis_kolegija'],
	'course_totalLength' => $course['ukupno_trajanje'],
	'course_linkPlaylist' => $course['link_1'],
	'course_image' => $course['image'],
	'course_university' =>$course_university,
	'university_index' => $university_index 
  ];
	array_push($list, $f_data);
}
?>
<!-- CSS import -->
<link rel="stylesheet" href="../assets/css/tooltip.css?l=" .<?=date("d m Y")?>>
<h1 class="font-bold text-4xl my-5 text-center text-primary"> <?=$data['category']["naziv_kategorije"]?></h1>
<!-- Stats Hero -->
<div class="px-4 py-8 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
	<div class="grid grid-cols-2 gap-8 md:grid-cols-2">
		<div class="text-center md:border-r">
			<h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl"><?=$all_courses?></h6>
			<p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
				Ukupno kolegija
			</p>
		</div>
		<div class="text-center ">
			<h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl"><?=$all_total_length?>h</h6>
			<p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
				Ukupno sati
			</p>
		</div>
	</div>
</div>
<!-- Lesson Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6 md:px-20">
	<?php foreach ($list as $course) : ?>
	<a href="<?=$course['course_linkPlaylist']?>" target='_blank' rel='noopener noreferrer'
		class="tooltip-w3 no-underline">
		<span class='tooltiptext p-1'><?=$course['course_description']?></span>
		<div class=" hover:scale-105 transition-all bg-white rounded-xl shadow-md overflow-hidden">
			<div class="relative">
				<img class="w-full h-48 object-cover" src="<?=$course['course_image']?>"
					alt="<?=$course['course_name']?>">
				<!-- <div class="absolute top-0 right-0 bg-indigo-500 text-white font-bold px-2 py-1 m-2 rounded-md">New
					</div> -->
				<div class="absolute bottom-0 right-0 bg-gray-800 text-white px-2 py-1 m-2 rounded-md text-xs">
					<?=$course['course_totalLength']?> h </div>
			</div>
			<div class="p-4">
				<div class="hover:underline transition-all text-lg font-medium text-gray-800 mb-2">
					<?=$course['course_name']?></div>
				<p class="text-gray-500 text-sm font-bold text-left"><?=$course['course_university']?></p>
				<p class="text-gray-500 pt-2 text-sm"><?=truncateString($course['course_description'],180)?></p>
			</div>
		</div>
	</a>
	<?php endforeach; ?>

</div>
<?php
// if there are courses in the category
else:?>
<div class="w-full flex flex-col justify-center items-center gap-2">
	<h1 class="font-bold text-3xl mt-5 text-center text-primary">No courses in this category</h1>
	<a href="<?=SITE_URL.'/categories'?>" role="button"
		class="cursor-pointer whitespace-nowrap rounded-md bg-primary opacity- px-4 py-2 text-base font-medium tracking-wide text-white transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
		Go Back</a>
</div>
<?php endif?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layout.php';
?>