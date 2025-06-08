<?php require "../Components/header.html";
require "../../backend/index.php"; 

?>

<div class="grid-x grid-margin-x">
	<div class="cell large-12 medium-12 small-12">
		<h3>INSTRUCTORS</h3>
	</div>
</div>

<?php
foreach ($arrayPredavaci as $predavac){
?>

<div class="grid-x grid-margin-x">
	<div class="cell large-4 medium-4 small-6">
		<img>
		<p><a href="certain_instructor.php?id=<?php echo $predavac["id"] ?>">
				<?php echo $predavac["firstName"] . " " . $predavac["lastName"] ?>
			</a></p>
	</div>

</div>

<?php } ?>
<?php require "../Components/footer.html"; ?>