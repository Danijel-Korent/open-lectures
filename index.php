<?php
//Import constants file
require_once __DIR__.'/config.php';
$title = 'Home Page';
// Database Repo Functions here
require_once REPO_PATH;
$arrayOpisPred = selectOpisPred();
$courseData = transformCoursesForDisplay($arrayOpisPred);
$list = $courseData['courses'];
$all_courses = $courseData['total_courses'];
$all_total_length = $courseData['total_hours'];
ob_start();
?>
<!-- CSS import -->
<link rel="stylesheet" href="assets/css/tooltip.css?l=" .<?=date("d m Y")?>>
<!-- Hero Section -->
<section
	class="md:pt-[2%] w-full flex-col flex-col-reverse md:flex-row flex justify-center px-2 lg:px-10 items-center pt-5 gap-2 lg:gap-12">
	<div class="lg:pl-[2%] lg:w-[50%]">
		<p class="text-lg">
			Dobrodošli! "Otvorena Predavanja" je projekt koji mapira i na jednom mjestu objedinjuje popis besplatnih
			sveučilišnih predavanja/kolegija koji su javno dostupni na platformi "Youtube". Cilj je napraviti
			interaktivnu verziju ovog popisa: <a style="color:blue;" target="_blank"
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
<?php
$total_courses = $all_courses;
$total_hours = $all_total_length;
include SITE_PATH . '/partials/course_stats.php';
?>

<?php
$courses = $list;
include SITE_PATH . '/partials/course_grid.php';
?>


<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
// Now include the layout and pass the content