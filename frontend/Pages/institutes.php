<?php 
require "../Components/header.html";
require "../../backend/index.php"; 
?>

<div class="grid-x grid-margin-x">
	<div class="cell large-12 medium-12 small-12">
		<h3>INSTITUTES</h3>
	</div>
</div>

<?php
foreach ($arrayUstanove as $ustanova){
?>

<div class="grid-x grid-margin-x">
	<div class="cell large-4 medium-4 small-6">
		<p><a href="certain_institute.php?id=<?php echo $ustanova["id"] ?>">
				<img src="../Image/<?php 
              if($ustanova["u_image"] == ""){
                  echo "Nema slike";
                  }else{
                      echo $ustanova["u_image"];
                 } ?>">
				<?php echo $ustanova["name"] ?>
			</a></p>
	</div>
</div>

<?php } ?>

<?php require "../Components/footer.html"; ?>