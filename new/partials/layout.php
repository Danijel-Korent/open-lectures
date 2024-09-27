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

</body>

</html>