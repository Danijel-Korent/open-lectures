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
	<?php foreach ($list as $index => $course) : ?>
	<!-- Modal -->
	<div x-data="{<?='Modal'.$index?>: false}">
		<a @click="<?='Modal'.$index?> = true" role="button" target='_blank' rel='noopener noreferrer'
			class="no-underline">
			<!-- <span class='tooltiptext p-1'><?=$course['course_description']?></span> -->
			<div class=" hover:scale-105 transition-all bg-white rounded-xl shadow-md overflow-hidden">
				<div class="relative">
					<img class="w-full h-48 object-cover" src="<?=$course['course_image']?>"
						alt="<?=$course['course_name']?>" />
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
		<!-- Modal View -->
		<div x-cloak x-show="<?='Modal'.$index?>" x-transition.opacity.duration.200ms
			x-trap.inert.noscroll="<?='Modal'.$index?>" @keydown.esc.window="<?='Modal'.$index?> = false"
			@click.self="<?='Modal'.$index?> = false"
			class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
			role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
			<!-- Modal Dialog -->
			<div x-show="<?='Modal'.$index?>"
				x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
				x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
				class="flex max-w-lg flex-col gap-4 overflow-hidden rounded-md border border-neutral-300 bg-white text-neutral-600 max-h-[90vh]">
				<!-- Dialog Header -->
				<div class="flex items-center justify-between border-b border-neutral-300 bg-neutral-50/60 p-4">
					<h3 id="defaultModalTitle" class="font-semibold tracking-wide text-neutral-900 ">
						<?=$course['course_name']?></h3>
					<button @click="<?='Modal'.$index?> = false" aria-label="close modal">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
							stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
							<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
						</svg>
					</button>
				</div>
				<!-- Dialog Body -->
				<div class="px-4 pb-2 overflow-y-auto max-h-[70vh]">
					<!-- Added max-height for scrolling -->
					<a href="<?=$course['course_linkPlaylist']?>" target="_blank">
						<div class="relative">
							<img class="w-full h-48 object-cover rounded-md" src="<?=$course['course_image']?>"
								alt="<?=$course['course_name']?>" />
							<div
								class="absolute bottom-0 right-0 bg-gray-800 text-white px-2 py-1 m-2 rounded-md text-xs">
								<?=$course['course_totalLength']?> h
							</div>
							<!-- Play Icon Overlay -->
							<div class="absolute inset-0 flex justify-center items-center">
								<svg class="w-[70px] h-[70px] text-white bg-black bg-opacity-50 rounded-full p-2"
									xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
									stroke="currentColor" stroke-width="2">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M14.752 11.168l-5.197-2.935A1 1 0 008 9.067v5.866a1 1 0 001.555.832l5.197-2.934a1 1 0 000-1.664z" />
								</svg>
							</div>
						</div>
					</a>

					<div class="py-4">
						<div class="transition-all text-lg font-medium text-gray-800">
							<?=$course['course_name']?></div>
						<p class="text-gray-500 text-sm font-bold text-left"><?=$course['course_university']?></p>
					</div>
					<p class="text-md pt-1"><?=$course['course_description']?></p>
				</div>
				<!-- Dialog Footer -->
				<div
					class="flex flex-col-reverse justify-between gap-2 border-t border-neutral-300 bg-neutral-50/60 p-4 sm:flex-row sm:items-center md:justify-end">
					<a href="<?=$course['course_linkPlaylist']?>" target="_blank" role="button"
						class="w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0">
						Play Now</a>
				</div>
			</div>
		</div>

	</div>
	<?php endforeach; ?>

</div>


<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
// Now include the layout and pass the content