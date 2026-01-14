<!-- layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title ?? 'KB' ?></title>
	<link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
</head>
<script src="https://cdn.tailwindcss.com"></script>
<script>
// Setup Theme Colors
tailwind.config = {
	theme: {
		extend: {
			colors: {
				primary: '#1d68e0',
			}
		}
	}
}
</script>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
[x-cloak] {
	display: none !important;
}
</style>

<body>
	<!-- Header -->
	<?php include_once 'header.php'?>

	<!-- Main content where sections will be injected -->
	<main>
		<?= $content ?? 'Default content goes here' ?>
	</main>

	<!-- Floating Action Button -->
	<button id="fab" onclick="scrollToTop()"
		class="fixed bottom-6 right-6 bg-primary text-white rounded-full p-4 shadow-lg hover:opacity-85 transition-opacity duration-300 hidden"
		style="opacity: 0.8;z-index:100;">
		<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
		</svg>
	</button>
	<!-- Footer -->
	<?php include_once 'footer.php'?>

	<!-- Scripts -->

	<script>
	// Function to toggle the visibility of the floating action button
	function toggleFab() {
		const fab = document.getElementById('fab');
		const scrollTop = window.scrollY;
		const docHeight = document.documentElement.scrollHeight - window.innerHeight;
		const scrollPercent = (scrollTop / docHeight) * 100;

		// Show the button when the scroll is greater than 20%
		if (scrollPercent > 15) {
			fab.classList.remove('hidden');
		} else {
			fab.classList.add('hidden');
		}
	}

	// Function to scroll to the top of the page
	function scrollToTop() {
		window.scrollTo({
			top: 0,
			behavior: 'smooth'
		});
	}

	// Attach the scroll event listener to the window
	window.addEventListener('scroll', toggleFab);
	</script>

	<script>
	(function () {
		const reportUrl = '<?=baseUrl('/report-broken.php')?>';
		const trackViewUrl = '<?=baseUrl('/track-view.php')?>';
		const trackVideoViewUrl = '<?=baseUrl('/track-video-view.php')?>';
		const trackedViews = new Set(); // Track which courses have been viewed in this session
		const trackedVideoViews = new Set(); // Track which courses have had video links clicked in this session

		// Global function to track course views (description views)
		window.trackCourseView = function(courseId, viewsId) {
			if (!courseId || trackedViews.has(courseId)) {
				return; // Already tracked in this session
			}
			
			trackedViews.add(courseId);
			const viewCounter = document.getElementById(viewsId);
			
			// Track view (fire and forget)
			fetch(trackViewUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({ course_id: Number(courseId) })
			})
			.then(response => response.json())
			.then(payload => {
				if (payload.success && typeof payload.count !== 'undefined' && viewCounter) {
					viewCounter.textContent = payload.count;
				}
			})
			.catch(() => {
				// Silently fail - view tracking is not critical
			});
		};

		// Global function to track video link clicks
		window.trackVideoView = function(courseId, videoViewsId) {
			if (!courseId || trackedVideoViews.has(courseId)) {
				return; // Already tracked in this session
			}
			
			trackedVideoViews.add(courseId);
			const videoViewCounter = document.getElementById(videoViewsId);
			
			// Track video view (fire and forget)
			fetch(trackVideoViewUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({ course_id: Number(courseId) })
			})
			.then(response => response.json())
			.then(payload => {
				if (payload.success && typeof payload.count !== 'undefined' && videoViewCounter) {
					videoViewCounter.textContent = payload.count;
				}
			})
			.catch(() => {
				// Silently fail - view tracking is not critical
			});
		};

		// Report broken link handler
		document.addEventListener('click', async (event) => {
			const button = event.target.closest('[data-report-course]');
			if (!button || button.dataset.reportPending === 'true') {
				return;
			}

			const courseId = button.dataset.reportCourse;
			if (!courseId) {
				return;
			}

			const defaultLabel = button.dataset.reportLabel || button.textContent.trim();
			const counterId = button.dataset.reportTarget;
			const counterElement = counterId ? document.getElementById(counterId) : null;

			button.dataset.reportLabel = defaultLabel;
			button.dataset.reportPending = 'true';
			button.disabled = true;
			button.textContent = 'Reporting...';

			try {
				const response = await fetch(reportUrl, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({ course_id: Number(courseId) })
				});

				const payload = await response.json().catch(() => ({}));
				if (!response.ok || !payload.success) {
					throw new Error(payload.message || 'Unable to submit report');
				}

				button.textContent = 'Thanks for the heads up!';
				button.classList.remove('text-primary', 'border-primary');
				button.classList.add('bg-green-600', 'text-white', 'border-green-600');

				if (counterElement && typeof payload.count !== 'undefined') {
					counterElement.textContent = payload.count;
				}
			} catch (error) {
				console.error(error);
				button.disabled = false;
				button.dataset.reportPending = 'false';
				button.textContent = 'Please try again';

				setTimeout(() => {
					if (button.dataset.reportPending === 'false') {
						button.textContent = defaultLabel;
					}
				}, 2000);
			}
		});
	})();
	</script>

</body>

</html>