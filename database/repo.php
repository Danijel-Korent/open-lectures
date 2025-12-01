<?php 
require_once 'config.php';

/**
 * Select all universities/institutions from the database.
 * 
 * @return array Array of institution records with id, name, country, city, and u_image fields.
 *               Returns empty array on error.
 */
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

/**
 * Select all categories from the database.
 * 
 * @return array Array of category records with id, name, and image fields.
 *               Returns empty array on error.
 */
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

/**
 * Select all courses with related data (lecturer, institution, category).
 * 
 * @return array Array of course records with joined data including:
 *               - Course fields (id, name, description, link_1, link_2, image, etc.)
 *               - Lecturer name (firstName, lastName)
 *               - Institution name (u_name)
 *               - Category name (kategorije)
 *               - University ID (ustanova)
 *               Returns empty array on error.
 */
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

/**
 * Select all courses for a specific category with related data.
 * Uses prepared statements to prevent SQL injection.
 * 
 * @param int|string $id Category ID (will be cast to integer)
 * @return array Associative array with keys:
 *               - 'category': Category record (id, name, image) or null if not found
 *               - 'courses': Array of course records with joined lecturer, institution, and category data
 *               Returns array with null category and empty courses array if invalid ID.
 */
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

/**
 * Count courses and calculate total hours for each category.
 * Results are ordered by total hours in descending order.
 * 
 * @return array Array of associative arrays with keys:
 *               - 'name': Category name
 *               - 'courses_count': Number of courses in the category
 *               - 'hours': Total duration in hours for all courses in the category
 *               Returns empty array on error.
 */
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

/**
 * Count courses and calculate total hours for each university/institution.
 * Results are ordered by total hours in descending order.
 * 
 * @return array Array of associative arrays with keys:
 *               - All institution fields (id, name, country, city, u_image)
 *               - 'universityId': Institution ID
 *               - 'courses_count': Number of courses from the institution
 *               - 'hours': Total duration in hours for all courses from the institution
 *               Returns empty array on error.
 */
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

/**
 * Search for courses by name, description, lecturer name, institution name, or category name.
 * Uses prepared statements with LIKE pattern matching (case-insensitive).
 * 
 * @param string $query Search term to match against course fields
 * @return array Array of course records matching the search term, with joined data:
 *               - Course fields (id, name, description, etc.)
 *               - Lecturer name (firstName, lastName)
 *               - Institution name (u_name)
 *               - Category name (kategorije)
 *               - University ID (ustanova)
 *               Returns empty array if search term is empty or on error.
 */
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

/**
 * Count the total number of categories in the database.
 * 
 * @return array Associative array with key 'total' containing the count.
 *               Returns empty array on error.
 */
function countCategories(){
	$res = DBClass::query('SELECT COUNT(*) as total FROM categories');
	if (DBClass::error()) {
	    echo 'DB Error: ' . DBClass::error();
		die();
	} else {
		return DBClass::fetch_assoc($res);
	}
}

/**
 * Count the total number of courses in the database.
 * 
 * @return array Associative array with key 'total' containing the count.
 *               Returns empty array on error.
 */
function countCourses(){
	$res = DBClass::query('SELECT COUNT(*) as total FROM courses');
	if (DBClass::error()) {
	    echo 'DB Error: ' . DBClass::error();
		die();
	} else {
		return DBClass::fetch_assoc($res);
	}	
}

/**
 * Truncate a string to a specified length and append a suffix if truncated.
 * 
 * @param string $string The string to truncate
 * @param int $length Maximum length of the truncated string (default: 100)
 * @param string $append String to append if truncation occurs (default: "...")
 * @return string Truncated string with append suffix if original was longer than length
 */
function truncateString($string, $length = 100, $append = "...") {
    if (strlen($string) <= $length) {
        return $string;
    }
    $truncated = substr($string, 0, $length - strlen($append));
    return $truncated . $append;
}

/**
 * Increment the broken_reports counter for a course.
 * Uses prepared statements to safely update the database.
 * 
 * @param int $courseId The ID of the course to report as broken
 * @return int|false The updated broken_reports count on success, false on error or invalid course ID
 */
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

