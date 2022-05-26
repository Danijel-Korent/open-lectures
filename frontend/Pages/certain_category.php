<?php require "../Components/header.html";
require "../../backend/index.php"; 

$query = $db->query("SELECT * FROM kategorije WHERE idKategorije=" . $_GET["id"]);
$results = $query->fetchAll();
?>

<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12 small-12">
    <h3><?php echo $results[0]["naziv_kategorije"] ?></h3>

    <?php
    $all_total_length = 0;
    $all_courses = 0;

    foreach ($arrayOpisPred as $course)
    {
      if ($course['kategorije'] == $_GET["id"])
      {
        $course_totalLength  = $course['ukupno_trajanje'];

        $all_courses++;
        $all_total_length += $course_totalLength;
      }
    }

    echo "<p><b>Ukupno kolegija: $all_courses</b></p>";
    echo "<p><b>Ukupno sati: {$all_total_length}h</b></p>";

  ?>
  </div>
</div>

<div class="grid-x grid-margin-x">

  <?php
  //echo "<pre>"; print_r($arrayOpisPred); echo " </pre>";

  $university_list = selectUstanove();

  foreach ($arrayOpisPred as $course)
  {
    $course_category     = $course['kategorije'];
    $course_name         = $course['naziv_predavanja'];
    $course_description  = $course['opis_kolegija'];
    $course_totalLength  = $course['ukupno_trajanje'];
    $course_linkPlaylist = $course['link_1'];
    $course_image        = $course['image'];

    $university_index  = $course['ustanova'] - 1;
    $course_university = $university_list[$university_index]['naziv_ustanove'];

    if ($course_category == $_GET["id"])
    {
      echo '<div class="cell large-4 medium-4 small-12">';
      //echo '<div class="cell large-4 medium-4 small-6">';
      echo "  <a href='$course_linkPlaylist' target='_blank' rel='noopener noreferrer'><img src='$course_image' title='$course_description'></a>";
      echo "  <p><b>$course_name</b> ({$course_totalLength}h)</p>";
      echo "  <p>$course_university</p>";
      echo "  <br/>";
      echo '</div>';
    }
  }

  ?>
</div>

<!--
<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12 small-12" id="seeMore">
    <a href="">See more</a>
  </div>
</div>
-->

<?php require "../Components/footer.html"; ?>
