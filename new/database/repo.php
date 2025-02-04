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
    $res = db()->query("SELECT pred.*, pred.naziv_predavanja, u.naziv_ustanove,
    p.ime, p.prezime, k.naziv_kategorije as kategorije,
	pred.ustanoveId as ustanova
    FROM predavanja pred 
    INNER JOIN predavaci p ON p.idPredavac = pred.predavaciId
    INNER JOIN ustanove u on u.idUstanove = pred.ustanoveId
    INNER JOIN kategorije k ON k.idKategorije = pred.kategorijeId;
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
	$course_res = db()->query("SELECT pred.*, pred.naziv_predavanja, u.naziv_ustanove,
    p.ime, p.prezime, k.naziv_kategorije as kategorije,
	pred.ustanoveId as ustanova
    FROM predavanja pred 
    INNER JOIN predavaci p ON p.idPredavac = pred.predavaciId
    INNER JOIN ustanove u on u.idUstanove = pred.ustanoveId
    INNER JOIN kategorije k ON k.idKategorije = pred.kategorijeId
	 WHERE k.idKategorije = $id;
	");
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
    $res = db()->query("SELECT pred.*, pred.naziv_predavanja, u.naziv_ustanove,
    p.ime, p.prezime, k.naziv_kategorije as kategorije,
	pred.ustanoveId as ustanova
    FROM predavanja pred 
    INNER JOIN predavaci p ON p.idPredavac = pred.predavaciId
    INNER JOIN ustanove u on u.idUstanove = pred.ustanoveId
    INNER JOIN kategorije k ON k.idKategorije = pred.kategorijeId
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

//UNIVERSITY FUNCTIONS
function insertUniversity($name,$country,$city,$imageName){
	$query = db()->prepare('INSERT INTO ustanove (naziv_ustanove,drzava,mjesto,slika_ustanove) VALUES (?,?,?,?)');
	$query->bind_param('ssss', $name, $country, $city, $imageName);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: ' . $query->error;
		die();
	} else {
		return true;
	}
}

function updateUniversity($id,$name,$country,$city,$imageName){
	$query = db()->prepare('UPDATE ustanove SET naziv_ustanove = ?, drzava = ?, mjesto = ?, slika_ustanove = ? WHERE idUstanove = ?');
	$query->bind_param('sssss', $name, $country, $city, $imageName, $id);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: '. $query->error;
		die();
	} else {
		return true;
	}
}

function deleteUniversity($id){
	$query = db()->prepare('DELETE FROM ustanove WHERE idUstanove = ?');
	$query->bind_param('s', $id);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: '. $query->error;
		die();
	} else {
		return true;
	}
}

//LECTURER FUNCTIONS
function insertLecturer($firstName,$lastName,$imageName){
	$query = db()->prepare('INSERT INTO predavaci (ime,prezime,slika_predavaca) VALUES (?,?,?)');
	$query->bind_param('sss', $firstName, $lastName, $imageName);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: ' . $query->error;
		die();
	} else {
		return true;
	}
	
}

function updateLecturer($id,$firstName,$lastName,$imageName){
	$query = db()->prepare('UPDATE predavaci SET ime = ?, prezime = ?, slika_predavaca = ? WHERE idPredavac = ?');
	$query->bind_param('ssss', $firstName, $lastName, $imageName, $id);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: '. $query->error;
		die();
	} else {
		return true;
	}
}

