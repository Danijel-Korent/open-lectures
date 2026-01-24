<?php
require_once dirname(__DIR__, 2) . '/config.php';
require_once REPO_PATH;
session_start();

if (empty($_SESSION['logged'])) {
	header('Location: ' . baseUrl('/admin/login'), true);
	exit;
}

$title = 'Statistics';
$error = '';
$success = '';

// Handle reset requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$action = $_POST['action'] ?? '';
	$confirm = $_POST['confirm'] ?? '';
	
	if ($confirm !== 'RESET') {
		$error = 'Please type "RESET" to confirm the action.';
	} else {
		switch ($action) {
			case 'reset_description_views':
				$result = resetAllDescriptionViews();
				if ($result) {
					$success = 'All description views have been reset successfully.';
				} else {
					$error = 'Failed to reset description views.';
				}
				break;
				
			case 'reset_video_views':
				$result = resetAllVideoViews();
				if ($result) {
					$success = 'All video views have been reset successfully.';
				} else {
					$error = 'Failed to reset video views.';
				}
				break;
				
			case 'reset_broken_reports':
				$result = resetAllBrokenReports();
				if ($result) {
					$success = 'All broken link reports have been reset successfully.';
				} else {
					$error = 'Failed to reset broken link reports.';
				}
				break;
				
			default:
				$error = 'Invalid action.';
		}
	}
}

// Get current totals
$totalDescriptionViews = getTotalDescriptionViews();
$totalVideoViews = getTotalVideoViews();
$totalBrokenReports = getTotalBrokenReports();

// Get courses with broken reports
$coursesWithBrokenReports = getCoursesWithBrokenReports();

