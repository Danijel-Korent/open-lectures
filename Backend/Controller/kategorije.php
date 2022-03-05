<?php

require "../Database/pdo.php";
require "../Repo/kategorije.php";

// Variables that fetch data from form using POST for insert and update function
$idKat = $_POST['id_kat']; 
$nazivKat = $_POST['nazivKat'];

//if statements that call functions 

if(isset($idKat) && $idKat == ""){
    insertKategorije($nazivKat);
    header("Location:index.php");
}else {
    header("Location:error.php");
};

if(isset($idKat) && $idKat > 0){
    updateKategorije($idKat,$nazivKat);
    header("Location:index.php");
}else {
    header("Location:error.php");
}
if(isset($idKat)){
    deleteKategorije($idKat);
}else {
    header("Location:error.php");
}
?>