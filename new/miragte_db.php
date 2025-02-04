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
// // 		$query =db()->prepare("UPDATE `predavanja` SET `kategorijeId` = ? WHERE `predavanja`.`idPredavanja` = ?;");
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
//   $query =db()->prepare("UPDATE `predavanja` SET `ustanoveId` = ? WHERE `predavanja`.`idPredavanja` = ?;");
// 				$query->bind_param('ss', $course['ustanova'], $course['idPredavanja']);
// 	$query->execute();
// 	// array_push($list, $data);
// }

// echo 'Success';

?>