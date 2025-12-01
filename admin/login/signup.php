<?php
require_once dirname(__DIR__,2).'/config.php';
require_once REPO_PATH;
$title = 'Signup';
//Logic
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	// SECURITY ISSUE: MISSING INPUT VALIDATION
	// No validation or sanitization of user input
	// FIX: Add proper input validation, length limits, and sanitization
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	//Database Connection
	// Use prepared statements to prevent SQL injection
	$check_stmt = DBClass::prepare('SELECT * FROM admin WHERE email = ?');
	$check_stmt->bind_param('s', $email);
	$check_stmt->execute();
	$check_result = $check_stmt->get_result();
	$existing_user = $check_result ? DBClass::fetch_single($check_result) : null;
	
	if($existing_user){
		echo 'User already exists';
		die();
	}
	//Query - Use DBClass::prepare for consistency and proper error handling
	$insert_stmt = DBClass::prepare('INSERT INTO admin (name, email, password) VALUES (?, ?, ?)');
	$insert_stmt->bind_param('sss', $name, $email, $password);
	$insert_stmt->execute();
	
	if ($insert_stmt->error) {
		echo 'DB Error: ' . $insert_stmt->error;
		die();
	}
	
	header('Location: '.baseUrl('/admin/login'),true);
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Signup</title>
</head>
<body>
	<form action="" method="post">
		<input type="text" name="name" placeholder="Name"/>
		<input type="email" name="email" placeholder="Email"/>
		<input type="password" name="password" placeholder="Password"/>
		<input type="submit" value="Register"/>
	</form>
</body>
</html>