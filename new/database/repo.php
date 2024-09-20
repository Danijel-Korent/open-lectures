<?php 
require_once 'config.php';
function selectUstanove(){
	$res = db()->query("SELECT * FROM ustanove");
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

function selectOpisPred (){
    $res = db()->query("SELECT pred.naziv_predavanja, u.naziv_ustanove,
    p.ime, p.prezime,  pred.jezik, pred.broj_predavanja, 
    pred.ukupno_trajanje, pred.oznaka, pred.oznaka, pred.opis_kolegija, pred.link_1, pred.link_2, pred.image, prip.kategorije, z.ustanova
    FROM ustanove u 
    INNER JOIN zaposlenje z ON u.idUstanove = z.ustanova
    INNER JOIN predavaci p ON p.idPredavac = z.predavac
    INNER JOIN lekcije l on l.predavac = p.idPredavac
    INNER JOIN predavanja pred ON pred.idPredavanja = l.predavanja
    INNER JOIN pripadnost_kategoriji prip ON pred.idPredavanja = prip.predavanje
    INNER JOIN kategorije k ON k.idKategorije = prip.kategorije;
    ");
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

function truncateString($string, $length = 100, $append = "...") {
    if (strlen($string) <= $length) {
        return $string;
    }
    $truncated = substr($string, 0, $length - strlen($append));
    return $truncated . $append;
}