function deleteLecturer($id){
	$query = db()->prepare('DELETE FROM predavaci WHERE idPredavac = ?');
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
    FROM predavanja pred 
    INNER JOIN predavaci p ON p.idPredavac = pred.predavaciId
    INNER JOIN ustanove u on u.idUstanove = pred.ustanoveId
    INNER JOIN kategorije k ON k.idKategorije = pred.kategorijeId";

    $totalRes = db()->query($totalQuery);
    if (db()->error) {
        echo 'DB Error: ' . db()->error;
        die();
    }
    $total = $totalRes->fetch_assoc()['total'];

    // Query to get paginated results
    $dataQuery = "SELECT pred.*, pred.naziv_predavanja, u.naziv_ustanove,
    p.ime, p.prezime, k.naziv_kategorije as kategorije,
	pred.ustanoveId as ustanova
    FROM predavanja pred 
    INNER JOIN predavaci p ON p.idPredavac = pred.predavaciId
    INNER JOIN ustanove u on u.idUstanove = pred.ustanoveId
    INNER JOIN kategorije k ON k.idKategorije = pred.kategorijeId
	ORDER BY pred.naziv_predavanja ASC
	LIMIT $perPage OFFSET $offset;
	";

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

function selectPaginatedLecturers($page = 1, $perPage = 10){
	$offset = ($page - 1) * $perPage;
	$totalQuery = "SELECT COUNT(*) as total FROM predavaci";
	$totalRes = db()->query($totalQuery);
	if (db()->error) {
		echo 'DB Error: ' . db()->error;
		die();
	}
	$total = $totalRes->fetch_assoc()['total'];
	$dataQuery = "SELECT * FROM predavaci ORDER BY ime asc LIMIT $perPage OFFSET $offset";
	$dataRes = db()->query($dataQuery);
	if (db()->error) {
		echo 'DB Error: ' . db()->error;
		die();
	}
	$data = [];
	while ($row = $dataRes->fetch_assoc()) {
		$data[] = $row;
	}
	return [
		'data' => $data,
		'total' => $total,
		'currentPage' => $page,
		'perPage' => $perPage,
		'totalPages' => ceil($total / $perPage),
	];
}

//Select all lecturers
function selectAllLecturers($search =""){
	$query = "SELECT * FROM predavaci ";
	if($search){
		$query .= "WHERE ime LIKE '%$search%' OR prezime LIKE '%$search%' order by ime asc";
	}else{
		$query .= "order by ime asc";
	}
	$res = db()->query($query);
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

//select all universities
function selectAllUniversity($search=""){
$query = "SELECT * FROM ustanove ";
	if($search){
		$query .= "WHERE naziv_ustanove LIKE '%$search%' OR drzava LIKE '%$search%' OR mjesto LIKE '%$search%' order by naziv_ustanove asc";
	}else{
		$query .= "order by naziv_ustanove asc";
	}
	$res = db()->query($query);
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

function selectPaginatedUniversity($page = 1, $perPage = 10){
	$offset = ($page - 1) * $perPage;
	$totalQuery = "SELECT COUNT(*) as total FROM ustanove";
	$totalRes = db()->query($totalQuery);
	if (db()->error) {
		echo 'DB Error: ' . db()->error;
		die();
	}
	$total = $totalRes->fetch_assoc()['total'];
	$dataQuery = "SELECT * FROM ustanove ORDER BY naziv_ustanove asc LIMIT $perPage OFFSET $offset";
	$dataRes = db()->query($dataQuery);
	if (db()->error) {
		echo 'DB Error: ' . db()->error;
		die();
	}
	$data = [];
	while ($row = $dataRes->fetch_assoc()) {
		$data[] = $row;
	}
	return [
		'data' => $data,
		'total' => $total,
		'currentPage' => $page,
		'perPage' => $perPage,
		'totalPages' => ceil($total / $perPage),
	];
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
function insertCourse($name,$categoryId,$lecturerId,$universityId,$year,$language,$totalLectures,$totalDuration,$description,$vidLink,$link2,$imgLink,$code){
	//insert course
	$query = db()->prepare('INSERT INTO predavanja (naziv_predavanja, jezik, broj_predavanja, ukupno_trajanje, opis_kolegija,link_1,link_2,image,godina,oznaka) VALUES (?,?,?,?,?,?,?,?,?,?)');
	$query->bind_param('ssssssssss', $name, $language, $totalLectures, $totalDuration, $description, $vidLink, $link2, $imgLink,$year,$code);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: ' . $query->error;
		die();
	} else {
		$courseId = $query->insert_id;
		//insert course <-> category
		$query = db()->prepare('INSERT INTO pripadnost_kategoriji (predavanje,kategorije) VALUES (?,?)');
		$query->bind_param('ss', $courseId, $categoryId);
		$query->execute();
		if ($query->error) {
			echo 'DB Error: ' . $query->error;
			die();
		}
		//insert course <-> lecturer
		$query = db()->prepare('INSERT INTO lekcije (predavanja,predavac) VALUES (?,?)');
		$query->bind_param('ss', $courseId, $lecturerId);
		$query->execute();
		if ($query->error) {
			echo 'DB Error: ' . $query->error;
			die();
		}
		//insert course <-> university
		$query = db()->prepare('INSERT INTO zaposlenje (predavac,ustanova) VALUES (?,?)');
		$query->bind_param('ss', $lecturerId, $universityId);
		$query->execute();
		if ($query->error) {
			echo 'DB Error: ' . $query->error;
			die();
		}
		return true;
	}
}

//Update course
function updateCourse($id,$universityLecturerId,$name,$categoryId,$lecturerId,$universityId,$year,$language,$totalLectures,$totalDuration,$description,$vidLink,$link2,$imgLink,$code){
	//update course
	$query = db()->prepare('UPDATE predavanja SET naziv_predavanja = ?, jezik = ?, broj_predavanja = ?, ukupno_trajanje = ?, opis_kolegija = ?, link_1 = ?, link_2 = ?, image = ?, godina = ?, oznaka = ? WHERE idPredavanja = ?');
	$query->bind_param('sssssssssss', $name, $language, $totalLectures, $totalDuration, $description, $vidLink, $link2, $imgLink,$year,$code,$id);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: ' . $query->error;
		die();
	} else {
		//update course <-> category
		$query = db()->prepare('UPDATE pripadnost_kategoriji SET kategorije = ? WHERE predavanje = ?');
		$query->bind_param('ss', $categoryId, $id);
		$query->execute();
		if ($query->error) {
			echo 'DB Error: ' . $query->error;
			die();
		}
		//update course <-> lecturer
		$query = db()->prepare('UPDATE lekcije SET predavac = ? WHERE predavanja = ?');
		$query->bind_param('ss', $lecturerId, $id);
		$query->execute();
		if ($query->error) {
			echo 'DB Error: ' . $query->error;
			die();
		}
		//update course <-> university
		$query = db()->prepare('UPDATE zaposlenje SET ustanova = ?, predavac = ? WHERE idZaposlenje =?');
		$query->bind_param('sss', $universityId, $lecturerId,$universityLecturerId);
		$query->execute();
		if ($query->error) {
			echo 'DB Error: ' . $query->error;
			die();
		}
		return true;
	}
}

//Delete course
function deleteCourse($id){
	$query = db()->prepare('DELETE FROM predavanja WHERE idPredavanja = ?');
	$query->bind_param('s', $id);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: '. $query->error;
		die();
	} else {
		//delete course <-> category
		$query = db()->prepare('DELETE FROM pripadnost_kategoriji WHERE predavanje = ?');
		$query->bind_param('s', $id);
		$query->execute();
		//delete course <-> lecturer
		$query = db()->prepare('DELETE FROM lekcije WHERE predavanja = ?');
		$query->bind_param('s', $id);
		$query->execute();
		return true;
	}
}