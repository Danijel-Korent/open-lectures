<?php

require "../Database/pdo.php";
require "../Repo/pruzatelji.php";

// Variables that fetch data from form using POST for insert and update function

$idPruz = $_POST['id_pruz'];
$nazivPruzatelja = $_POST['naziv_pruzatelja'];
$email = $_POST['email'];
$adresa = $_POST['adresa'];
$kontakt = $_POST['kontakt'];
$URL = $_POST['url'];
$radnVr = $_POST['radn_vr'];
$napomena = $_POST['napomena'];
$long = $_POST['long'];
$lat= $_POST['lat'];

//if statements that call functions 

if (isset($idKat) && $idKat == ""){
    insertPruzatelj($nazivPruzatelja, $email, $adresa, $kontakt, $URL, $radnVr, $napomena, $long, $lat);
    header("Location:index.php");
}else {
    header("Location:error.php");
};

if(isset($idPruz) && $idPruz > 0){
    updatePruzatelj($idPruz, $nazivPruzatelja, $email, $adresa, $kontakt, $URL, $radnVr, $napomena, $long, $lat);
    header("Location:index.php");
}else {
    header("Location:error.php");
}    

if(isset($idPruz)){
    deletePruzatelj($idPruz);
}else {
    header("Location:error.php");
}    
?>