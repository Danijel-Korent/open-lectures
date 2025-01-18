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

function countCategories(){
	$res = db()->query('SELECT COUNT(*) as total FROM kategorije');
	if (db()->error) {
	    echo 'DB Error: ' . db()->error;
		die();
	} else {
		$arr = [];
		while ($row = $res->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}
}

function countCourses(){
	$res = db()->query('SELECT COUNT(*) as total FROM predavanja');
	if (db()->error) {
	    echo 'DB Error: ' . db()->error;
		die();
	} else {
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

///ADMIN FUNCTIONS

//Insert Category
function insertCategory($name,$imageName){
	$query = db()->prepare('INSERT INTO kategorije (naziv_kategorije,slika_kategorije) VALUES (?,?)');
	$query->bind_param('ss', $name, $imageName);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: ' . $query->error;
		die();
	} else {
		return true;
	}
}

function updateCategory($id,$name,$imageName){
	$query = db()->prepare('UPDATE kategorije SET naziv_kategorije = ?, slika_kategorije = ? WHERE idKategorije = ?');
	$query->bind_param('sss', $name, $imageName, $id);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: '. $query->error;
		die();
	} else {
		return true;
	}
}

function deleteCategory($id){
	$query = db()->prepare('DELETE FROM kategorije WHERE idKategorije = ?');
	$query->bind_param('s', $id);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: '. $query->error;
		die();
	} else {
		return true;
	}
}

//Paginated courses
function selectPaginatedCourse($page = 1, $perPage = 10) {
    // Calculate offset for pagination
    $offset = ($page - 1) * $perPage;

    // Query to get total number of elements
    $totalQuery = "SELECT COUNT(*) as total
                   FROM ustanove u
                   INNER JOIN zaposlenje z ON u.idUstanove = z.ustanova
                   INNER JOIN predavaci p ON p.idPredavac = z.predavac
                   INNER JOIN lekcije l ON l.predavac = p.idPredavac
                   INNER JOIN predavanja pred ON pred.idPredavanja = l.predavanja
                   INNER JOIN pripadnost_kategoriji prip ON pred.idPredavanja = prip.predavanje
                   INNER JOIN kategorije k ON k.idKategorije = prip.kategorije";

    $totalRes = db()->query($totalQuery);
    if (db()->error) {
        echo 'DB Error: ' . db()->error;
        die();
    }
    $total = $totalRes->fetch_assoc()['total'];

    // Query to get paginated results
    $dataQuery = "SELECT pred.naziv_predavanja, u.naziv_ustanove,
                         p.ime, p.prezime, pred.jezik, pred.broj_predavanja, 
                         pred.ukupno_trajanje, pred.oznaka, pred.opis_kolegija, 
                         pred.link_1, pred.link_2, pred.image, prip.kategorije, z.ustanova
                  FROM ustanove u
                  INNER JOIN zaposlenje z ON u.idUstanove = z.ustanova
                  INNER JOIN predavaci p ON p.idPredavac = z.predavac
                  INNER JOIN lekcije l ON l.predavac = p.idPredavac
                  INNER JOIN predavanja pred ON pred.idPredavanja = l.predavanja
                  INNER JOIN pripadnost_kategoriji prip ON pred.idPredavanja = prip.predavanje
                  INNER JOIN kategorije k ON k.idKategorije = prip.kategorije
				  ORDER BY pred.naziv_predavanja asc
                  LIMIT $perPage OFFSET $offset ";

    $dataRes = db()->query($dataQuery);
    if (db()->error) {
        echo 'DB Error: ' . db()->error;
        die();
    }

    // Fetch paginated results
    $data = [];
    while ($row = $dataRes->fetch_assoc()) {
        $data[] = $row;
    }

    // Return paginated data and total count
    return [
        'data' => $data,
        'total' => $total,
        'currentPage' => $page,
        'perPage' => $perPage,
        'totalPages' => ceil($total / $perPage),
    ];
}

//Select all lecturers
function selectAllLecturers(){
	$res = db()->query("SELECT * FROM predavaci;");
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
}

//select all universities
function selectAllUniversity(){
	$res = db()->query('SELECT * FROM `ustanove`');
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
}

//select all categories
function selectAllCategories(){
	$res = db()->query('SELECT * FROM `kategorije`');
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
}

//Insert course
function insertCourse(){
	//insert course
	//insert course <-> category
	//insert course <-> lecturer
	//insert course <-> university
}