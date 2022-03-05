<?php
include '../Database/pdo.php';
include "../Repo/administratori.php";
include "sortFunction.php";

usort($arraySelAdm, "desc");

foreach ($arraySelAdm as $key) {
    echo $key["ime_admina"] , "<br>";
}
?>

