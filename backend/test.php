<?php

require "Repo/index.php";
require "Database/pdo.php";

$arrayUstanove = selectUstanove();
$arrayKategorije = selectKategorije();
$arrayPredavaci = selectPredavaci();
$arrayOpisPred = selectOpisPred();
$arraySve = selectAll();
?>

<pre>

<?php
//foreach($arraySve as $element) {echo $element;}
//var_dump($arraySve);
//print_r($arraySve);

print_r($arrayOpisPred);

//foreach($arrayOpisPred as $element)
{
  //  foreach($element as $subelement) print_r($subelement); echo "<br/>";
}
?>



</pre>
