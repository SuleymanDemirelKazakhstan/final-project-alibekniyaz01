<?php
	$mysqli = new mysqli("localhost", 'root', '', 'kolesakz');
	mysql_set_charset('utf8');
	$myArray = array();
	if ($a = $mysqli->query("SELECT * FROM announcement")) {
	    while($row = $a->fetch_array(MYSQLI_ASSOC)) {
	        $myArray[] = $row;
	    }
	    $arr = json_encode($myArray);
	    echo $arr;
	}

	$a->close();
	$mysqli->close();
?>