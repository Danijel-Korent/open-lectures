<?php 
require_once 'config.php';

// Select all universities
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

// Select all categories
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

// Select all courses
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

//Select all courses by category
function selectCoursesByCategory($id){
	$cat_data = db()->query("SELECT * FROM kategorije WHERE idKategorije=" . $id);
	$course_res = db()->query("
	SELECT pred.naziv_predavanja, u.naziv_ustanove,
    p.ime, p.prezime,  pred.jezik, pred.broj_predavanja, 
    pred.ukupno_trajanje, pred.oznaka, pred.oznaka, pred.opis_kolegija, pred.link_1, pred.link_2, pred.image, prip.kategorije, z.ustanova
    FROM ustanove u 
    INNER JOIN zaposlenje z ON u.idUstanove = z.ustanova
    INNER JOIN predavaci p ON p.idPredavac = z.predavac
    INNER JOIN lekcije l on l.predavac = p.idPredavac
    INNER JOIN predavanja pred ON pred.idPredavanja = l.predavanja
    INNER JOIN pripadnost_kategoriji prip ON pred.idPredavanja = prip.predavanje
    INNER JOIN kategorije k ON k.idKategorije = prip.kategorije
    WHERE k.idKategorije = $id;");
	// Check if the query was successful
	if (db()->error) {
	    echo 'DB Error: ' . db()->error;
		die();
	} else {
	//return the result
	$arr=[];
	$category =null;
	while($row = $cat_data->fetch_assoc()){
		$category = $row;
	}
	while($row = $course_res->fetch_assoc()){
		$arr[] = $row;
	}
	    return [
		"category"=>$category,
		"courses"=>$arr
	];
	}
}

//Search for courses
function searchCourse($query) {
    // Escape the query to prevent SQL injection
    $query = db()->real_escape_string($query);
	$query = strtolower($query);
    // Perform the search, using LOWER() to make case-insensitive comparisons
    $res = db()->query("SELECT pred.naziv_predavanja, u.naziv_ustanove,
        p.ime, p.prezime, pred.jezik, pred.broj_predavanja, 
        pred.ukupno_trajanje, pred.oznaka, pred.opis_kolegija, pred.link_1, pred.link_2, pred.image, prip.kategorije, z.ustanova
        FROM ustanove u 
        INNER JOIN zaposlenje z ON u.idUstanove = z.ustanova
        INNER JOIN predavaci p ON p.idPredavac = z.predavac
        INNER JOIN lekcije l on l.predavac = p.idPredavac
        INNER JOIN predavanja pred ON pred.idPredavanja = l.predavanja
        INNER JOIN pripadnost_kategoriji prip ON pred.idPredavanja = prip.predavanje
        INNER JOIN kategorije k ON k.idKategorije = prip.kategorije
        WHERE LOWER(pred.naziv_predavanja) LIKE '%$query%'
        OR LOWER(pred.opis_kolegija) LIKE '%$query%'
        OR LOWER(p.ime) LIKE '%$query%'
        OR LOWER(p.prezime) LIKE '%$query%'
        OR LOWER(u.naziv_ustanove) LIKE '%$query%'
        OR LOWER(k.naziv_kategorije) LIKE '%$query%';");

    // Check for database errors
    if (db()->error) {
        echo 'DB Error: ' . db()->error;
        die();
    } else {
        // Fetch the result set
        $arr = [];
        while ($row = $res->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }
}



function truncateString($string, $length = 100, $append = "...") {
    if (strlen($string) <= $length) {
        return $string;
    }
    $truncated = substr($string, 0, $length - strlen($append));
    return $truncated . $append;
}