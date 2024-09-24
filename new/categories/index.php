<?php
//Import constants file
require_once dirname(__DIR__).'/constants.php';
$title = 'Categories';
// Repo Functions here
require_once REPO_PATH;
$data = selectKategorije();
ob_start();
?>
<style>
.img {
	width: 100%;
	height: 200px;
	object-fit: cover;
}
</style>
<?php if(isset($_GET['id'])):
	$courses =selectCoursesByCategory($_GET['id']);
?>
<?php endif?>
<?php
// Single category page
if(isset($_GET['id'])):?>
<?php
	//Check if category has courses
	if(count($courses) > 1):?>
<h1 class="font-bold text-3xl my-5 text-center text-primary"> <?=$courses[0]["naziv_kategorije"]?></h1>
<?php foreach ($courses as $course) : ?>
<a href="<?=$course['course_linkPlaylist']?>" target='_blank' rel='noopener noreferrer' class="tooltip-w3 no-underline">
	<span class='tooltiptext p-1'><?=$course['course_description']?></span>
	<div class=" hover:scale-105 transition-all bg-white rounded-xl shadow-md overflow-hidden">
		<div class="relative">
			<img class="w-full h-48 object-cover" src="<?=$course['course_image']?>" alt="<?=$course['course_name']?>">
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
<?php
// if there are courses in the category
else:?>
<h1 class="font-bold text-3xl mt-5 text-center text-primary">No courses in this category</h1>
<?php endif?>
<?php
// Main category page
else:?>
<h1 class="font-bold text-3xl mt-5 text-center text-primary">Categories</h1>
<div class="container relative z-40 mx-auto mt-6">
	<div class="flex flex-wrap justify-center mx-auto lg:w-full md:5/6 xl:shadow-small-primary shadow-md">
		<?php foreach($data as $c){ ?>
		<a href="<?=SITE_URL."/category?id=". $c["idKategorije"]?>"
			class="block w-1/2 py-10 text-center border lg:w-1/4">
			<div>
				<img class="img hover:scale-105 transition-transform duration-300 ease-in-out"
					src="<?=$c["slika_kategorije"] == "" ?"../assets/images/categories/uncategorized.jpeg":"../assets/images/categories/".$c['slika_kategorije'] ?>"
					class="block mx-auto">

				<p
					class="pt-4 text-sm font-medium hover:text-primary transition-all text-md capitalize hover:underline lg:text-xl md:text-base md:pt-6">
					<?=$c['naziv_kategorije']?>
				</p>
			</div>
		</a>
		<?php } ?>
	</div>
</div>
<?php endif?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layout.php';
?>