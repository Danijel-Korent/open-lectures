<?php require "../Components/header.html";
require "../../backend/index.php";

$query = $db->query("SELECT * FROM ustanove WHERE idUstanove=" . $_GET["id"]);
$results = $query->fetchAll();
?>

<div class="grid-x grid-margin-x">
  <div class="cell large-12 medium-12 small-12">
    <h3><?php echo $results[0]["naziv_ustanove"] ?></h3>
    <p>Most popular lectures</p>
  </div>
</div>

<div class="grid-x grid-margin-x">
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