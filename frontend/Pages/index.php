<?php require "../Components/header.html";
require "../../backend/index.php"; ?>

<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12 small-12">
    <h3>FOSS LECTURES</h3>
  </div>
</div>

<div class="grid-x grid-margin-x">
  <div class="cell large-6 medium-6 small-8">
    <p>
    Welcome to Knowledge base. Knowledge base is a project that aggregates open source lectures from different platforms in a video format. Our goal is to collect and provide easy access to open source lectures from every possible field of science and in that way help users in education.
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

<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12 small-12" id="lectures">
    <p>Most popular lectures</p>
    </div>
</div>


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