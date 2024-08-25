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
    Dobrodošli! "Otvorena Predavanja" je projekt koji mapira i na jednom mjestu objedinjuje popis besplatnih sveučilišnih predavanja/kolegija koji su javno dostupni na platformi "Youtube". Cilj je napraviti interaktivnu verziju ovog popisa: <a style="color:blue;" href="https://hr.wikipedia.org/wiki/Suradnik:Danijel.Korent/Popis_besplatnih_i_javno_dostupnih_sveu%C4%8Dili%C5%A1nih_video_predavanja">Popis besplatnih i javno dostupnih sveučilišnih video predavanja – Wikipedija</a>
    </p>
	<p>
	Do sada su mapirani kolegiji s više od 15 svjetski poznatih sveučilišta poput MIT, Yale, Harvard, Oxford, ETH Zürich, Stanford, Berkely, etc. Svaki kolegij u prosjeku sadrži 20-30 predavanja u trajanju od jednog školskog sata. Konačni cilj projekta je da interaktivna verzija ima dodatne mogućnosti naspram statične wiki stranice - poput ocjenjivanja, komentiranja, filtriranja po profesorima/sveučilištima i sl.
	</p>
  <?php
    $all_total_length = 0;
    $all_courses = 0;

    foreach ($arrayOpisPred as $course)
    {
      $course_totalLength  = $course['ukupno_trajanje'];

      $all_courses++;
      $all_total_length += $course_totalLength;
    }

    echo "<p><b>Ukupno kolegija: $all_courses</b></p>";
    echo "<p><b>Ukupno sati: {$all_total_length}h</b></p>";

  ?>
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


$university_list = selectUstanove();

//echo "<pre>"; print_r($university_list); echo " </pre>";

foreach ($arrayOpisPred as $course)
{
  $course_name         = $course['naziv_predavanja'];
  $course_description  = $course['opis_kolegija'];
  $course_totalLength  = $course['ukupno_trajanje'];
  $course_linkPlaylist = $course['link_1'];
  $course_image        = $course['image'];

  $university_index  = $course['ustanova'] - 1;
  $course_university = $university_list[$university_index]['naziv_ustanove'];

  echo '<div class="cell large-4 medium-4 small-6 tooltip-w3">';
  echo "  <span class='tooltiptext'>$course_description</span>";
  echo "  <a href='$course_linkPlaylist' target='_blank' rel='noopener noreferrer'><img src='$course_image' title='$course_description'></a>";
  echo "  <p><b>$course_name</b> ({$course_totalLength}h)</p>";
  echo "  <p>$course_university</p>";
  echo "  <br/>";
  echo '</div>';
}

?>

<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12">
   <img src="../assets/double-arrow_down.svg" alt="up" id="up">
  </div>
</div>

<?php require "../Components/footer.html"; ?>