<?php
//Import constants file
require_once __DIR__.'/constants.php';
$title = 'Home Page';
// Database Repo Functions here
ob_start();
?>
<!-- Hero Section -->
<section
	class="md:pt-[2%] w-full flex-col flex-col-reverse md:flex-row flex justify-center px-2 lg:px-10 items-center pt-5 gap-2 lg:gap-12">
	<div class="lg:pl-[2%] lg:w-[50%]">
		<p class="text-lg">
			Dobrodošli! "Otvorena Predavanja" je projekt koji mapira i na jednom mjestu objedinjuje popis besplatnih
			sveučilišnih predavanja/kolegija koji su javno dostupni na platformi "Youtube". Cilj je napraviti
			interaktivnu verziju ovog popisa: <a style="color:blue;"
				href="https://hr.wikipedia.org/wiki/Suradnik:Danijel.Korent/Popis_besplatnih_i_javno_dostupnih_sveu%C4%8Dili%C5%A1nih_video_predavanja">Popis
				besplatnih i javno dostupnih sveučilišnih video predavanja – Wikipedija</a>
		</p>
		<br />
		<p class="text-lg">
			Do sada su mapirani kolegiji s više od 15 svjetski poznatih sveučilišta poput MIT, Yale, Harvard, Oxford,
			ETH Zürich, Stanford, Berkely, etc. Svaki kolegij u prosjeku sadrži 20-30 predavanja u trajanju od jednog
			školskog sata. Konačni cilj projekta je da interaktivna verzija ima dodatne mogućnosti naspram statične wiki
			stranice - poput ocjenjivanja, komentiranja, filtriranja po profesorima/sveučilištima i sl.
		</p>
	</div>
	<div class="flex justify-center items-center">
		<img class="w-[85%] h-[85%] md:h-[50%] md:w-[50%]" src="assets/images/icon.svg" alt="image" id="image">
	</div>

</section>
<!-- Stats Hero -->
<div class="px-4 py-8 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
	<div class="grid grid-cols-2 gap-8 md:grid-cols-2">
		<div class="text-center md:border-r">
			<h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl">95</h6>
			<p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
				Ukupno kolegija
			</p>
		</div>
		<div class="text-center ">
			<h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl">2393h</h6>
			<p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
				Ukupno sati
			</p>
		</div>
	</div>
</div>

<!-- Lesson Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6 md:px-20">
	<div class=" hover:scale-105 transition-all bg-white rounded-xl shadow-md overflow-hidden">
		<div class="relative">
			<img class="w-full h-48 object-cover" src="https://via.placeholder.com/600x360">
			<div class="absolute top-0 right-0 bg-indigo-500 text-white font-bold px-2 py-1 m-2 rounded-md">New
			</div>
			<div class="absolute bottom-0 right-0 bg-gray-800 text-white px-2 py-1 m-2 rounded-md text-xs">3 h
			</div>
		</div>
		<div class="p-4">
			<div class="text-lg font-medium text-gray-800 mb-2">Title</div>
			<p class="text-gray-500 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor, mi sed
				egestas tincidunt, libero dolor bibendum nisl, non aliquam quam massa id lacus.</p>
		</div>
	</div>


	<div class="bg-white rounded-xl shadow-md overflow-hidden">
		<div class="relative">
			<img class="w-full h-48 object-cover" src="https://via.placeholder.com/600x360">
			<div class="absolute bottom-0 right-0 bg-gray-800 text-white px-2 py-1 m-2 rounded-md text-xs">3 h
			</div>
		</div>
		<div class="p-4">
			<div class="text-lg font-medium text-gray-800 mb-2">Title</div>
			<p class="text-gray-500 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor, mi sed
				egestas tincidunt, libero dolor bibendum nisl, non aliquam quam massa id lacus.</p>
		</div>
	</div>


	<div class="bg-white rounded-xl shadow-md overflow-hidden">
		<div class="relative">
			<img class="w-full h-48 object-cover" src="https://via.placeholder.com/600x360">
			<div class="absolute top-0 right-0 bg-indigo-500 text-white font-bold px-2 py-1 m-2 rounded-md">New</div>
			<div class="absolute bottom-0 right-0 bg-gray-800 text-white px-2 py-1 m-2 rounded-md text-xs">3 h
			</div>
		</div>
		<div class="p-4">
			<div class="text-lg font-medium text-gray-800 mb-2">Title</div>
			<p class="text-gray-500 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor, mi sed
				egestas tincidunt, libero dolor bibendum nisl, non aliquam quam massa id lacus.</p>
		</div>
	</div>

	<div class="bg-white rounded-xl shadow-md overflow-hidden">
		<div class="relative">
			<img class="w-full h-48 object-cover" src="https://via.placeholder.com/600x360">
			<div class="absolute bottom-0 right-0 bg-gray-800 text-white px-2 py-1 m-2 rounded-md text-xs">3 h
			</div>
		</div>
		<div class="p-4">
			<div class="text-lg font-medium text-gray-800 mb-2">Title</div>
			<p class="text-gray-500 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor, mi sed
				egestas tincidunt, libero dolor bibendum nisl, non aliquam quam massa id lacus.</p>
		</div>
	</div>


	<div class="bg-white rounded-xl shadow-md overflow-hidden">
		<div class="relative">
			<img class="w-full h-48 object-cover" src="https://via.placeholder.com/600x360">
			<div class="absolute bottom-0 right-0 bg-gray-800 text-white px-2 py-1 m-2 rounded-md text-xs">3 h
			</div>
		</div>
		<div class="p-4">
			<div class="text-lg font-medium text-gray-800 mb-2">Title</div>
			<p class="text-gray-500 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor, mi sed
				egestas tincidunt, libero dolor bibendum nisl, non aliquam quam massa id lacus.</p>
		</div>
	</div>


	<div class="bg-white rounded-xl shadow-md overflow-hidden">
		<div class="relative">
			<img class="w-full h-48 object-cover" src="https://via.placeholder.com/600x360">
			<div class="absolute bottom-0 right-0 bg-gray-800 text-white px-2 py-1 m-2 rounded-md text-xs">3 h
			</div>
		</div>
		<div class="p-4">
			<div class="text-lg font-medium text-gray-800 mb-2">Title</div>
			<p class="text-gray-500 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor, mi sed
				egestas tincidunt, libero dolor bibendum nisl, non aliquam quam massa id lacus.</p>
		</div>
	</div>


</div>


<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
// Now include the layout and pass the content