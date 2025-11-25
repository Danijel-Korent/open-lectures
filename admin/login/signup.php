<?php
require_once dirname(__DIR__,2).'/constants.php';
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
	// SECURITY ISSUE: SQL INJECTION VULNERABILITY
	// Direct string concatenation allows SQL injection attacks
	// FIX: Use prepared statements instead
	$res = db()->query("SELECT * FROM admin WHERE email = '$email'");
	if($res->num_rows > 0){
		echo 'User already exists';
		die();
	}
	//Query
	$query = db()->prepare('INSERT INTO admin (name, email, password) VALUES (?, ?, ?)');
	$query->bind_param('sss', $name, $email, $password);
	$query->execute();
	
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