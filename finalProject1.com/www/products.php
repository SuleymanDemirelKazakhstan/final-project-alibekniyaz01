<?php
	$mysqli = new mysqli("localhost", 'root', '', 'adidas');
	mysql_set_charset('utf8');
	$myArray = array();
	if ($a = $mysqli->query("SELECT * FROM products")) {
	    while($row = $a->fetch_array(MYSQLI_ASSOC)) {
	        $myArray[] = $row;
	    }
	    $arr = json_encode($myArray);
	    echo $arr;
	}


?>