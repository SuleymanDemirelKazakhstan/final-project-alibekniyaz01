<?php
	$mysqli = new mysqli('localhost', 'root', '', 'kolesakz');
	$myArray = array();
	if ($b = $mysqli->query("SELECT * FROM photo")) {
		while($photoRow = $b->fetch_array(MYSQLI_ASSOC)) {
		$myPhotoArray[] = $photoRow;
		}
		$photoArr = json_encode($myPhotoArray);
		echo $photoArr;
	}
	mysql_set_charset('utf8');

	$b->close();
	$mysqli->close();
?>