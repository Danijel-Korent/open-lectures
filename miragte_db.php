<?php

// require_once './database/config.php';
// require_once './database/repo.php';

// //Move lectures to course
// //  $res = db()->query("SELECT * FROM pripadnost_kategoriji");
// //    if (db()->error) {
// // 		echo 'DB Error: ' . db()->error;
// // 		die();
// // 	} else {
// // 		//return the result
// // 		$arr =[];
// // 		while($row = $res->fetch_assoc()){
// // 			$row;
// // 			// var_dump($row['predavanja']); //course
// // 			// var_dump($row['predavac']); //lecturer
// // 		$query =db()->prepare("UPDATE `predavanja` SET `categoryId` = ? WHERE `predavanja`.`id` = ?;");
// // 				$query->bind_param('ss', $row['kategorije'], $row['predavanje']);
// // 	$query->execute();
// // 		}
// // 		echo 'Success';
// // 	}

// $arrayOpisPred = selectOpisPred();
// $all_total_length = 0;
// $all_courses = 0;
// //Get University list
// $university_list = selectUstanove();
// $list =[];
// //Loop through the array and calculate the total length of all courses
// foreach ($arrayOpisPred as $course)
// { 
//   $query =db()->prepare("UPDATE `predavanja` SET `universityId` = ? WHERE `predavanja`.`id` = ?;");
// 				$query->bind_param('ss', $course['ustanova'], $course['id']);
// 	$query->execute();
// 	// array_push($list, $data);
// }

// echo 'Success';

?>