<?php
session_start();
$logged = isset($_SESSION['logged']);
$user = $logged?$_SESSION['logged']:null;
//Logic
if(isset($_GET['logout'])) {
	session_destroy();
	header('Location: '.baseUrl('/'),true);
	exit;
}	
?>
<nav x-data="{ mobileMenuIsOpen: false }" @click.away="mobileMenuIsOpen = false"
	class="flex items-center justify-between bg-neutral-50 border-b border-neutral-300 gap-4 px-6 py-4"
	aria-label="penguin ui menu">
	<!-- Brand Logo -->
	<a href="<?=baseUrl('/')?>" class="text-2xl font-bold text-neutral-900">
		<span>KB</span>
		<!-- <img src="./your-logo.svg" alt="brand logo" class="w-10" /> -->
	</a>
	<!-- Search -->
	<div class="relative flex flex-col gap-1 text-neutral-600">
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
			aria-hidden="true" class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50">
			<path stroke-linecap="round" stroke-linejoin="round"
				d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
		</svg>
		<form action="<?=baseUrl('/search')?>" method="get" class="flex items-center gap-1">
			<input type="search" name="q" value="<?=isset($_GET['q'])?$_GET['q']:""?>"
				placeholder="Search course, university..." aria-label="search"
				class="w-[70%] lg:w-[35rem] rounded-md border border-neutral-300 bg-neutral-50 py-2.5 pl-10 pr-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75" />
			<button type="submit"
				class="cursor-pointer inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-md bg-primary px-4 py-2 text-base font-medium tracking-wide text-white transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-800 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
				<i class="md:hidden text-lg lni lni-search-alt"></i>
				<span class="hidden md:inline">Search</span>
			</button>
		</form>
	</div>

	<!-- Desktop Menu -->
	<ul class="hidden items-center gap-4 flex-shrink-0 sm:flex">
		<li><a href="<?=baseUrl('/')?>"
				class="<?=$title=="Home Page"?"font-bold hover:opacity-75":"" ?> hover:underline text-black underline-offset-2 hover:text-black focus:outline-none focus:underline"
				aria-current="page">Home</a></li>
		<li><a href="<?=baseUrl('/categories')?>"
				class="<?=$title=="Categories"?"font-bold hover:opacity-75":"" ?> hover:underline text-black underline-offset-2 hover:text-black focus:outline-none focus:underline">Categories</a>
		</li>
		<li><a href="<?=baseUrl('/stats')?>"
				class="<?=$title=="Stats"?"font-bold hover:opacity-75":"" ?> hover:underline text-black underline-offset-2 hover:text-black focus:outline-none focus:underline">Stats</a>
		</li>
		<?php if($logged): ?>
		<!-- User Pic -->
		<li x-data="{ userDropDownIsOpen: false, openWithKeyboard: false }"
			@keydown.esc.window="userDropDownIsOpen = false, openWithKeyboard = false"
			class="relative flex items-center">
			<button @click="userDropDownIsOpen = ! userDropDownIsOpen" :aria-expanded="userDropDownIsOpen"
				@keydown.space.prevent="openWithKeyboard = true" @keydown.enter.prevent="openWithKeyboard = true"
				@keydown.down.prevent="openWithKeyboard = true"
				class="rounded-full focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black"
				aria-controls="userMenu">
				<div class="h-[40px] w-[40px] rounded-full bg-primary flex justify-center items-center">
					<i class="lni lni-user font-bold text-lg text-white"></i>
				</div>
			</button>
			<!-- User Dropdown -->
			<ul x-cloak x-show="userDropDownIsOpen || openWithKeyboard" x-transition.opacity x-trap="openWithKeyboard"
				@click.outside="userDropDownIsOpen = false, openWithKeyboard = false"
				@keydown.down.prevent="$focus.wrap().next()" @keydown.up.prevent="$focus.wrap().previous()"
				id="userMenu"
				class="absolute z-50 right-0 top-12 flex w-full min-w-[12rem] flex-col overflow-hidden rounded-md border border-neutral-300 bg-neutral-50 py-1.5">
				<li class="border-b border-neutral-300 ">
					<div class="flex flex-col px-4 py-2">
						<span class="text-sm font-medium text-neutral-900 "><?= $user['name']?></span>
						<p class="text-xs text-neutral-600 "><?=$user['email']?></p>
					</div>
				</li>
				<li><a href="<?=baseUrl('/admin/home')?>"
						class="block bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/10 focus-visible:text-neutral-900 focus-visible:outline-none">Dashboard</a>
				</li>
				<li>
					<form action="" method="get">
						<input type="hidden" name="logout" value="1">
						<button type="submit"
							class="block bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/10 focus-visible:text-neutral-900 focus-visible:outline-none">Sign
							Out</button>
					</form>
				</li>
			</ul>
		</li>
		<?php else: ?>
		<!-- CTA Button 
		<a href="<?=baseUrl('/admin/login')?>"
			class="rounded-md bg-primary px-4 py-2 block text-center font-medium tracking-wide text-neutral-100 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 ">Login
		</a>
		-->
		<?php endif; ?>
	</ul>
	<!-- Mobile Menu Button -->
	<button @click="mobileMenuIsOpen = !mobileMenuIsOpen" :aria-expanded="mobileMenuIsOpen"
		:class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button"
		class="flex text-neutral-600 sm:hidden" aria-label="mobile menu" aria-controls="mobileMenu">
		<svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
			viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
			<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
		</svg>
		<svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
			viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
			<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
		</svg>
	</button>
	<!-- Mobile Menu -->
	<ul x-cloak x-show="mobileMenuIsOpen"
		x-transition:enter="transition motion-reduce:transition-none ease-out duration-300"
		x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0"
		x-transition:leave="transition motion-reduce:transition-none ease-out duration-300"
		x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full"
		class="fixed z-50 max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col rounded-b-md border-b border-neutral-300 bg-neutral-50 px-8 pb-6 pt-10 ">
		<?php if($logged): ?>
		<li class="mb-4 border-none">
			<div class="flex items-center gap-2 py-2">
				<div>
					<span class="font-medium text-neutral-900 "><?=$user['name']?></span>
					<p class="text-sm text-neutral-600 "><?=$user['email']?></p>
				</div>
			</div>
		</li>
		<?php endif; ?>
		<li class="p-2"><a href="<?=baseUrl('/')?>"
				class="w-full text-lg <?=$title=="Home Page"?"font-bold hover:opacity-75":"hover:font-semibold" ?> text-black focus:underline "
				aria-current="page">Home</a></li>
		<li class="p-2"><a href="<?=baseUrl('/categories')?>"
				class="w-full text-lg <?=$title=="Categories"?"font-bold hover:opacity-75":"hover:font-semibold" ?> text-black focus:underline "
				aria-current="page">Categories</a></li>
		<li class="p-2"><a href="<?=baseUrl('/stats')?>"
				class="w-full text-lg <?=$title=="Stats"?"font-bold hover:opacity-75":"hover:font-semibold" ?> text-black focus:underline "
				aria-current="page">Stats</a></li>

		<hr role="none" class="my-2 border-outline ">
		<?php if($logged): ?>
		<li class="p-2"><a href="<?=baseUrl('/admin/home')?>"
				class="w-full text-neutral-600 focus:underline hover:underline ">Dashboard</a></li>
		<?php else:?>

		<!-- 
		<li class="mt-4 w-full border-none"><a href="<?=baseUrl('/admin/login')?>"
				class="rounded-md bg-primary px-4 py-2 block text-center font-medium tracking-wide text-neutral-100 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 ">Login
			</a></li>
		-->

		<?php endif; ?>
		<!-- CTA Button -->
		<?php if($logged): ?>
		<form action="" method="get">
			<input type="hidden" name="logout" value="1">
			<li class="mt-4 w-full border-none">
				<input type="submit"
					class="block cursor-pointer w-full rounded-md bg-primary px-4 py-2 block text-center font-medium tracking-wide text-neutral-100 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0"
					value="Sign Out" />
			</li>
		</form>
		<?php endif; ?>
	</ul>
</nav>