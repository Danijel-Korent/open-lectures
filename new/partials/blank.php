<!-- layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title ?? 'Admin Dashboard' ?></title>
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
	<!-- Main content where sections will be injected -->
	<main>
		<!-- main content  -->
		<div id="main-content" class="p-4">
			<div class="overflow-y-auto">
				<?= $content ?? 'Default content goes here' ?>
			</div>
		</div>
	</main>


	<!-- Floating Action Button -->
	<!-- <button id="fab" onclick="scrollToTop()"
		class="fixed bottom-6 right-6 bg-primary text-white rounded-full p-4 shadow-lg hover:opacity-85 transition-opacity duration-300 hidden"
		style="opacity: 0.8;z-index:100;">
		<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
		</svg>
	</button> -->
	<!-- Footer -->

</body>

</html>