<?php

require "../Database/pdo.php";
require "../Repo/usluge.php";

// Variables that fetch data from form using POST for insert and update function

$idUsl = $_POST['id_usl'];
$nazivUsl = $_POST['naziv_usl'];

//if statements that call functions 

if (isset($idUsl) && $idUsl == ""){
    insertUsluge($nazivUsl);
    header("Location:index.php");
}else {
    header("Location:error.php");
};

if(isset($idUsl) && $idUsl > 0){
    updateUsluge($idUsl,$nazivUsl);
    header("Location:index.php");
}else {
    header("Location:error.php");
}
if(isset($idUsl)){
    deleteUsluge($idUsl);
}else {
    header("Location:error.php");
}    
?>