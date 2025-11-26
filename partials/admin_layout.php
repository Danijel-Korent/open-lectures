<?php
require_once dirname(__DIR__) . '/config.php';
$user = $_SESSION['logged'];
if (isset($_GET['logout'])) {
	session_start();
	session_destroy();
	header('Location:'.baseUrl('/admin/login'));
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

					<a href="<?=baseUrl('/admin/home')?>"
						class="flex items-center rounded-xl gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus-visible:underline focus:outline-none">
						<svg class="size-5 shrink-0" aria-hidden="true" viewBox="0 0 25 24" fill="none"
							xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M5.60352 3.25C4.36088 3.25 3.35352 4.25736 3.35352 5.5V8.99998C3.35352 10.2426 4.36087 11.25 5.60352 11.25H9.10352C10.3462 11.25 11.3535 10.2426 11.3535 8.99998V5.5C11.3535 4.25736 10.3462 3.25 9.10352 3.25H5.60352ZM4.85352 5.5C4.85352 5.08579 5.1893 4.75 5.60352 4.75H9.10352C9.51773 4.75 9.85352 5.08579 9.85352 5.5V8.99998C9.85352 9.41419 9.51773 9.74998 9.10352 9.74998H5.60352C5.1893 9.74998 4.85352 9.41419 4.85352 8.99998V5.5Z"
								fill="#323544" />
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M5.60352 12.75C4.36088 12.75 3.35352 13.7574 3.35352 15V18.5C3.35352 19.7426 4.36087 20.75 5.60352 20.75H9.10352C10.3462 20.75 11.3535 19.7426 11.3535 18.5V15C11.3535 13.7574 10.3462 12.75 9.10352 12.75H5.60352ZM4.85352 15C4.85352 14.5858 5.1893 14.25 5.60352 14.25H9.10352C9.51773 14.25 9.85352 14.5858 9.85352 15V18.5C9.85352 18.9142 9.51773 19.25 9.10352 19.25H5.60352C5.1893 19.25 4.85352 18.9142 4.85352 18.5V15Z"
								fill="#323544" />
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M12.8535 5.5C12.8535 4.25736 13.8609 3.25 15.1035 3.25H18.6035C19.8462 3.25 20.8535 4.25736 20.8535 5.5V8.99998C20.8535 10.2426 19.8462 11.25 18.6035 11.25H15.1035C13.8609 11.25 12.8535 10.2426 12.8535 8.99998V5.5ZM15.1035 4.75C14.6893 4.75 14.3535 5.08579 14.3535 5.5V8.99998C14.3535 9.41419 14.6893 9.74998 15.1035 9.74998H18.6035C19.0177 9.74998 19.3535 9.41419 19.3535 8.99998V5.5C19.3535 5.08579 19.0177 4.75 18.6035 4.75H15.1035Z"
								fill="#323544" />
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M15.1035 12.75C13.8609 12.75 12.8535 13.7574 12.8535 15V18.5C12.8535 19.7426 13.8609 20.75 15.1035 20.75H18.6035C19.8462 20.75 20.8535 19.7426 20.8535 18.5V15C20.8535 13.7574 19.8462 12.75 18.6035 12.75H15.1035ZM14.3535 15C14.3535 14.5858 14.6893 14.25 15.1035 14.25H18.6035C19.0177 14.25 19.3535 14.5858 19.3535 15V18.5C19.3535 18.9142 19.0177 19.25 18.6035 19.25H15.1035C14.6893 19.25 14.3535 18.9142 14.3535 18.5V15Z"
								fill="#323544" />
						</svg>

						<span>Dashboard</span>
					</a>

					<a href="<?=baseUrl('/admin/category')?>"
						class="flex items-center rounded-xl gap-2 px-2 py-1.5 text-sm hover:bg-blue-700/5 font-medium text-slate-700 underline-offset-2 focus-visible:underline focus:outline-none">
						<svg class="size-5 shrink-0" aria-hidden="true" viewBox="0 0 24 24" fill="none"
							xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M7.33301 5.5C7.33301 4.25736 8.34037 3.25 9.58301 3.25H11.1663C12.3908 3.25 13.3868 4.22809 13.4157 5.44559C13.6431 5.27137 13.9077 5.13795 14.2016 5.0592L16.4554 4.45529C17.6557 4.13367 18.8894 4.84598 19.2111 6.04628L21.9287 16.1885C22.2503 17.3888 21.538 18.6226 20.3377 18.9442L18.0838 19.5481C16.8835 19.8697 15.6498 19.1574 15.3282 17.9571L13.4163 10.8221V17.25C13.4163 18.4926 12.409 19.5 11.1663 19.5H9.58301C9.00682 19.5 8.48122 19.2834 8.08317 18.9272C7.68512 19.2834 7.15952 19.5 6.58333 19.5H4.25C3.00736 19.5 2 18.4926 2 17.25V7.75C2 6.50736 3.00736 5.5 4.25 5.5H6.58333C6.84619 5.5 7.09852 5.54507 7.33301 5.62791V5.5ZM7.33301 17.25V7.72768C7.3212 7.32379 6.99008 7 6.58333 7H4.25C3.83579 7 3.5 7.33579 3.5 7.75V17.25C3.5 17.6642 3.83579 18 4.25 18H6.58333C6.99108 18 7.32283 17.6746 7.33309 17.2693L7.33301 17.25ZM9.58301 18C9.17526 18 8.84351 17.6746 8.83325 17.2693L8.83333 17.25V7.75C8.83333 7.73708 8.83322 7.72419 8.83301 7.71133V5.5C8.83301 5.08579 9.16879 4.75 9.58301 4.75H11.1663C11.5806 4.75 11.9163 5.08579 11.9163 5.5V17.25C11.9163 17.6642 11.5806 18 11.1663 18H9.58301ZM14.0595 7.42665C13.9522 7.02655 14.1897 6.6153 14.5898 6.50809L16.8436 5.90418C17.2437 5.79697 17.655 6.03441 17.7622 6.43451L20.4798 16.5767C20.587 16.9768 20.3495 17.3881 19.9494 17.4953L17.6956 18.0992C17.2955 18.2064 16.8843 17.969 16.7771 17.5689L14.0595 7.42665Z"
								fill="#323544" />
						</svg>
						<span>Categories</span>

					</a>

					<a href="<?=baseUrl('/admin/courses')?>"
						class="flex items-center rounded-xl gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus-visible:underline focus:outline-none ">

						<svg class="size-5 shrink-0" aria-hidden="true" viewBox="0 0 24 24" fill="none"
							xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M8.25 5C7.83579 5 7.5 5.33579 7.5 5.75V9.75C7.5 10.1642 7.83579 10.5 8.25 10.5H15.75C16.1642 10.5 16.5 10.1642 16.5 9.75V5.75C16.5 5.33579 16.1642 5 15.75 5H8.25ZM9 9V6.5H15V9H9Z"
								fill="#323544" />
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M6.75 2C5.50736 2 4.5 3.00736 4.5 4.25V19C4.5 20.6569 5.84315 22 7.5 22H18.75C19.1642 22 19.5 21.6642 19.5 21.25C19.5 20.8358 19.1642 20.5 18.75 20.5H18V17.5H18.75C19.1642 17.5 19.5 17.1642 19.5 16.75V4.25C19.5 3.00736 18.4926 2 17.25 2H6.75ZM18 16V4.25C18 3.83579 17.6642 3.5 17.25 3.5H6.75C6.33579 3.5 6 3.83579 6 4.25V16.4013C6.44126 16.1461 6.95357 16 7.5 16H18ZM16.5 17.5V20.5H7.5C6.67157 20.5 6 19.8284 6 19C6 18.1716 6.67157 17.5 7.5 17.5H16.5Z"
								fill="#323544" />
						</svg>

						<span>Courses</span>
					</a>
					<a href="<?=baseUrl('/admin/university')?>"
						class="flex items-center rounded-xl gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus-visible:underline focus:outline-none ">
						<svg class="size-5 shrink-0" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor"
							xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
							<path
								d="M12.75 14.6667C12.75 14.2524 13.0858 13.9167 13.5 13.9167H16.5C16.9142 13.9167 17.25 14.2524 17.25 14.6667C17.25 15.0809 16.9142 15.4167 16.5 15.4167H13.5C13.0858 15.4167 12.75 15.0809 12.75 14.6667Z"
								fill="#343C54" />
							<path
								d="M13.5 8.58334C13.0858 8.58334 12.75 8.91913 12.75 9.33334C12.75 9.74756 13.0858 10.0833 13.5 10.0833H16.5C16.9142 10.0833 17.25 9.74756 17.25 9.33334C17.25 8.91913 16.9142 8.58334 16.5 8.58334H13.5Z"
								fill="#343C54" />
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M11.5 3.25C10.2574 3.25 9.25 4.25736 9.25 5.5V7.75H5.5C4.25736 7.75 3.25 8.75736 3.25 10V20C3.25 20.4142 3.58579 20.75 4 20.75H20C20.4142 20.75 20.75 20.4142 20.75 20V5.5C20.75 4.25736 19.7426 3.25 18.5 3.25H11.5ZM9.25 19.25V17H7.75586C7.34165 17 7.00586 16.6642 7.00586 16.25C7.00586 15.8358 7.34165 15.5 7.75586 15.5H9.25V13H7.75586C7.34165 13 7.00586 12.6642 7.00586 12.25C7.00586 11.8358 7.34165 11.5 7.75586 11.5H9.25V9.25H5.5C5.08579 9.25 4.75 9.58579 4.75 10V19.25H9.25ZM10.75 12.2773C10.7503 12.2683 10.7505 12.2591 10.7505 12.25C10.7505 12.2409 10.7503 12.2317 10.75 12.2227V5.5C10.75 5.08579 11.0858 4.75 11.5 4.75H18.5C18.9142 4.75 19.25 5.08579 19.25 5.5V19.25H10.75V16.2773C10.7503 16.2683 10.7505 16.2591 10.7505 16.25C10.7505 16.2409 10.7503 16.2317 10.75 16.2227V12.2773Z"
								fill="#343C54" />
						</svg>

						<span>Universities</span>
					</a>
					<a href="<?=baseUrl('/admin/lecturer')?>"
						class="flex items-center rounded-xl gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus-visible:underline focus:outline-none ">
						<svg class="size-5 shrink-0" aria-hidden="true" viewBox="0 0 25 24" fill="none"
							xmlns="http://www.w3.org/2000/svg">
							<path
								d="M15.3289 11.4955C14.4941 11.4955 13.724 11.2188 13.1051 10.7522C13.3972 10.3301 13.6284 9.86262 13.786 9.36254C14.1827 9.7539 14.7276 9.99545 15.3289 9.99545C16.5422 9.99545 17.5258 9.01185 17.5258 7.79851C17.5258 6.58517 16.5422 5.60156 15.3289 5.60156C14.7276 5.60156 14.1827 5.84312 13.786 6.23449C13.6284 5.73441 13.3972 5.26698 13.1051 4.84488C13.7239 4.37824 14.4941 4.10156 15.3289 4.10156C17.3706 4.10156 19.0258 5.75674 19.0258 7.79851C19.0258 9.84027 17.3706 11.4955 15.3289 11.4955Z"
								fill="#323544" />
							<path
								d="M14.7723 13.1891C15.0227 13.437 15.2464 13.6945 15.4463 13.9566C16.7954 13.9826 17.7641 14.3143 18.4675 14.7651C19.2032 15.2366 19.6941 15.8677 20.0242 16.5168C20.3563 17.1698 20.5204 17.8318 20.6002 18.337C20.6398 18.5878 20.6579 18.795 20.6661 18.9365C20.6702 19.0071 20.6717 19.061 20.6724 19.0952L20.6726 19.1161L20.6727 19.1313L20.6727 19.1363L21.4197 19.1486C20.6793 19.1358 20.6728 19.136 20.6727 19.1363L20.6727 19.1376C20.6666 19.5509 20.9961 19.8914 21.4096 19.8985C21.8237 19.9057 22.1653 19.5758 22.1725 19.1617L21.4284 19.1488C22.1725 19.1617 22.1725 19.1621 22.1725 19.1617L22.1725 19.1599L22.1726 19.1575L22.1726 19.1511L22.1727 19.1319C22.1727 19.1163 22.1726 19.0951 22.1721 19.0686C22.1712 19.0158 22.1689 18.9419 22.1636 18.85C22.153 18.6665 22.1303 18.4094 22.0819 18.1029C21.9856 17.4936 21.7848 16.6697 21.3612 15.8368C20.9357 15 20.2801 14.1451 19.2768 13.5022C18.2708 12.8574 16.9604 12.4549 15.274 12.4549C14.8284 12.4549 14.4092 12.483 14.0148 12.5362C14.2852 12.7384 14.5376 12.9566 14.7723 13.1891Z"
								fill="#323544" />
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M5.13173 7.79855C5.13173 5.75678 6.7869 4.1016 8.82867 4.1016C10.8704 4.1016 12.5256 5.75678 12.5256 7.79855C12.5256 9.84031 10.8704 11.4955 8.82867 11.4955C6.7869 11.4955 5.13173 9.84031 5.13173 7.79855ZM8.82867 5.6016C7.61533 5.6016 6.63173 6.58521 6.63173 7.79855C6.63173 9.01189 7.61533 9.99549 8.82867 9.99549C10.042 9.99549 11.0256 9.01189 11.0256 7.79855C11.0256 6.58521 10.042 5.6016 8.82867 5.6016Z"
								fill="#323544" />
							<path
								d="M3.37502 19.1374C3.38126 19.5507 3.0517 19.8914 2.63812 19.8986C2.22397 19.9058 1.88241 19.5759 1.87522 19.1617L2.62511 19.1487C1.87522 19.1617 1.87523 19.1621 1.87522 19.1617L1.87519 19.1599L1.87516 19.1575L1.87509 19.1511L1.875 19.1319C1.87499 19.1163 1.87512 19.0951 1.87559 19.0687C1.87653 19.0158 1.87882 18.942 1.88413 18.85C1.89474 18.6665 1.91745 18.4094 1.96585 18.103C2.0621 17.4936 2.26292 16.6697 2.68648 15.8368C3.11206 15 3.76758 14.1452 4.77087 13.5022C5.77688 12.8575 7.08727 12.455 8.77376 12.455C10.4602 12.455 11.7706 12.8575 12.7767 13.5022C13.7799 14.1452 14.4355 15 14.861 15.8368C15.2846 16.6697 15.4854 17.4936 15.5817 18.103C15.6301 18.4094 15.6528 18.6665 15.6634 18.85C15.6687 18.942 15.671 19.0158 15.6719 19.0687C15.6724 19.0951 15.6725 19.1163 15.6725 19.1319L15.6724 19.1511L15.6724 19.1575L15.6723 19.1599C15.6723 19.1603 15.6723 19.1617 14.9282 19.1488L15.6723 19.1617C15.6651 19.5759 15.3235 19.9058 14.9094 19.8986C14.4959 19.8914 14.1664 19.5509 14.1725 19.1376L14.1725 19.1364C14.1726 19.1361 14.1791 19.1358 14.9199 19.1487L14.1725 19.1364L14.1725 19.1314L14.1724 19.1161L14.1722 19.0952C14.1716 19.061 14.17 19.0072 14.1659 18.9366C14.1577 18.7951 14.1396 18.5878 14.1 18.337C14.0202 17.8319 13.8561 17.1699 13.524 16.5168C13.1939 15.8677 12.703 15.2366 11.9673 14.7651C11.2343 14.2954 10.2132 13.955 8.77376 13.955C7.33434 13.955 6.31319 14.2954 5.58022 14.7651C4.84453 15.2366 4.35363 15.8677 4.02351 16.5168C3.6914 17.1699 3.52727 17.8319 3.44749 18.337C3.40787 18.5878 3.38981 18.7951 3.38163 18.9366C3.37756 19.0072 3.37596 19.061 3.37536 19.0952C3.37505 19.1123 3.375 19.1245 3.375 19.1314L3.37502 19.1374Z"
								fill="#323544" />
						</svg>


						<span>Lecturers</span>
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