<?php
if (!isset($course) || !isset($index)) {
	return;
}

$modalKey = 'Modal' . $index;
$brokenId = 'broken-count-' . ($course['course_id'] ?? 'unknown') . '-' . $index;
$viewsId = 'views-count-' . ($course['course_id'] ?? 'unknown') . '-' . $index;
?>
<!-- Modal View -->
<div x-cloak x-show="<?=$modalKey?>" x-transition.opacity.duration.200ms
	x-trap.inert.noscroll="<?=$modalKey?>" @keydown.esc.window="<?=$modalKey?> = false"
	@click.self="<?=$modalKey?> = false"
	class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
	role="dialog" aria-modal="true" aria-labelledby="courseModalTitle-<?=$index?>">
	<!-- Modal Dialog -->
	<div x-show="<?=$modalKey?>"
		x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
		x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
		class="flex max-w-lg flex-col gap-4 overflow-hidden rounded-md border border-neutral-300 bg-white text-neutral-600 max-h-[90vh]">
		<!-- Dialog Header -->
		<div class="flex items-center justify-between border-b border-neutral-300 bg-neutral-50/60 p-4">
			<h3 id="courseModalTitle-<?=$index?>" class="font-semibold tracking-wide text-neutral-900 ">
				<?=$course['course_name']?></h3>
			<button @click="<?=$modalKey?> = false" aria-label="close modal">
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
					<div class="absolute bottom-0 right-0 bg-gray-800 text-white px-2 py-1 m-2 rounded-md text-xs">
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
				<p class="text-gray-400 text-xs mt-1">
					Views: <span id="<?=$viewsId?>"><?=$course['views'] ?? 0?></span>
				</p>
			</div>
			<p class="text-md pt-1"><?=$course['course_description']?></p>
		</div>
		<!-- Dialog Footer -->
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

