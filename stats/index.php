<?php
//Import constants file
require_once dirname(__DIR__).'/config.php';
$title = 'Stats';
// Repo Functions here
require_once REPO_PATH;
$catData = countCoursesAndHoursByCategory();
$uniData = countCoursesAndHoursByUniversity();
$topDescriptionViews = getTopCoursesByDescriptionViews(10);
$topVideoViews = getTopCoursesByVideoViews(10);

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
<h1 class="font-bold text-3xl mt-5 text-center text-primary">Statistics</h1>
<div x-data="{ selectedTab: 'categories' }" class="w-full">
	<?php include_once 'tabs.php'; ?>
	<div class="px-2 py-4 text-neutral-600 ">
		<!-- Categories -->
		<div x-cloak x-show="selectedTab === 'categories'" id="tabpanelGroups" role="tabpanel" aria-label="categories">
			<div class="container relative z-40 mx-auto mt-6">
				<div
					class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 justify-center mx-auto w-full xl:shadow-small-primary">
					<?php foreach($catData as $c){ ?>
					<article
						class="hover:scale-105 transition-all group m-1 flex rounded-md max-w-sm flex-col overflow-hidden border border-neutral-300 bg-neutral-50 text-neutral-600">
						<div class="flex flex-col justify-between h-full items-center p-2 md:p-6">
							<h3 class="text-balance text-center text-ellipsis text-md md:text-xl lg:text-2xl font-bold text-neutral-900"
								aria-describedby="tripDescription">
								<?= $c['name']?>
							</h3>
							<!-- divider -->
							<div class="w-full h-[0.8px] bg-neutral-300 my-2"></div>
							<div class="mx-auto w-full">
								<div class="grid grid-cols-2 gap-8">
									<div class="text-center flex flex-col justify-center gap-2 pr-5 md:border-r">
										<h6 class="text-xl font-bold"><?= $c['courses_count']?></h6>
										<p
											class="text-xs font-medium tracking-widest text-gray-800 uppercase lg:text-base">
											Courses
										</p>
									</div>
									<div class="text-center flex flex-col justify-center gap-2">
										<h6 class="text-xl font-bold"><?= $c['hours'] ?>h</h6>
										<p
											class="text-xs font-medium tracking-widest text-gray-800 uppercase lg:text-base">
											Hours
										</p>
									</div>
								</div>
							</div>
						</div>
					</article>
					<?php } ?>
				</div>
			</div>

		</div>
		<!-- Universities -->
		<div x-cloak x-show="selectedTab === 'uni'" id="tabpanelLikes" role="tabpanel" aria-label="uni">
			<div class="container relative z-40 mx-auto mt-6">
				<div
					class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 justify-center mx-auto w-full xl:shadow-small-primary">
					<?php foreach($uniData as $c){ ?>
					<article
						class="hover:scale-105 transition-all group m-1 flex rounded-md max-w-sm flex-col overflow-hidden border border-neutral-300 bg-neutral-50 text-neutral-600">
						<div class="flex flex-col justify-between h-full items-center p-2 md:p-6">
							<h3 class="text-balance text-center text-ellipsis text-md md:text-xl lg:text-2xl font-bold text-neutral-900"
								aria-describedby="tripDescription">
								<?= $c['name']?>
							</h3>
							<!-- divider -->
							<div class="w-full h-[0.8px] bg-neutral-300 my-2"></div>
							<div class="mx-auto w-full">
								<div class="grid grid-cols-2 gap-5">
									<div class="text-center flex flex-col justify-center gap-2 pr-5 md:border-r">
										<h6 class="text-xl font-bold"><?= $c['courses_count']?></h6>
										<p
											class="text-xs font-medium tracking-widest text-gray-800 uppercase lg:text-base">
											Courses
										</p>
									</div>
									<div class="text-center flex flex-col justify-center gap-2">
										<h6 class="text-xl font-bold"><?= $c['hours'] ?>h</h6>
										<p
											class="text-xs font-medium tracking-widest text-gray-800 uppercase lg:text-base">
											Hours
										</p>
									</div>
								</div>
							</div>
						</div>
					</article>
					<?php } ?>
				</div>
			</div>
		</div>
		<!-- Views -->
		<div x-cloak x-show="selectedTab === 'views'" id="tabpanelViews" role="tabpanel" aria-label="views">
			<div class="container relative z-40 mx-auto mt-6">
				<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
					<!-- Top 10 Description Views -->
					<div class="bg-white rounded-lg shadow-md p-6">
						<h2 class="text-2xl font-bold text-primary mb-4">Top 10 Description Views</h2>
						<div class="space-y-3">
							<?php 
							$rank = 1;
							foreach($topDescriptionViews as $course): 
								$views = (int)($course['views'] ?? 0);
							?>
							<div class="flex items-center gap-4 p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 transition-colors">
								<div class="flex-shrink-0 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-bold">
									<?= $rank ?>
								</div>
								<div class="flex-1 min-w-0">
									<h3 class="font-semibold text-gray-900 truncate"><?= htmlspecialchars($course['name'] ?? 'Unknown Course') ?></h3>
									<p class="text-sm text-gray-600 truncate"><?= htmlspecialchars($course['u_name'] ?? 'Unknown University') ?></p>
								</div>
								<div class="flex-shrink-0 text-right">
									<div class="text-lg font-bold text-primary"><?= number_format($views) ?></div>
									<div class="text-xs text-gray-500">views</div>
								</div>
							</div>
							<?php 
							$rank++;
							endforeach; 
							if (empty($topDescriptionViews)):
							?>
							<p class="text-gray-500 text-center py-4">No description views recorded yet.</p>
							<?php endif; ?>
						</div>
					</div>
					
					<!-- Top 10 Video Views -->
					<div class="bg-white rounded-lg shadow-md p-6">
						<h2 class="text-2xl font-bold text-primary mb-4">Top 10 Video Views</h2>
						<div class="space-y-3">
							<?php 
							$rank = 1;
							foreach($topVideoViews as $course): 
								$videoViews = (int)($course['video_views'] ?? 0);
							?>
							<div class="flex items-center gap-4 p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 transition-colors">
								<div class="flex-shrink-0 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-bold">
									<?= $rank ?>
								</div>
								<div class="flex-1 min-w-0">
									<h3 class="font-semibold text-gray-900 truncate"><?= htmlspecialchars($course['name'] ?? 'Unknown Course') ?></h3>
									<p class="text-sm text-gray-600 truncate"><?= htmlspecialchars($course['u_name'] ?? 'Unknown University') ?></p>
								</div>
								<div class="flex-shrink-0 text-right">
									<div class="text-lg font-bold text-primary"><?= number_format($videoViews) ?></div>
									<div class="text-xs text-gray-500">views</div>
								</div>
							</div>
							<?php 
							$rank++;
							endforeach; 
							if (empty($topVideoViews)):
							?>
							<p class="text-gray-500 text-center py-4">No video views recorded yet.</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>
</div>



<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layout.php';
?>