<?php

require "Repo/index.php";
require "Database/pdo.php";

$arrayUstanove = selectUstanove();
$arrayKategorije = selectKategorije();
$arrayPredavaci = selectPredavaci();
$arrayOpisPred = selectOpisPred(); 
$arraySve = selectAll();

foreach($arrayKategorije as $key => $value) {
    echo $value["naziv_kategorije"];
}