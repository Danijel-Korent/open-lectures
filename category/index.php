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
$all_total_length = 0;
$all_courses = 0;
//Get University list
$university_list = selectUstanove();
$list =[];
//Loop through the array and calculate the total length of all courses
foreach ($data['courses'] as $course)
{
  $course_totalLength  = $course['t_duration'];
  $all_courses++;
  $all_total_length += $course_totalLength;
  $university_index  = $course['ustanova'] - 1;
  $course_university = $university_list[$university_index]['name'];

  $f_data=[
	'course_id' => $course['id'],
	'course_name' => $course['name'],
	'course_description' => $course['description'],
	'course_totalLength' => $course['t_duration'],
	'course_linkPlaylist' => $course['link_1'],
	'course_image' => $course['image'],
	'course_university' =>$course_university,
	'university_index' => $university_index,
	'broken_reports' => (int)($course['broken_reports'] ?? 0)
  ];
	array_push($list, $f_data);
}
?>
<!-- CSS import -->
<link rel="stylesheet" href="../assets/css/tooltip.css?l=" .<?=date("d m Y")?>>
<h1 class="font-bold text-4xl my-5 text-center text-primary"> <?=$data['category']["name"]?></h1>
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
				<?php $brokenId = 'broken-count-' . $course['course_id'] . '-' . $index; ?>
				<div
					class="flex flex-col gap-3 border-t border-neutral-300 bg-neutral-50/60 p-4 sm:flex-row sm:items-center sm:justify-between">
					<div class="flex w-full flex-col gap-2 sm:w-auto">
						<button type="button"
							class="w-full rounded-md border border-primary px-4 py-2 text-sm font-medium text-primary transition hover:bg-primary/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed"
							data-report-course="<?=$course['course_id']?>" data-report-target="<?=$brokenId?>"
							data-report-label="Report broken link">
							Report broken link
						</button>
						<p class="text-center text-xs text-neutral-500">
							Broken reports:
							<span id="<?=$brokenId?>"><?=$course['broken_reports']?></span>
						</p>
					</div>
					<a href="<?=$course['course_linkPlaylist']?>" target="_blank" role="button"
						class="w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 sm:w-auto">
						Play Now</a>
				</div>
			</div>
		</div>

	</div>
	<?php endforeach; ?>

</div>
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