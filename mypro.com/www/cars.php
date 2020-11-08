<?php
	$mysqli = new mysqli('localhost', 'root', '', 'kolesakz');
	$myArray = array();
	if ($a = $mysqli->query("SELECT * FROM announcement")) {
	    while($row = $a->fetch_array(MYSQLI_ASSOC)) {
	        $myArray[] = $row;
	    }
	    $arr = json_encode($myArray);
	    echo $arr;
	}

	if ($b = $mysqli->query("SELECT * FROM photo")) {
		while($photoRow = $b->fetch_array(MYSQLI_ASSOC)) {
		$myPhotoArray[] = $photoRow;
		}
		$photoArr = json_encode($myPhotoArray);
	}
	mysql_set_charset('utf8');

	$a->close();
	$b->close();
	$mysqli->close();
?>