<?php
//Import constants file
require_once __DIR__.'/constants.php';
$title = 'Home Page';
// Database Repo Functions here
require_once REPO_PATH;
$arrayOpisPred = selectOpisPred();
$all_total_length = 0;
$all_courses = 0;
//Get University list
$university_list = selectUstanove();
$list =[];
//Loop through the array and calculate the total length of all courses
foreach ($arrayOpisPred as $course)
{
  $course_totalLength  = $course['ukupno_trajanje'];
  $all_courses++;
  $all_total_length += $course_totalLength;
  $university_index  = $course['ustanova'] - 1;
  $course_university = $university_list[$university_index]['naziv_ustanove'];
  $data=[
	'course_name' => $course['naziv_predavanja'],
	'course_description' => $course['opis_kolegija'],
	'course_totalLength' => $course['ukupno_trajanje'],
	'course_linkPlaylist' => $course['link_1'],
	'course_image' => $course['image'],
	'course_university' =>$course_university,
	'university_index' => $university_index 
  ];
  
	array_push($list, $data);
}
ob_start();
?>
<!-- CSS import -->
<link rel="stylesheet" href="assets/css/tooltip.css?l=" .<?=date("d m Y")?>>
<!-- Hero Section -->
<section
	class="md:pt-[2%] w-full flex-col flex-col-reverse md:flex-row flex justify-center px-2 lg:px-10 items-center pt-5 gap-2 lg:gap-12">
	<div class="lg:pl-[2%] lg:w-[50%]">
		<p class="text-lg">
			Dobrodošli! "Otvorena Predavanja" je projekt koji mapira i na jednom mjestu objedinjuje popis besplatnih
			sveučilišnih predavanja/kolegija koji su javno dostupni na platformi "Youtube". Cilj je napraviti
			interaktivnu verziju ovog popisa: <a style="color:blue;" target="_blank"
				href="https://hr.wikipedia.org/wiki/Suradnik:Danijel.Korent/Popis_besplatnih_i_javno_dostupnih_sveu%C4%8Dili%C5%A1nih_video_predavanja">Popis
				besplatnih i javno dostupnih sveučilišnih video predavanja – Wikipedija</a>
		</p>
		<br />
		<p class="text-lg">
			Do sada su mapirani kolegiji s više od 15 svjetski poznatih sveučilišta poput MIT, Yale, Harvard, Oxford,
			ETH Zürich, Stanford, Berkely, etc. Svaki kolegij u prosjeku sadrži 20-30 predavanja u trajanju od jednog
			školskog sata. Konačni cilj projekta je da interaktivna verzija ima dodatne mogućnosti naspram statične wiki
			stranice - poput ocjenjivanja, komentiranja, filtriranja po profesorima/sveučilištima i sl.
		</p>
	</div>
	<div class="flex justify-center items-center">
		<img class="w-[85%] h-[85%] md:h-[50%] md:w-[50%]" src="assets/images/icon.svg" alt="image" id="image">
	</div>

</section>
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
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
// Now include the layout and pass the content