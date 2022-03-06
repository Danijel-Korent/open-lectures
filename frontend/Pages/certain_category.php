<?php require "../Components/header.html";
require "../../backend/index.php"; 
$upit_kategorijebyid = $db->query("SELECT *
FROM predavanja pred
RIGHT JOIN pripadnost_kategoriji prip ON pred.idPredavanja = prip.predavanje
RIGHT JOIN kategorije k ON k.idKategorije = prip.kategorije
WHERE k.idKategorije =". $_GET["id"]);
$arrayKategorijeById  = $upit_kategorijebyid->fetchAll();
?>



<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12 small-12">
    <h3><?php echo $arrayKategorijeById[0]["naziv_kategorije"] ?></h3>
    <p>Most popular lectures</p>
  </div>
</div>

<div class="grid-x grid-margin-x">

  <div class="cell large-4 medium-4 small-12"> 
  <?php
  foreach ($arrayKategorijeById as $keyResult) {
  ?> 
    <iframe width="100px" height="100px" src=<?php echo ' " ' . $keyResult[0]["link_1"] . ' " ' ?> title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <?php
    };
  ?>
  </div>
 
  <div class="cell large-4 medium-4 small-12">
    <iframe></iframe>
  </div>
  <div class="cell large-4 medium-4 small-12">
    <iframe></iframe>
  </div>
</div>

<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12 small-12" id="seeMore">
    <a href="">See more</a>
  </div>
</div>

<?php require "../Components/footer.html"; ?>
