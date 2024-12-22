<?php
require_once dirname(__DIR__) . '/constants.php';
$user = $_SESSION['logged'];
if (isset($_GET['logout'])) {
	session_start();
	session_destroy();
	header('Location:'.SITE_URL .'/admin/login');
	exit;
}
?>
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
		<div x-data="{ sidebarIsOpen: false }" class="relative flex w-full flex-col md:flex-row">
			<!-- This allows screen readers to skip the sidebar and go directly to the main content. -->
			<a class="sr-only" href="#main-content">skip to the main content</a>

			<!-- dark overlay for when the sidebar is open on smaller screens  -->
			<div x-cloak x-show="sidebarIsOpen" class="fixed inset-0 z-20 bg-slate-900/10 backdrop-blur-sm md:hidden"
				aria-hidden="true" x-on:click="sidebarIsOpen = false" x-transition.opacity></div>

			<nav x-cloak
				class="fixed left-0 z-30 flex h-svh w-60 shrink-0 flex-col border-r border-slate-300 bg-slate-100 p-4 transition-transform duration-300 md:w-64 md:translate-x-0 md:relative"
				x-bind:class="sidebarIsOpen ? 'translate-x-0' : '-translate-x-60'" aria-label="sidebar navigation">
				<!-- logo  -->
				<a href="#" class="ml-2 w-fit text-2xl font-bold text-black">
					<span class="sr-only">homepage</span>
					<h1>KB</h1>
				</a>

				<!-- sidebar links  -->
				<div class="flex flex-col gap-2 overflow-y-auto pb-6 mt-4">

					<a href="<?=SITE_URL."/admin/home"?>"
						class="flex items-center rounded-xl gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus-visible:underline focus:outline-none">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
							class="size-5 shrink-0" aria-hidden="true">
							<path
								d="M15.5 2A1.5 1.5 0 0 0 14 3.5v13a1.5 1.5 0 0 0 1.5 1.5h1a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 16.5 2h-1ZM9.5 6A1.5 1.5 0 0 0 8 7.5v9A1.5 1.5 0 0 0 9.5 18h1a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 10.5 6h-1ZM3.5 10A1.5 1.5 0 0 0 2 11.5v5A1.5 1.5 0 0 0 3.5 18h1A1.5 1.5 0 0 0 6 16.5v-5A1.5 1.5 0 0 0 4.5 10h-1Z" />
						</svg>
						<span>Dashboard</span>
					</a>

					<a href="<?=SITE_URL."/admin/category"?>"
						class="flex items-center rounded-xl gap-2 px-2 py-1.5 text-sm hover:bg-blue-700/5 font-medium text-slate-700 underline-offset-2 focus-visible:underline focus:outline-none">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
							class="size-5 shrink-0" aria-hidden="true">
							<path
								d="M13.92 3.845a19.362 19.362 0 0 1-6.3 1.98C6.765 5.942 5.89 6 5 6a4 4 0 0 0-.504 7.969 15.97 15.97 0 0 0 1.271 3.34c.397.771 1.342 1 2.05.59l.867-.5c.726-.419.94-1.32.588-2.02-.166-.331-.315-.666-.448-1.004 1.8.357 3.511.963 5.096 1.78A17.964 17.964 0 0 0 15 10c0-2.162-.381-4.235-1.08-6.155ZM15.243 3.097A19.456 19.456 0 0 1 16.5 10c0 2.43-.445 4.758-1.257 6.904l-.03.077a.75.75 0 0 0 1.401.537 20.903 20.903 0 0 0 1.312-5.745 2 2 0 0 0 0-3.546 20.902 20.902 0 0 0-1.312-5.745.75.75 0 0 0-1.4.537l.029.078Z" />
						</svg>
						<span>Categories</span>

					</a>

					<a href="<?=SITE_URL."/admin/courses"?>"
						class="flex items-center rounded-xl gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus-visible:underline focus:outline-none ">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
							class="size-5 shrink-0" aria-hidden="true">
							<path fill-rule="evenodd"
								d="M4.606 12.97a.75.75 0 0 1-.134 1.051 2.494 2.494 0 0 0-.93 2.437 2.494 2.494 0 0 0 2.437-.93.75.75 0 1 1 1.186.918 3.995 3.995 0 0 1-4.482 1.332.75.75 0 0 1-.461-.461 3.994 3.994 0 0 1 1.332-4.482.75.75 0 0 1 1.052.134Z"
								clip-rule="evenodd" />
							<path fill-rule="evenodd"
								d="M5.752 12A13.07 13.07 0 0 0 8 14.248v4.002c0 .414.336.75.75.75a5 5 0 0 0 4.797-6.414 12.984 12.984 0 0 0 5.45-10.848.75.75 0 0 0-.735-.735 12.984 12.984 0 0 0-10.849 5.45A5 5 0 0 0 1 11.25c.001.414.337.75.751.75h4.002ZM13 9a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"
								clip-rule="evenodd" />
						</svg>
						<span>Courses</span>
					</a>

				</div>
			</nav>

			<!-- top navbar & main content  -->
			<div class="h-svh w-full overflow-y-auto bg-white">
				<!-- top navbar  -->
				<nav class="sticky top-0 z-10 flex items-center md:justify-end justify-between border-b border-slate-300 bg-slate-100 px-4 py-2"
					aria-label="top navibation bar">
					<!-- sidebar toggle button for small screens  -->
					<button type="button" class="md:hidden inline-block text-slate-700"
						x-on:click="sidebarIsOpen = true">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5"
							aria-hidden="true">
							<path
								d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z" />
						</svg>
					</button>
					<!-- Profile Menu  -->
					<div x-data="{ userDropdownIsOpen: false }" class="relative"
						x-on:keydown.esc.window="userDropdownIsOpen = false">
						<button type="button"
							class="flex w-full cursor-pointer items-center rounded-xl gap-2 p-2 text-left text-slate-700 hover:bg-blue-700/5 hover:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700"
							x-bind:class="userDropdownIsOpen ? 'bg-blue-700/10' : ''" aria-haspopup="true"
							x-on:click="userDropdownIsOpen = ! userDropdownIsOpen"
							x-bind:aria-expanded="userDropdownIsOpen">
							<!-- <img src="https://penguinui.s3.amazonaws.com/component-assets/avatar-7.webp"
								class="size-8 object-cover rounded-xl" alt="avatar" aria-hidden="true" /> -->
							<div class="flex flex-col">
								<span class="text-sm font-bold text-black"><?=$user['name']?></span>
								<span class="text-xs" aria-hidden="true"><?=$user['email']?></span>
							</div>
						</button>

						<!-- menu -->
						<div x-cloak x-show="userDropdownIsOpen"
							class="absolute top-14 right-0 z-20 h-fit w-48 border divide-y divide-slate-300 border-slate-300 bg-white"
							role="menu" x-on:click.outside="userDropdownIsOpen = false"
							x-on:keydown.down.prevent="$focus.wrap().next()"
							x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition=""
							x-trap="userDropdownIsOpen">

							<!-- <div class="flex flex-col py-1.5">
								<a href="#"
									class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus-visible:underline focus:outline-none dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white"
									role="menuitem">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
										class="size-5 shrink-0" aria-hidden="true">
										<path
											d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
									</svg>
									<span>Categories</span>
								</a>
							</div> -->

							<!-- <div class="flex flex-col py-1.5">
								<a href="#"
									class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus-visible:underline focus:outline-none dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white"
									role="menuitem">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
										class="size-5 shrink-0" aria-hidden="true">
										<path fill-rule="evenodd"
											d="M7.84 1.804A1 1 0 0 1 8.82 1h2.36a1 1 0 0 1 .98.804l.331 1.652a6.993 6.993 0 0 1 1.929 1.115l1.598-.54a1 1 0 0 1 1.186.447l1.18 2.044a1 1 0 0 1-.205 1.251l-1.267 1.113a7.047 7.047 0 0 1 0 2.228l1.267 1.113a1 1 0 0 1 .206 1.25l-1.18 2.045a1 1 0 0 1-1.187.447l-1.598-.54a6.993 6.993 0 0 1-1.929 1.115l-.33 1.652a1 1 0 0 1-.98.804H8.82a1 1 0 0 1-.98-.804l-.331-1.652a6.993 6.993 0 0 1-1.929-1.115l-1.598.54a1 1 0 0 1-1.186-.447l-1.18-2.044a1 1 0 0 1 .205-1.251l1.267-1.114a7.05 7.05 0 0 1 0-2.227L1.821 7.773a1 1 0 0 1-.206-1.25l1.18-2.045a1 1 0 0 1 1.187-.447l1.598.54A6.992 6.992 0 0 1 7.51 3.456l.33-1.652ZM10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
											clip-rule="evenodd" />
									</svg>
									<span>Settings</span>
								</a>
							</div> -->

							<div class="flex flex-col py-1.5">
								<form action="" method="get">
									<input type="hidden" name="logout" value="1">
									<button type="submit"
										class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus-visible:underline focus:outline-none"
										role="menuitem">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
											class="size-5 shrink-0" aria-hidden="true">
											<path fill-rule="evenodd"
												d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z"
												clip-rule="evenodd" />
											<path fill-rule="evenodd"
												d="M6 10a.75.75 0 0 1 .75-.75h9.546l-1.048-.943a.75.75 0 1 1 1.004-1.114l2.5 2.25a.75.75 0 0 1 0 1.114l-2.5 2.25a.75.75 0 1 1-1.004-1.114l1.048-.943H6.75A.75.75 0 0 1 6 10Z"
												clip-rule="evenodd" />
										</svg>
										<span>Sign Out</span>
									</button>
								</form>
							</div>
						</div>
					</div>
				</nav>
				<!-- main content  -->
				<div id="main-content" class="p-4">
					<div class="overflow-y-auto">
						<?= $content ?? 'Default content goes here' ?>
					</div>
				</div>
			</div>
		</div>
	</main>

</body>

</html>