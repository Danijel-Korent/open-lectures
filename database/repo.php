<?php 
require_once 'config.php';

// Select all universities
function selectUstanove(){
	$res = DBClass::query("SELECT * FROM institutions");
	if (DBClass::error()) {
	    echo 'DB Error: ' . DBClass::error();
		die();
	} else {
	//return the result
	$data = DBClass::fetch_assoc($res);
		return $data;
	}
};

// Select all categories
function selectKategorije(){
	$res = DBClass::query("SELECT * FROM categories");
	// Check if the query was successful
	if (DBClass::error()) {
	    echo 'DB Error: ' . DBClass::error();
		die();
	} else {
	//return the result
	return DBClass::fetch_assoc($res);
	}
};

// Select all courses
function selectOpisPred (){
    $res = DBClass::query("SELECT pred.*, pred.name, u.name as u_name,
    p.firstName, p.lastName, k.name as kategorije,
	pred.universityId as ustanova
    FROM courses pred 
    INNER JOIN lecturers p ON p.id = pred.lecturerId
    INNER JOIN institutions u on u.id = pred.universityId
    INNER JOIN categories k ON k.id = pred.categoryId");
   if (DBClass::error()) {
		echo 'DB Error: ' . DBClass::error();
		die();
	} else {
		//return the result
		return DBClass::fetch_assoc($res);
	}
};

//Select all courses by category
function selectCoursesByCategory($id){
	// Validate and sanitize input
	$id = (int)$id;
	if ($id <= 0) {
		return [
			"category" => null,
			"courses" => []
		];
	}

	// Use prepared statements to prevent SQL injection
	$cat_stmt = DBClass::prepare("SELECT * FROM categories WHERE id = ?");
	$cat_stmt->bind_param('i', $id);
	$cat_stmt->execute();
	$cat_result = $cat_stmt->get_result();
	$category = $cat_result ? DBClass::fetch_single($cat_result) : null;

	if ($cat_stmt->error) {
		echo 'DB Error: ' . $cat_stmt->error;
		die();
	}

	$course_stmt = DBClass::prepare("SELECT pred.*, u.name as course_university,
    p.firstName, p.lastName, k.name as kategorije,
	pred.universityId as ustanova
    FROM courses pred 
    INNER JOIN lecturers p ON p.id = pred.lecturerId
    INNER JOIN institutions u on u.id = pred.universityId
    INNER JOIN categories k ON k.id = pred.categoryId
	 WHERE k.id = ?");
	$course_stmt->bind_param('i', $id);
	$course_stmt->execute();
	$course_result = $course_stmt->get_result();

	// Check if the query was successful
	if ($course_stmt->error) {
	    echo 'DB Error: ' . $course_stmt->error;
		die();
	} else {
		//return the result
		$arr = $course_result ? DBClass::fetch_assoc($course_result) : [];
		
		return [
			"category" => $category,
			"courses" => $arr
		];
	}
}

// count courses and total hours for each category
function countCoursesAndHoursByCategory() {
	// order by hours
	$query = "SELECT k.name, COUNT(c.id) AS courses_count, SUM(c.t_duration) AS hours
			  FROM courses c
			  INNER JOIN categories k ON c.categoryId = k.id
			  GROUP BY c.categoryId
			  ORDER BY hours DESC";
	$res = DBClass::query($query);
	
	if (DBClass::error()) {
		echo 'DB Error: ' . DBClass::error();
		die();
	} else {
		return DBClass::fetch_assoc($res);
	}
}

// count courses and total hours for each university
function countCoursesAndHoursByUniversity() {
	$query = "SELECT u.*, c.universityId, COUNT(c.id) AS courses_count, SUM(c.t_duration) AS hours
			  FROM courses c
			  INNER JOIN institutions u ON c.universityId = u.id
			  GROUP BY c.universityId ORDER BY hours DESC";
	$res = DBClass::query($query);
	
	if (DBClass::error()) {
		echo 'DB Error: ' . DBClass::error();
		die();
	} else {
		return DBClass::fetch_assoc($res);
	}
}

//Search for courses
function searchCourse($query) {
    // Sanitize and prepare search term
    $searchTerm = trim($query);
    if (empty($searchTerm)) {
        return [];
    }
    
    // Prepare LIKE pattern with wildcards (safe - wildcards are added in PHP, not user input)
    $searchPattern = '%' . strtolower($searchTerm) . '%';
    
    // Use prepared statements to prevent SQL injection
    $stmt = DBClass::prepare("SELECT pred.*, pred.name, u.name as u_name, 
    p.firstName, p.lastName, k.name as kategorije,
	pred.universityId as ustanova
    FROM courses pred 
    INNER JOIN lecturers p ON p.id = pred.lecturerId
    INNER JOIN institutions u on u.id = pred.universityId
    INNER JOIN categories k ON k.id = pred.categoryId
        WHERE LOWER(pred.name) LIKE LOWER(?)
        OR LOWER(pred.description) LIKE LOWER(?)
        OR LOWER(p.firstName) LIKE LOWER(?)
        OR LOWER(p.lastName) LIKE LOWER(?)
        OR LOWER(u.name) LIKE LOWER(?)
        OR LOWER(k.name) LIKE LOWER(?)");
    
    // Bind the same search pattern to all 6 placeholders
    $stmt->bind_param('ssssss', $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check for database errors
    if ($stmt->error) {
        echo 'DB Error: ' . $stmt->error;
        die();
    } else {
        // Fetch the result set
        return $result ? DBClass::fetch_assoc($result) : [];
    }
}

function countCategories(){
	$res = DBClass::query('SELECT COUNT(*) as total FROM categories');
	if (DBClass::error()) {
	    echo 'DB Error: ' . DBClass::error();
		die();
	} else {
		return DBClass::fetch_assoc($res);
	}
}

function countCourses(){
	$res = DBClass::query('SELECT COUNT(*) as total FROM courses');
	if (DBClass::error()) {
	    echo 'DB Error: ' . DBClass::error();
		die();
	} else {
		return DBClass::fetch_assoc($res);
	}	
}

function truncateString($string, $length = 100, $append = "...") {
    if (strlen($string) <= $length) {
        return $string;
    }
    $truncated = substr($string, 0, $length - strlen($append));
    return $truncated . $append;
}

function reportBrokenLink(int $courseId) {
	if ($courseId <= 0) {
		return false;
	}

	$update = DBClass::prepare('UPDATE courses SET broken_reports = COALESCE(broken_reports, 0) + 1 WHERE id = ?');
	$update->bind_param('i', $courseId);
	$update->execute();

	if ($update->error) {
		return false;
	}

	$select = DBClass::prepare('SELECT broken_reports FROM courses WHERE id = ?');
	$select->bind_param('i', $courseId);
	$select->execute();
	$result = $select->get_result();
	$row = $result ? DBClass::fetch_single($result) : null;

	return $row ? (int)$row['broken_reports'] : false;
}

///ADMIN FUNCTIONS

//Insert Category
function insertCategory($name,$imageName){
	$query = DBClass::prepare('INSERT INTO categories (name,image) VALUES (?,?)');
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
	$query = DBClass::prepare('UPDATE categories SET name = ?, image = ? WHERE id = ?');
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
	$query = DBClass::prepare('DELETE FROM categories WHERE id = ?');
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
	$query = DBClass::prepare('INSERT INTO institutions (name,country,city,u_image) VALUES (?,?,?,?)');
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
	$query = DBClass::prepare('UPDATE institutions SET name = ?, country = ?, city = ?, u_image = ? WHERE id = ?');
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
	$query = DBClass::prepare('DELETE FROM institutions WHERE id = ?');
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
	$query = DBClass::prepare('INSERT INTO lecturers (firstName,lastName,l_image) VALUES (?,?,?)');
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
	$query = DBClass::prepare('UPDATE lecturers SET firstName = ?, lastName = ?, l_image = ? WHERE id = ?');
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
	$query = DBClass::prepare('DELETE FROM lecturers WHERE id = ?');
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

    $totalRes = DBClass::query($totalQuery);
    if (DBClass::error()) {
        echo 'DB Error: ' . DBClass::error();
        die();
    }
    $totalRow = DBClass::fetch_single($totalRes);
    $total = $totalRow['total'];

    // Query to get paginated results
    $dataQuery = "SELECT pred.*, pred.name, u.name as u_name,
    p.firstName, p.lastName, k.name as kategorije,
	pred.universityId as ustanova
    FROM courses pred 
    INNER JOIN lecturers p ON p.id = pred.lecturerId
    INNER JOIN institutions u on u.id = pred.universityId
    INNER JOIN categories k ON k.id = pred.categoryId
	ORDER BY pred.name ASC
	LIMIT $perPage OFFSET $offset";

    $dataRes = DBClass::query($dataQuery);
    if (DBClass::error()) {
        echo 'DB Error: ' . DBClass::error();
        die();
    }

    // Fetch paginated results
    $data = DBClass::fetch_assoc($dataRes);

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
	$totalRes = DBClass::query($totalQuery);
	if (DBClass::error()) {
		echo 'DB Error: ' . DBClass::error();
		die();
	}
	$totalRow = DBClass::fetch_single($totalRes);
	$total = $totalRow['total'];
	$dataQuery = "SELECT * FROM lecturers ORDER BY firstName asc LIMIT $perPage OFFSET $offset";
	$dataRes = DBClass::query($dataQuery);
	if (DBClass::error()) {
		echo 'DB Error: ' . DBClass::error();
		die();
	}
	$data = DBClass::fetch_assoc($dataRes);
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
	$res = DBClass::query($query);
	if (DBClass::error()) {
		echo 'DB Error: ' . DBClass::error();
		die();
	} else {
		return DBClass::fetch_assoc($res);
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
	$res = DBClass::query($query);
	if (DBClass::error()) {
		echo 'DB Error: ' . DBClass::error();
		die();
	} else {
		return DBClass::fetch_assoc($res);
	}
}

function selectPaginatedUniversity($page = 1, $perPage = 10){
	$offset = ($page - 1) * $perPage;
	$totalQuery = "SELECT COUNT(*) as total FROM institutions";
	$totalRes = DBClass::query($totalQuery);
	if (DBClass::error()) {
		echo 'DB Error: ' . DBClass::error();
		die();
	}
	$totalRow = DBClass::fetch_single($totalRes);
	$total = $totalRow['total'];
	$dataQuery = "SELECT * FROM institutions ORDER BY name asc LIMIT $perPage OFFSET $offset";
	$dataRes = DBClass::query($dataQuery);
	if (DBClass::error()) {
		echo 'DB Error: ' . DBClass::error();
		die();
	}
	$data = DBClass::fetch_assoc($dataRes);
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
	$res = DBClass::query('SELECT * FROM categories');
// Check if the query was successful
	if (DBClass::error()) {
	    echo 'DB Error: ' . DBClass::error();
		die();
	} else {
	//return the result
	return DBClass::fetch_assoc($res);
	}
}

//Insert course
function insertCourse($name,$categoryId,$lecturerId,$universityId,$year,$language,$totalLectures,$totalDuration,$description,$vidLink,$link2,$imgLink,$code){
	//insert course
	$query = DBClass::prepare('INSERT INTO courses (name, language, n_lectures, t_duration, description,link_1,link_2,image,year,course_code) VALUES (?,?,?,?,?,?,?,?,?,?)');
	$query->bind_param('ssssssssss', $name, $language, $totalLectures, $totalDuration, $description, $vidLink, $link2, $imgLink,$year,$code);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: ' . $query->error;
		die();
	} else {
		$courseId = DBClass::insert_id();
	$query = DBClass::prepare('UPDATE courses SET categoryId = ?, universityId = ?,lecturerId = ? WHERE id = ?');
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
	$query = DBClass::prepare('UPDATE courses SET name = ?, language = ?, n_lectures = ?, t_duration = ?, description = ?, link_1 = ?, link_2 = ?, image = ?, year = ?, course_code = ? WHERE id = ?');
	$query->bind_param('sssssssssss', $name, $language, $totalLectures, $totalDuration, $description, $vidLink, $link2, $imgLink,$year,$code,$id);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: ' . $query->error;
		die();
	} else {
		//update course <-> category
		$query = DBClass::prepare('UPDATE courses SET categoryId = ?, universityId = ?,lecturerId = ? WHERE id = ?');
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
	$query = DBClass::prepare('DELETE FROM courses WHERE id = ?');
	$query->bind_param('s', $id);
	$query->execute();
	if ($query->error) {
		echo 'DB Error: '. $query->error;
		die();
	} else {
		return true;
	}
}