<?php 
require_once 'config.php';

// Select all universities
function selectUstanove(){
	$res = db()->query("SELECT * FROM institutions");
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
	$res = db()->query("SELECT * FROM categories;");
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
    $res = db()->query("SELECT pred.*, pred.name, u.name as u_name,
    p.firstName, p.lastName, k.name as kategorije,
	pred.universityId as ustanova
    FROM courses pred 
    INNER JOIN lecturers p ON p.id = pred.lecturerId
    INNER JOIN institutions u on u.id = pred.universityId
    INNER JOIN categories k ON k.id = pred.categoryId;
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
	$cat_data = db()->query("SELECT * FROM categories WHERE id=" . $id);
	$course_res = db()->query("SELECT pred.*, pred.name, u.name,
    p.firstName, p.lastName, k.name as kategorije,
	pred.universityId as ustanova
    FROM courses pred 
    INNER JOIN lecturers p ON p.id = pred.lecturerId
    INNER JOIN institutions u on u.id = pred.universityId
    INNER JOIN categories k ON k.id = pred.categoryId
	 WHERE k.id = $id;
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

// count courses and total hours for each category
function countCoursesAndHoursByCategory() {
	$query = "SELECT cat.*, c.categoryId, COUNT(c.id) AS courses_count, SUM(c.t_duration) AS hours
			  FROM courses c
			  INNER JOIN categories cat ON c.categoryId = cat.id
			  GROUP BY c.categoryId";
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

// count courses and total hours for each university
function countCoursesAndHoursByUniversity() {
	$query = "SELECT u.*, c.universityId, COUNT(c.id) AS courses_count, SUM(c.t_duration) AS hours
			  FROM courses c
			  INNER JOIN institutions u ON c.universityId = u.id
			  GROUP BY c.universityId";
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

//Search for courses
function searchCourse($query) {
    // Escape the query to prevent SQL injection
    $query = db()->real_escape_string($query);
	$query = strtolower($query);
    // Perform the search, using LOWER() to make case-insensitive comparisons
    $res = db()->query("SELECT pred.*, pred.name, u.name as u_name, 
    p.firstName, p.lastName, k.name as kategorije,
	pred.universityId as ustanova
    FROM courses pred 
    INNER JOIN lecturers p ON p.id = pred.lecturerId
    INNER JOIN institutions u on u.id = pred.universityId
    INNER JOIN categories k ON k.id = pred.categoryId
        WHERE LOWER(pred.name) LIKE LOWER('%$query%')
        OR LOWER(pred.description) LIKE LOWER('%$query%')
        OR LOWER(p.firstName) LIKE LOWER('%$query%')
        OR LOWER(p.lastName) LIKE LOWER('%$query%')
        OR LOWER(u.name) LIKE LOWER('%$query%')
        OR LOWER(k.name) LIKE LOWER('%$query%');");

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
	$res = db()->query('SELECT COUNT(*) as total FROM categories');
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
	$res = db()->query('SELECT COUNT(*) as total FROM courses');
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
	$query = db()->prepare('INSERT INTO categories (name,image) VALUES (?,?)');
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
	$query = db()->prepare('UPDATE categories SET name = ?, image = ? WHERE id = ?');
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
	$query = db()->prepare('DELETE FROM categories WHERE id = ?');
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
	$query = db()->prepare('INSERT INTO institutions (name,country,city,u_image) VALUES (?,?,?,?)');
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
	$query = db()->prepare('UPDATE institutions SET name = ?, country = ?, city = ?, u_image = ? WHERE id = ?');
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
	$query = db()->prepare('DELETE FROM institutions WHERE id = ?');
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
	$query = db()->prepare('INSERT INTO lecturers (firstName,lastName,l_image) VALUES (?,?,?)');
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
	$query = db()->prepare('UPDATE lecturers SET firstName = ?, lastName = ?, l_image = ? WHERE id = ?');
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
	$query = db()->prepare('DELETE FROM lecturers WHERE id = ?');
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
    FROM courses pred 
    INNER JOIN lecturers p ON p.id = pred.lecturerId
    INNER JOIN institutions u on u.id = pred.universityId
    INNER JOIN categories k ON k.id = pred.categoryId";

    $totalRes = db()->query($totalQuery);
    if (db()->error) {
        echo 'DB Error: ' . db()->error;
        die();
    }
    $total = $totalRes->fetch_assoc()['total'];

    // Query to get paginated results
    $dataQuery = "SELECT pred.*, pred.name, u.name as u_name,
    p.firstName, p.lastName, k.name as kategorije,
	pred.universityId as ustanova
    FROM courses pred 
    INNER JOIN lecturers p ON p.id = pred.lecturerId
    INNER JOIN institutions u on u.id = pred.universityId
    INNER JOIN categories k ON k.id = pred.categoryId
	ORDER BY pred.name ASC
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
	$totalQuery = "SELECT COUNT(*) as total FROM lecturers";
	$totalRes = db()->query($totalQuery);
	if (db()->error) {
		echo 'DB Error: ' . db()->error;
		die();
	}
	$total = $totalRes->fetch_assoc()['total'];
	$dataQuery = "SELECT * FROM lecturers ORDER BY firstName asc LIMIT $perPage OFFSET $offset";
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
	$query = "SELECT * FROM lecturers ";
	if($search){
		$query .= "WHERE firstName LIKE '%$search%' OR lastName LIKE '%$search%' order by firstName asc";
	}else{
		$query .= "order by firstName asc";
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
$query = "SELECT * FROM institutions ";
	if($search){
		$query .= "WHERE name LIKE '%$search%' OR country LIKE '%$search%' OR city LIKE '%$search%' order by name asc";
	}else{
		$query .= "order by name asc";
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
	$totalQuery = "SELECT COUNT(*) as total FROM institutions";
	$totalRes = db()->query($totalQuery);
	if (db()->error) {
		echo 'DB Error: ' . db()->error;
		die();
	}
	$total = $totalRes->fetch_assoc()['total'];
	$dataQuery = "SELECT * FROM institutions ORDER BY name asc LIMIT $perPage OFFSET $offset";
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
	$res = db()->query('SELECT * FROM `categories`');
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
	$query = db()->prepare('INSERT INTO courses (name, language, n_lectures, t_duration, description,link_1,link_2,image,year,course_code) VALUES (?,?,?,?,?,?,?,?,?,?)');
	$query->bind_param('ssssssssss', $name, $language, $totalLectures, $totalDuration, $description, $vidLink, $link2, $imgLink,$year,$code);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: ' . $query->error;
		die();
	} else {
		$courseId = $query->insert_id;
	$query = db()->prepare('UPDATE courses SET categoryId = ?, universityId = ?,lecturerId = ? WHERE id = ?');
		$query->bind_param('ssss', $categoryId,$universityId,$lecturerId, $courseId);
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
	$query = db()->prepare('UPDATE courses SET name = ?, language = ?, n_lectures = ?, t_duration = ?, description = ?, link_1 = ?, link_2 = ?, image = ?, year = ?, course_code = ? WHERE id = ?');
	$query->bind_param('sssssssssss', $name, $language, $totalLectures, $totalDuration, $description, $vidLink, $link2, $imgLink,$year,$code,$id);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: ' . $query->error;
		die();
	} else {
		//update course <-> category
		$query = db()->prepare('UPDATE courses SET categoryId = ?, universityId = ?,lecturerId = ? WHERE id = ?');
		$query->bind_param('ssss', $categoryId,$universityId,$lecturerId, $id);
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
	$query = db()->prepare('DELETE FROM courses WHERE id = ?');
	$query->bind_param('s', $id);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: '. $query->error;
		die();
	} else {
		return true;
	}
}