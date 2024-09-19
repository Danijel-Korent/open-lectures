<?php 
require_once 'config.php';
function selectUstanove(){
	$res = db()->query("SELECT * FROM ustanove");
	// Check if the query was successful
	if (db()->error) {
	    echo 'DB Error: ' . db()->error;
		die();
	} else {
	//return the result
	    return $res->fetch_assoc();
	}
};

function selectKategorije(){
	$res = db()->query("SELECT * FROM kategorije;");
	// Check if the query was successful
	if (db()->error) {
	    echo 'DB Error: ' . db()->error;
		die();
	} else {
	//return the result
	$arr =[];
	while($row = $res->fetch_assoc()){
		$arr[] = $row;
	}
	    return $arr;
	}
};