/**
 * Insert a new category into the database.
 * 
 * @param string $name Category name
 * @param string $imageName Image filename for the category
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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

/**
 * Update an existing category in the database.
 * 
 * @param int|string $id Category ID to update
 * @param string $name New category name
 * @param string $imageName New image filename
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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

/**
 * Delete a category from the database.
 * 
 * @param int|string $id Category ID to delete
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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

/**
 * Insert a new university/institution into the database.
 * 
 * @param string $name Institution name
 * @param string $country Country where the institution is located
 * @param string $city City where the institution is located
 * @param string $imageName Image filename for the institution logo
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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

/**
 * Update an existing university/institution in the database.
 * 
 * @param int|string $id Institution ID to update
 * @param string $name New institution name
 * @param string $country New country
 * @param string $city New city
 * @param string $imageName New image filename
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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

/**
 * Delete a university/institution from the database.
 * 
 * @param int|string $id Institution ID to delete
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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

/**
 * Insert a new lecturer into the database.
 * 
 * @param string $firstName Lecturer's first name
 * @param string $lastName Lecturer's last name
 * @param string $imageName Image filename for the lecturer's profile picture
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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

/**
 * Update an existing lecturer in the database.
 * 
 * @param int|string $id Lecturer ID to update
 * @param string $firstName New first name
 * @param string $lastName New last name
 * @param string $imageName New image filename
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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

/**
 * Delete a lecturer from the database.
 * 
 * @param int|string $id Lecturer ID to delete
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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

/**
 * Select paginated courses with related data (lecturer, institution, category).
 * Results are ordered by course name in ascending order.
 * 
 * @param int $page Current page number (default: 1)
 * @param int $perPage Number of courses per page (default: 10)
 * @return array Associative array with keys:
 *               - 'data': Array of course records for the current page
 *               - 'total': Total number of courses
 *               - 'currentPage': Current page number
 *               - 'perPage': Number of items per page
 *               - 'totalPages': Total number of pages
 *               Returns array with empty data on error.
 */
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

    // Query to get paginated results - use prepared statement for safety
    $perPage = (int)$perPage;
    $offset = (int)$offset;
    $stmt = DBClass::prepare("SELECT pred.*, pred.name, u.name as u_name,
    p.firstName, p.lastName, k.name as kategorije,
	pred.universityId as ustanova
    FROM courses pred 
    INNER JOIN lecturers p ON p.id = pred.lecturerId
    INNER JOIN institutions u on u.id = pred.universityId
    INNER JOIN categories k ON k.id = pred.categoryId
	ORDER BY pred.name ASC
	LIMIT ? OFFSET ?");
    $stmt->bind_param('ii', $perPage, $offset);
    $stmt->execute();
    $dataRes = $stmt->get_result();

    if ($stmt->error) {
        echo 'DB Error: ' . $stmt->error;
        die();
    }

    // Fetch paginated results
    $data = $dataRes ? DBClass::fetch_assoc($dataRes) : [];

    // Return paginated data and total count
    return [
        'data' => $data,
        'total' => $total,
        'currentPage' => $page,
        'perPage' => $perPage,
        'totalPages' => ceil($total / $perPage),
    ];
}

/**
 * Select paginated lecturers from the database.
 * Results are ordered by first name in ascending order.
 * 
 * @param int $page Current page number (default: 1)
 * @param int $perPage Number of lecturers per page (default: 10)
 * @return array Associative array with keys:
 *               - 'data': Array of lecturer records for the current page
 *               - 'total': Total number of lecturers
 *               - 'currentPage': Current page number
 *               - 'perPage': Number of items per page
 *               - 'totalPages': Total number of pages
 *               Returns array with empty data on error.
 */
function selectPaginatedLecturers($page = 1, $perPage = 10){
	$page = (int)$page;
	$perPage = (int)$perPage;
	$offset = ($page - 1) * $perPage;
	
	$totalQuery = "SELECT COUNT(*) as total FROM lecturers";
	$totalRes = DBClass::query($totalQuery);
	if (DBClass::error()) {
		echo 'DB Error: ' . DBClass::error();
		die();
	}
	$totalRow = DBClass::fetch_single($totalRes);
	$total = $totalRow['total'];
	
	$stmt = DBClass::prepare("SELECT * FROM lecturers ORDER BY firstName ASC LIMIT ? OFFSET ?");
	$stmt->bind_param('ii', $perPage, $offset);
	$stmt->execute();
	$dataRes = $stmt->get_result();
	
	if ($stmt->error) {
		echo 'DB Error: ' . $stmt->error;
		die();
	}
	$data = $dataRes ? DBClass::fetch_assoc($dataRes) : [];
	return [
		'data' => $data,
		'total' => $total,
		'currentPage' => $page,
		'perPage' => $perPage,
		'totalPages' => ceil($total / $perPage),
	];
}

/**
 * Select all lecturers from the database, optionally filtered by search term.
 * Uses prepared statements to prevent SQL injection.
 * 
 * @param string $search Optional search term to filter by first or last name (default: empty string)
 * @return array Array of lecturer records matching the search criteria.
 *               Results are ordered by first name in ascending order.
 *               Returns empty array on error or if search term is empty and no lecturers exist.
 */
function selectAllLecturers($search =""){
	$search = trim($search);
	
	if($search){
		$searchPattern = '%' . $search . '%';
		$stmt = DBClass::prepare("SELECT * FROM lecturers WHERE firstName LIKE ? OR lastName LIKE ? ORDER BY firstName ASC");
		$stmt->bind_param('ss', $searchPattern, $searchPattern);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($stmt->error) {
			echo 'DB Error: ' . $stmt->error;
			die();
		} else {
			return $result ? DBClass::fetch_assoc($result) : [];
		}
	} else {
		$res = DBClass::query("SELECT * FROM lecturers ORDER BY firstName ASC");
		if (DBClass::error()) {
			echo 'DB Error: ' . DBClass::error();
			die();
		} else {
			return DBClass::fetch_assoc($res);
		}
	}
}

