<?php
//Import constants file
require_once dirname(__DIR__).'/constants.php';
$title = 'Stats';
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
<h1 class="font-bold text-3xl mt-5 text-center text-primary">Statistics</h1>
<div x-data="{ selectedTab: 'categories' }" class="w-full">
	<?php include_once 'tabs.php'; ?>
	<div class="px-2 py-4 text-neutral-600 ">
		<!-- Categories -->
		<div x-cloak x-show="selectedTab === 'categories'" id="tabpanelGroups" role="tabpanel" aria-label="categories">
			<div class="container relative z-40 mx-auto mt-6">
				<div
					class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 justify-center mx-auto w-full xl:shadow-small-primary">
					<?php foreach($data as $c){ ?>
					<article
						class="hover:scale-105 transition-all group m-1 flex rounded-md max-w-sm flex-col overflow-hidden border border-neutral-300 bg-neutral-50 text-neutral-600">
						<div class="flex flex-col gap-4 p-6">
							<h3 class="text-balance text-center text-xl lg:text-2xl font-bold text-neutral-900"
								aria-describedby="tripDescription">
								<?= "category_name"//htmlspecialchars($c['category_name']) ?>
							</h3>

							<div class="mx-auto w-full">
								<div class="grid grid-cols-2 gap-8">
									<div class="text-center flex flex-col justify-center gap-2 pr-5 md:border-r">
										<h6 class="text-xl font-bold"><?= $c['courses_count'] ?? 5 ?></h6>
										<p
											class="text-xs font-medium tracking-widest text-gray-800 uppercase lg:text-base">
											Courses
										</p>
									</div>
									<div class="text-center flex flex-col justify-center gap-2">
										<h6 class="text-xl font-bold"><?= $c['hours'] ?? '143h' ?></h6>
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

		</div>


	</div>
</div>



<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layout.php';
?>