<?php 
require "../Components/header.html";
require "../../backend/index.php";
?>

<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12 small-12">
    <h3>CATEGORIES</h3>
  </div>
</div>

<?php 
foreach($arrayKategorije as $kategorija){ 
?>

<div class="grid-x grid-margin-x">
  <div class="cell large-4 medium-4 small-6">
  <p><a href="certain_category.php?id=<?php echo $kategorija["idKategorije"] ?>">
  <img src="../Image/<?php 
              if($kategorija["slika_kategorije"] == ""){
                  echo "Nema slike";
                  }else{
                      echo $kategorija["slika_kategorije"];
                 } ?>">
    <?php echo $kategorija["naziv_kategorije"] ?></a></p>
  </div>
</div>

<?php } ?>

<?php require "../Components/footer.html"; ?>