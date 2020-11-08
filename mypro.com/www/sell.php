<?php
	require "config.php";	
	mysql_set_charset('utf8');
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="scripts/car.js" defer></script>
	<link rel="stylesheet" type="text/css" href="css/header-style.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/sell.css">
	<link rel="icon" href="images/icon.png">
	
	<title><?php echo $config['title']?></title>
	
</head>
<body>

	<?php
	mysql_set_charset('utf8');
		include "header.php";
		$color = mysqli_query($connection, "SELECT * FROM `color`");
	?>

	<div class="container">
		<div id="success">
		<?php
			
	    	if (isset($_GET['submit'])) {
	   			$text = $_GET['finish'];
	    		$res  = mysqli_query($connection, "INSERT INTO `announcement`" . $text);
	    		if ($res) {
	    			echo '<a class="success">Your ad was successfully posted
					</a>';
	    		} else {
	    			echo "ERROR in a<br>";
	    		}
//==================================================================================================================
	    		$a = mysqli_query($connection, "SELECT COUNT('id') FROM announcement");
    			$a = mysqli_fetch_row($a);
    			$text = $_GET['links'];
    			$b = explode(" ", $_GET['links']);

    			$next_id = mysqli_query($connection, "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'announcement' and table_schema = 'kolesakz'");
    			$next_id = mysqli_fetch_row($next_id);
    			if (sizeof($b) != 0) {
    				for ($i = 0; $i < sizeof($b); $i++) {
    					$photo = mysqli_query($connection, "INSERT INTO `photo` (`id`, `idd`, `src`) VALUES (NULL, '" . ($next_id[0] - 1) . "', '" . $b[$i] . "')");

    					if ($photo) {
    					} else {
    						echo "PHOTO ERROR";
    					}
    				}
    			}
	    	}
    	?>
    </div>


		<div class="sell_content">
			<a style="padding-top: 20px; color: red; font-size: 25px">Enter vehicle details</a>
			<select class="select" id="year" onchange="selectYear()">
				<option class="option1" value="-1">Choose year...</option>
				<?php
					for ($i = 2020; $i >= 2010; $i--) {
						echo "<option>" . $i . "</option>";
					}
				?>
			</select>
			<select class="select" id="mark" onchange="selectMark()">
				<option class="option2" value="">Choose brand...</option>
			</select>
			<select class="select" id="model" onchange="selectModel()">
				<option class="option1" value="-1">Choose model...</option>
			</select>
			<select class="select" id="modification" style="" onchange="selectModification()">
				<option>Choose modification...</option>
			</select>
			<select class="select" id="complectation" onchange="comp()">
				<option>Choose complectation...</option>
			</select>
			<select class="select" id="color" onchange="">
				<option>Choose color...</option>
			</select>
			<input placeholder="*Probeg..." type="number" name="mileage" value="" id="mileage">
			<input placeholder="*Price(tg)..." type="number" name="price" value="" id="price">
			<form method="get">
				<input width="21%" placeholder="*Link for photo..." type="text" name="links_" value="" id="links_">
			</form>
			<div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
				<a style="padding-top: 20px; color: red; font-size: 25px">Enter your contacts</a>
				<div style="">
					<form id="asdf" method="get">
						<input placeholder="*Phone..." type="text" name="phone" value="" id="phone">
						<input style="margin-left: 10px;" placeholder="*e-mail..." type="e-mail" name="mail" value="" id="mail">
					</form>
				</div>
				  <textarea class="textarea" value="43" style="font-size: 18px; height: 150px;" placeholder="Machine Description..." rows="10" cols="50" id="about_car" name="about"></textarea>
			</div>
			<form method="get">
				<button type="hidden" name="submit" id="btn" onclick="submitall()">Submit your ad</button>
				<input type="hidden" name="finish" id="finish">
				<input type="hidden" name="links" id="links">
			</form>
		</div>
	</div>


	<form method="get">
		<input type="hidden" name="year" id="year_t" value="">
		<input type="hidden" name="mark" id="mark_t" value="">
		<input type="hidden" name="model" id="model_t" value="">
		<input type="hidden" name="modification" id="modification_t" value="">
		<input type="hidden" name="complectation" id="complectation_t" value="">
		<input type="hidden" name="color" id="color_t" value="">
	</form>
	<?php
      include "footer.php";
    ?>

    <style type="text/css">
    	#asdf {
    		display: flex;
    		justify-content: center;
    	}
    	#btn {
    		font-size: 18px;
    		padding: 10px 20px;
    		margin-bottom: 20px;

    		background-color: black;
    		color: white;

    		cursor: pointer;

    		opacity: 1;

    		transition: .1s linear;
    	
    	}

    	#btn:hover {
    		opacity: .7;
    	}

    	#links_ {
    		margin-top: 10px;
    		font-size: 18px;
    		padding: 10px 20px;
    	}
    	#finish {

    	}
    	#success {
    		margin-top: 20px;
    		display: flex;
    		justify-content: center;
    	}

    	.success {
    		margin: 0 auto;

    		color: green;
    		font-size: 18px;
    	}
    	.select {
    		font-size: 18px;

    		margin: 20px 0;
    		padding: 10px 20px;
    	}

    	#mileage, #price {
    		margin: 20px 0;

    		font-size: 18px;

    		padding: 10px 20px;
    	}

    	#name, #phone, #mail {
    		margin: 20px 0;
    		width: 25%;

    		font-size: 18px;

    		padding: 10px 20px;
    	}

    	@media (max-width: 700px) {
		.textarea {
			width: 70%;
		}

	}

	@media (max-width: 900px) {
		.body_and_search {
			display: inherit;
			justify-content: space-between;
		}
		.mini_search {
			margin-top: 50px;
			display: inherit;

			background-color: lightgray;
			padding: 10px;
		}
		.search {
			display: none;
		}
		.select {
			width: 90%;
		}
	}
    </style>
    <script type="text/javascript">
    	function submitall() {
			let select = document.querySelector("#color");
			document.querySelector("#color_t").value = color;
			color = select[select.selectedIndex].text;

			let mark_car = document.querySelector("#mark").value;
			let title = mark_car + " " + model + " " + complectation;
			let mail = document.querySelector("#mail").value;
			let phone = document.querySelector("#phone").value;
			let mileage = document.querySelector("#mileage").value;
			let price = document.querySelector("#price").value;
			let about = document.querySelector("#about_car").value;

			if (title != "") {
				let text = "(`id`, `title`, `model`, `year`, `brand`, `modification`, `complectation`, `mileage`, `phone`, `e-mail`, `price`, `date`, `color`, `about_car`, `islike`) VALUES(NULL, '" + title + "', '" + model + "', '" + year + "', '" + mark_car + "', '" + modification + "', '" + complectation + "', '" + mileage + "', '" + phone + "', '" + mail + "', " + price + ", current_timestamp(), '" + select[select.selectedIndex].text + "', '" + about + "', 'no')";
				document.querySelector("#finish").value = text;
				document.querySelector("#links").value = document.querySelector("#links_").value;
			}
		}

		setInterval(submitall, 300);
    </script>
</body>
</html>