/**
 * Select all universities/institutions from the database, optionally filtered by search term.
 * Uses prepared statements to prevent SQL injection.
 * 
 * @param string $search Optional search term to filter by name, country, or city (default: empty string)
 * @return array Array of institution records matching the search criteria.
 *               Results are ordered by name in ascending order.
 *               Returns empty array on error or if search term is empty and no institutions exist.
 */
function selectAllUniversity($search=""){
	$search = trim($search);
	
	if($search){
		$searchPattern = '%' . $search . '%';
		$stmt = DBClass::prepare("SELECT * FROM institutions WHERE name LIKE ? OR country LIKE ? OR city LIKE ? ORDER BY name ASC");
		$stmt->bind_param('sss', $searchPattern, $searchPattern, $searchPattern);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($stmt->error) {
			echo 'DB Error: ' . $stmt->error;
			die();
		} else {
			return $result ? DBClass::fetch_assoc($result) : [];
		}
	} else {
		$res = DBClass::query("SELECT * FROM institutions ORDER BY name ASC");
		if (DBClass::error()) {
			echo 'DB Error: ' . DBClass::error();
			die();
		} else {
			return DBClass::fetch_assoc($res);
		}
	}
}

/**
 * Select paginated universities/institutions from the database.
 * Results are ordered by name in ascending order.
 * 
 * @param int $page Current page number (default: 1)
 * @param int $perPage Number of institutions per page (default: 10)
 * @return array Associative array with keys:
 *               - 'data': Array of institution records for the current page
 *               - 'total': Total number of institutions
 *               - 'currentPage': Current page number
 *               - 'perPage': Number of items per page
 *               - 'totalPages': Total number of pages
 *               Returns array with empty data on error.
 */
function selectPaginatedUniversity($page = 1, $perPage = 10){
	$page = (int)$page;
	$perPage = (int)$perPage;
	$offset = ($page - 1) * $perPage;
	
	$totalQuery = "SELECT COUNT(*) as total FROM institutions";
	$totalRes = DBClass::query($totalQuery);
	if (DBClass::error()) {
		echo 'DB Error: ' . DBClass::error();
		die();
	}
	$totalRow = DBClass::fetch_single($totalRes);
	$total = $totalRow['total'];
	
	$stmt = DBClass::prepare("SELECT * FROM institutions ORDER BY name ASC LIMIT ? OFFSET ?");
	$stmt->bind_param('ii', $perPage, $offset);
	$stmt->execute();
	$dataRes = $stmt->get_result();
	
	if ($stmt->error) {
		echo 'DB Error: ' . $stmt->error;
		die();
	}
	$data = $dataRes ? DBClass::fetch_assoc($dataRes) : [];
	return [
		'data' => $data,
		'total' => $total,
		'currentPage' => $page,
		'perPage' => $perPage,
		'totalPages' => ceil($total / $perPage),
	];
}

/**
 * Select all categories from the database.
 * 
 * @return array Array of category records with id, name, and image fields.
 *               Returns empty array on error.
 */
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

/**
 * Insert a new course into the database.
 * Performs two operations: first inserts the course, then updates it with category, lecturer, and university IDs.
 * 
 * @param string $name Course name/title
 * @param int|string $categoryId Category ID
 * @param int|string $lecturerId Lecturer ID
 * @param int|string $universityId University/Institution ID
 * @param string $year Course year
 * @param string $language Course language
 * @param int|string $totalLectures Number of lectures in the course
 * @param int|string $totalDuration Total duration in hours
 * @param string $description Course description
 * @param string $vidLink Primary video link (YouTube playlist)
 * @param string $link2 Secondary link (university page)
 * @param string $imgLink Course thumbnail image URL
 * @param string $code University course code
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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

/**
 * Update an existing course in the database.
 * Performs two operations: first updates course details, then updates category, lecturer, and university associations.
 * 
 * @param int|string $id Course ID to update
 * @param int|string $universityLecturerId Unused parameter (kept for backwards compatibility)
 * @param string $name New course name/title
 * @param int|string $categoryId New category ID
 * @param int|string $lecturerId New lecturer ID
 * @param int|string $universityId New university/Institution ID
 * @param string $year New course year
 * @param string $language New course language
 * @param int|string $totalLectures New number of lectures
 * @param int|string $totalDuration New total duration in hours
 * @param string $description New course description
 * @param string $vidLink New primary video link
 * @param string $link2 New secondary link
 * @param string $imgLink New course thumbnail image URL
 * @param string $code New university course code
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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

/**
 * Delete a course from the database.
 * 
 * @param int|string $id Course ID to delete
 * @return bool True on success, false on error (also outputs error message and dies)
 */
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