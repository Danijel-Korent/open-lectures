<?php require "../Components/header.html";
require "../../backend/index.php"; ?>

<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12 small-12">
    <h3>OTVORENA PREDAVNJA</h3>
  </div>
</div>

<div class="grid-x grid-margin-x">
  <div class="cell large-6 medium-6 small-8">
    <p>
    Dobrodošli! "Otvorena Predavanja" je projekt koji mapira i na jednom mjestu objedinjuje popis besplatnih sveučilišnih predavanja/kolegija koji su javno dostupni na platformi "Youtube". Cilj je napraviti interaktivnu verziju ovog popisa: <a style="color:blue;" href="https://hr.wikipedia.org/wiki/Popis_besplatnih_i_javno_dostupnih_sveu%C4%8Dili%C5%A1nih_video_predavanja">Popis besplatnih i javno dostupnih sveučilišnih video predavanja – Wikipedija</a>
    </p>
	<p>
	Do sada su mapirani kolegiji s više od 15 svjetski poznatih sveučilišta poput MIT, Yale, Harvard, Oxford, ETH Zürich, Stanford, Berkely, etc. Svaki kolegij u prosjeku sadrži 20-30 predavanja u trajanju od jednog školskog sata. Konačni cilj projekta je da interaktivna verzija ima dodatne mogućnosti naspram statične wiki stranice - poput ocjenjivanja, komentiranja, filtriranja po profesorima/sveučilištima i sl.
	</p>
  </div>

  <div class="cell large-6 small-4">
   <img src="../assets/icon.svg" alt="image" id="image">
  </div>
</div>

<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12">
   <img src="../assets/double-arrow.svg" alt="next" id="next">
  </div>
</div>

<!--
<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12 small-12" id="lectures">
    <p>Most popular lectures</p>
    </div>
</div>
-->

<?php

echo '<div class="grid-x grid-margin-x">';

//echo "<pre>"; print_r($arrayOpisPred); echo " </pre>";

foreach ($arrayOpisPred as $predavanje)
{
  $course_name         = $predavanje['naziv_predavanja'];
  $course_description  = $predavanje['opis_kolegija'];
  $course_totalLength  = $predavanje['ukupno_trajanje'];
  $course_linkPlaylist = $predavanje['link_1'];
  $course_image        = $predavanje['image'];

  echo '<div class="cell large-4 medium-4 small-6">';
  echo "  <a href='$course_linkPlaylist' target='_blank' rel='noopener noreferrer'><img src='$course_image' title='$course_description'></a>";
  echo "  <p>$course_name ({$course_totalLength}h)</p>";
  echo '</div>';
}

?>

<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12">
   <img src="../assets/double-arrow_down.svg" alt="up" id="up">
  </div>
</div>

<?php require "../Components/footer.html"; ?>