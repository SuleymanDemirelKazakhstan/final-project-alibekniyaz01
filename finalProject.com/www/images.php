<?php
	require "connect.php";

	$result = mysqli_query($connection,"SELECT * FROM 	images");

	$array = array();

	while($res = mysqli_fetch_assoc($result)){
		$array[] = $res;
	}

	$jsonText = json_encode($array);
	echo $jsonText;
?>