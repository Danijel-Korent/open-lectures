<?php

require "../Database/pdo.php";
require "../Repo/administratori.php";

// Variables that fetch data from form using POST for insert and update function
$idAdmin = $_POST['id_admin']; 
$ime = $_POST['ime'];
$prezime = $_POST['prezime'];
$username = $_POST['username'];
$lozinka = $_POST['lozinka'];

//if statements that call functions 

if (isset($idAdmin) && $idAdmin == ""){
    insertAdministrator ($idAdmin, $ime, $prezime, $username, $lozinka);
    header("Location:index.php");
}else {
    header("Location:error.php");
};

if(isset($idAdmin) && $idAdmin > 0){
    updateAdministrator ($idAdmin, $ime, $prezime, $username, $lozinka);
    header("Location:index.php");
}else {
    header("Location:error.php");
}
if(isset($idAdmin)){
    deleteAdministrator($idAdmin);
}else {
    header("Location:error.php");
}
?>