ob_start();
?>
<div class="max-w-4xl mx-auto mt-8">
	<h1 class="text-3xl font-bold text-center mb-8 text-primary">Statistics & Counters</h1>
	
	<?php if ($error): ?>
		<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
			<?= htmlspecialchars($error) ?>
		</div>
	<?php endif; ?>
	
	<?php if ($success): ?>
		<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
			<?= htmlspecialchars($success) ?>
		</div>
	<?php endif; ?>
	
	<!-- Statistics Overview -->
	<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
		<!-- Description Views Card -->
		<div class="bg-white border border-neutral-300 rounded-lg p-6 shadow-sm">
			<div class="flex items-center justify-between mb-4">
				<h2 class="text-lg font-semibold text-gray-800">Description Views</h2>
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
					<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
					<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
				</svg>
			</div>
			<div class="text-3xl font-bold text-primary mb-2"><?= number_format($totalDescriptionViews) ?></div>
			<p class="text-sm text-gray-600">Total description views across all courses</p>
		</div>
		
		<!-- Video Views Card -->
		<div class="bg-white border border-neutral-300 rounded-lg p-6 shadow-sm">
			<div class="flex items-center justify-between mb-4">
				<h2 class="text-lg font-semibold text-gray-800">Video Views</h2>
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
					<path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 0 1 0 1.971l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
				</svg>
			</div>
			<div class="text-3xl font-bold text-primary mb-2"><?= number_format($totalVideoViews) ?></div>
			<p class="text-sm text-gray-600">Total video link clicks across all courses</p>
		</div>
		
		<!-- Broken Reports Card -->
		<div class="bg-white border border-neutral-300 rounded-lg p-6 shadow-sm">
			<div class="flex items-center justify-between mb-4">
				<h2 class="text-lg font-semibold text-gray-800">Broken Reports</h2>
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-600">
					<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
				</svg>
			</div>
			<div class="text-3xl font-bold text-red-600 mb-2"><?= number_format($totalBrokenReports) ?></div>
			<p class="text-sm text-gray-600">Total broken link reports across all courses</p>
		</div>
	</div>
	
	<!-- Reset Actions -->
	<div class="bg-white border border-neutral-300 rounded-lg p-6 shadow-sm">
		<h2 class="text-xl font-bold text-gray-800 mb-4">Reset Counters</h2>
		<p class="text-sm text-gray-600 mb-6">Warning: Resetting counters will permanently set all values to 0. This action cannot be undone.</p>
		
		<div class="space-y-4">
			<!-- Reset Description Views -->
			<div x-data="{ showConfirm: false }" class="border border-neutral-200 rounded-lg p-4">
				<div class="flex items-center justify-between">
					<div>
						<h3 class="font-semibold text-gray-800">Reset Description Views</h3>
						<p class="text-sm text-gray-600">Reset all description view counters to 0</p>
					</div>
					<button 
						@click="showConfirm = !showConfirm"
						class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm font-medium">
						Reset
					</button>
				</div>
				<form x-show="showConfirm" method="post" class="mt-4 space-y-3" @click.outside="showConfirm = false">
					<input type="hidden" name="action" value="reset_description_views">
					<div>
						<label for="confirm_desc" class="block text-sm font-medium text-gray-700 mb-1">
							Type "RESET" to confirm:
						</label>
						<input 
							type="text" 
							id="confirm_desc" 
							name="confirm" 
							required
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
							placeholder="RESET">
					</div>
					<div class="flex gap-2">
						<button 
							type="submit"
							class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm font-medium">
							Confirm Reset
						</button>
						<button 
							type="button"
							@click="showConfirm = false"
							class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors text-sm font-medium">
							Cancel
						</button>
					</div>
				</form>
			</div>
			
			<!-- Reset Video Views -->
			<div x-data="{ showConfirm: false }" class="border border-neutral-200 rounded-lg p-4">
				<div class="flex items-center justify-between">
					<div>
						<h3 class="font-semibold text-gray-800">Reset Video Views</h3>
						<p class="text-sm text-gray-600">Reset all video view counters to 0</p>
					</div>
					<button 
						@click="showConfirm = !showConfirm"
						class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm font-medium">
						Reset
					</button>
				</div>
				<form x-show="showConfirm" method="post" class="mt-4 space-y-3" @click.outside="showConfirm = false">
					<input type="hidden" name="action" value="reset_video_views">
					<div>
						<label for="confirm_video" class="block text-sm font-medium text-gray-700 mb-1">
							Type "RESET" to confirm:
						</label>
						<input 
							type="text" 
							id="confirm_video" 
							name="confirm" 
							required
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
							placeholder="RESET">
					</div>
					<div class="flex gap-2">
						<button 
							type="submit"
							class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm font-medium">
							Confirm Reset
						</button>
						<button 
							type="button"
							@click="showConfirm = false"
							class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors text-sm font-medium">
							Cancel
						</button>
					</div>
				</form>
			</div>
			
			<!-- Reset Broken Reports -->
			<div x-data="{ showConfirm: false }" class="border border-neutral-200 rounded-lg p-4">
				<div class="flex items-center justify-between">
					<div>
						<h3 class="font-semibold text-gray-800">Reset Broken Reports</h3>
						<p class="text-sm text-gray-600">Reset all broken link report counters to 0</p>
					</div>
					<button 
						@click="showConfirm = !showConfirm"
						class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm font-medium">
						Reset
					</button>
				</div>
				<form x-show="showConfirm" method="post" class="mt-4 space-y-3" @click.outside="showConfirm = false">
					<input type="hidden" name="action" value="reset_broken_reports">
					<div>
						<label for="confirm_broken" class="block text-sm font-medium text-gray-700 mb-1">
							Type "RESET" to confirm:
						</label>
						<input 
							type="text" 
							id="confirm_broken" 
							name="confirm" 
							required
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
							placeholder="RESET">
					</div>
					<div class="flex gap-2">
						<button 
							type="submit"
							class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm font-medium">
							Confirm Reset
						</button>
						<button 
							type="button"
							@click="showConfirm = false"
							class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors text-sm font-medium">
							Cancel
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- Courses with Broken Reports -->
	<div class="bg-white border border-neutral-300 rounded-lg p-6 shadow-sm mt-8">
		<h2 class="text-xl font-bold text-gray-800 mb-4">Courses with Broken Link Reports</h2>
		<p class="text-sm text-gray-600 mb-6">List of all courses that have been reported as having broken links, sorted by number of reports.</p>
		
		<?php if (empty($coursesWithBrokenReports)): ?>
			<div class="text-center py-8 text-gray-500">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mx-auto mb-2 text-gray-400">
					<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
				</svg>
				<p>No courses with broken link reports.</p>
			</div>
		<?php else: ?>
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-neutral-200">
					<thead class="bg-neutral-50">
						<tr>
							<th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Course Name</th>
							<th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">University</th>
							<th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Category</th>
							<th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Lecturer</th>
							<th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Reports</th>
							<th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-neutral-200">
						<?php foreach ($coursesWithBrokenReports as $course): 
							$reports = (int)($course['broken_reports'] ?? 0);
						?>
						<tr class="hover:bg-neutral-50 transition-colors">
							<td class="px-4 py-3 whitespace-nowrap">
								<div class="text-sm font-medium text-gray-900">
									<?= htmlspecialchars($course['name'] ?? 'Unknown Course') ?>
								</div>
							</td>
							<td class="px-4 py-3 whitespace-nowrap">
								<div class="text-sm text-gray-600">
									<?= htmlspecialchars($course['u_name'] ?? 'Unknown University') ?>
								</div>
							</td>
							<td class="px-4 py-3 whitespace-nowrap">
								<div class="text-sm text-gray-600">
									<?= htmlspecialchars($course['kategorije'] ?? 'Uncategorized') ?>
								</div>
							</td>
							<td class="px-4 py-3 whitespace-nowrap">
								<div class="text-sm text-gray-600">
									<?= htmlspecialchars(($course['firstName'] ?? '') . ' ' . ($course['lastName'] ?? '')) ?>
								</div>
							</td>
							<td class="px-4 py-3 whitespace-nowrap text-center">
								<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
									<?= number_format($reports) ?>
								</span>
							</td>
							<td class="px-4 py-3 whitespace-nowrap text-sm">
								<a href="<?= baseUrl('/admin/courses') ?>" class="text-primary hover:text-primary/80 hover:underline">
									View Course
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../partials/admin_layout.php';
?>

