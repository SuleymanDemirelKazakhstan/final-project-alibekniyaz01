<?php
	require "config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="icon" href="images/icon.png">
	<link rel="stylesheet" type="text/css" href="css/header-style.css">
</head>
<body>
	<?php require "header.php" ?>

	<?php
		$isDeleted = false;
		if (isset($_GET['delete'])) {
			$id = $_GET['del'];
			$top = mysqli_query($connection, "DELETE FROM announcement WHERE id=".$id);
			$isDeleted = true;
			$img = mysqli_query($connection, "DELETE FROM photo WHERE idd=".$id);
		?>
		<div class="container" style="margin-top: 50px">
			<div class="go_back_div" style="width: 100%; height: 300px; display: flex; justify-content: center; align-items: center;">
				<a class="go_back" style="text-decoration: none;
			color: black;

			font-size: 25px;

			border-bottom: 2px solid white;" href="all.php">Back</a>
			</div>
		</div>
			
			<?php
			die();
		}		
	?>
	<?php
		$isSave = false;
		if (isset($_GET['save'])) {
			$title = $_GET['mark']." ".$_GET['model']." ".$_GET['complectation'];
			$r = mysqli_query($connection, "UPDATE announcement SET year=".$_GET['year'].", brand='".$_GET['mark']."', model='".$_GET['model']."', modification='".$_GET['modification']."', complectation='".$_GET['complectation']."', mileage=".$_GET['mileage'].", price=".$_GET['price'].", title='".$title."', color='".$_GET['color']."', phone='".$_GET['phone']."', `e-mail`='".$_GET['mail']."' WHERE id=".$_GET['id']);
			if ($r) {
				echo '<div class="container update"><a class="updated">Your ad has been successfully updated!</a></div>';
			} else echo "ERROR";

			if ($_GET['src'] != '') {
				$links = $_GET['src'];
				$links = explode(" ", $links);
				$id = $_GET['id'];
				for ($i = 0; $i < sizeof($links); $i++) {
					$r = mysqli_query($connection, "INSERT INTO photo(id, idd, src) VALUES (NULL, ".$id.", '".$links[$i]."')");
				}
			}

			if($_GET['delete_src'] != "") {
				$links = $_GET['delete_src'];
				$links = explode(" ", $links);
				for ($i = 0; $i < sizeof($links); $i++) {
					if ($links[$i] != "") {
						$r = mysqli_query($connection, "DELETE FROM photo WHERE src='".$links[$i]."'");
					}
				}
			}
		}
		if(isset($_GET['id'])) {
			$topic = $_GET['id'];
		}
		$result = mysqli_query($connection, "SELECT * FROM announcement WHERE id=".$topic);
		$result = mysqli_fetch_assoc($result);

		$image_link = mysqli_query($connection, "SELECT * FROM photo");

		$count_all_images = mysqli_query($connection, "SELECT COUNT(id) FROM photo");
		$count_all_images = mysqli_fetch_row($count_all_images);

		$count = mysqli_query($connection, "SELECT COUNT(id) FROM photo WHERE idd=".$topic);
		$count = mysqli_fetch_row($count);		
	?>

	<div class="container" style="margin-top: 50px">
		<?php
			if (!$isDeleted) {
		?>
			<form method="get">
				<input type="submit" id="del" name="delete" value="Remove ad">
				<input type="hidden" name="del" id="" value="<?php echo $topic;?>">
			</form>
		<?php }?>
		<?php
		if (!$isDeleted) {
			?>
		<div class="change">
			<a id="title" class="title">Name: <?php echo $result['title']?></a><br>
			<a id="mark_s" class="title">Brand: <?php echo $result['brand']?></a><a onclick="openMark()" class="c"> Edit</a><br>
			<select class="all_form display_none " id="mark" onchange="markSelected()">
				<option>Choose brand...</option>
			</select><br>
			<a id="model_s" class="title">Model: <?php echo $result['model']?></a><a onclick="openModel()" class="c"> Edit</a><br>
			<select class="all_form display_none " id="model" onchange="modelSelected()">
				<option>Choose model...</option>
			</select><br>
			<a id="modification_s" class="title">Modification: <?php echo $result['modification']?></a><a onclick="openModification()" class="c"> Edit</a><br>
			<select class="all_form display_none" id="modification" onchange="modificationSelected()">
				<option>Choose modification...</option>
			</select><br>
			<a id="complectation_s" class="title">Complectation: <?php echo $result['complectation']?></a><a onclick="openComplectation()" class="c"> Edit</a><br>
			<select class="all_form display_none" id="complectation" onchange="complectationSelected()">
				<option>Choose complectation...</option>
			</select><br>
			<a id="year_s" class="title">Year: <?php echo $result['year']?></a><a onclick="openYear()" class="c"> Edit</a><br>
			<select class="all_form display_none" id="year" onchange="yearSelected()">
				<option class="" value="-1">Choose year...</option>
					<?php
						for ($i = 2020; $i >= 2010; $i--) {
							echo "<option>" . $i . "</option>";
						}
					?>
			</select><br>
			<a id="price_s" class="title">Price: <?php echo $result['price']?></a><a onclick="openPrice()" class="c"> Edit</a><br>
			<div id="pric" class="hidden"><input class="" id="price" type="number" name=""><a onclick="priceSelected()" style="background-color: black; color: white; cursor: pointer; padding: 1px 5px;">Ok</a><br></div>
			<a id="color_" class="title">Color: <?php echo $result['color']?></a><a onclick="openColor()" class="c"> Edit</a><br>
			<select class="all_form display_none" id="color" onchange="colorSelected()">
				<option>Choose color...</option>
			</select><br>
			<a id="mileage_s" class="title">Mileage: <?php echo $result['mileage']?> km</a><a onclick="openMileage()" class="c"> Edit</a><br>
			<div id="mileag" class="hidden"><input class="" id="mileage" type="number" name=""><a onclick="mileageSelected()" style="background-color: black; color: white; cursor: pointer; padding: 1px 5px;">Ok</a><br></div>
			<a id="phone_s" class="title">Phone: <?php echo $result['phone']?></a><a onclick="openPhone()" class="c"> Edit</a><br>
			<div id="phon" class="hidden"><input class="" id="phone" type="number" name=""><a onclick="phoneSelected()" style="background-color: black; color: white; cursor: pointer; padding: 1px 5px;">Ok</a><br></div>
			<a id="mail_s" class="title">E-mail: <?php echo $result['e-mail']?></a><a onclick="openMail()" class="c"> Edit</a><br>
			<div id="mai" class="hidden"><input class="" id="mail" type="mail" name=""><a onclick="mailSelected()" style="background-color: black; color: white; cursor: pointer; padding: 1px 5px;">Ok</a><br></div>

			<a class="title">Number of photos: <?php echo $count[0]?></a>
			<a onclick="openPhoto()" style="background-color: black; color: white; cursor: pointer; padding: 1px 5px;">Add new links</a>
			<div class="">
				<div id="srcc" class="display_none">
					<input id="src" type="" name="">
					<a onclick="photoSelected()" style="background-color: black; color: white; cursor: pointer; padding: 1px 5px;">Ok</a>
				</div>
				<div class="img_div">
					<?php
						for ($j = 0; $j < $count_all_images[0]; $j++) {
							$row_photo = mysqli_fetch_assoc($image_link);
							if ($row_photo['idd'] == $result['id']) {
					?>
								<div class="edit_img_div">
									<a class="delete_img_btn" style="">X</a>
									<div style="">
										<img class="edit_img" src="<?php echo $row_photo['src'];?>">
									</div>
								</div>

					<?php  
							}
						}
					?>
				</div>
			</div>			
		</div>

		<div>
			<form method="get">
				<input type="hidden" name="year" id="year_t" value="<?php echo $result['year']?>">
				<input type="hidden" name="mark" id="mark_t">
				<input type="hidden" name="model" id="model_t">
				<input type="hidden" name="modification" id="modification_t">
				<input type="hidden" name="complectation" id="complectation_t">
				<input type="hidden" name="price" id="price_t">
				<input type="hidden" name="src" id="src_t">
				<input type="hidden" name="color" id="color_t">
				<input type="hidden" name="id" value="<?php echo $topic?>">
				<input type="hidden" name="mileage" id="mileage_t" value="<?php echo $result['mileage']?>">
				<input type="submit" name="save" value="Сохранить" id="save">
				<input type="hidden" name="title" id="title_t">
				<input type="hidden" name="phone" id="phone_t">
				<input type="hidden" name="mail" id="mail_t">
				<input type="hidden" name="delete_src" id="delete_img_t">
			</form>
		</div>
	</div>
	<?php
	} ?>

	<?php require "footer.php";?>
</body>
	<style type="text/css">
		.edit_img_div{
			position: relative;
		}

		.delete_img_btn {
			cursor: pointer;

			position: absolute;
			top: 10px;
			right: 15px;
			z-index: 100;

			opacity: .7;

			background-color: black;
			padding: 0 5px;
			color: white;
		}
		.delete_img_btn:hover {
			opacity: 1;
		}

		.updated {
			font-size: 20px;
			color: green;
			text-align: center;
		}

		.update {
			width: 100%;
			margin-top: 50px;

			display: flex;
			justify-content: center;
		}
		.hidden {
			visibility: hidden;
		}
		.display_none {
			display: none;
		}

		#del {
			border-color: black;
			background-color: black;
			color: brown;
			cursor: pointer;
			font-size: 20px;
			padding: 10px 20px;
			opacity: .7;
		}
		#del:hover {
			opacity: 1;
		}

		#save {
			margin-top: 50px;
			border-color: black;
			padding: 10px 20px;
			background-color: black;
			color: white;
			font-size: 20px;
			cursor: pointer;
			opacity: .7;
		}
		#save:hover {
			opacity: 1;
		}

		.all_form {
			font-size: 18px;
		}

		.title {
			font-size: 20px;
		}

		.c {
			font-size: 10px;
			cursor: pointer;
			text-decoration: reverse;

			margin-left: 25px;
		}
		.c:hover {
			text-decoration: revert;
			color: blue;
		}

		.img_div{
			display: flex;
			flex-wrap: wrap;
		}


		.edit_img{ 
			width: 270px;
			height: 185px;
			margin: 10px 15px 0 0;
		}

		.go_back:hover {
			border-color: black;
		}

		.change {
			margin-top: 50px;
		}
	</style>
	<script type="text/javascript">
		let colors = ["Белый", "Бежевый", "Голубой", "Синий", "Зеленый", "Красный", "Черный", "Оливкого-зеленый", "Серебристо-зеленый", "Темно-красный", "Темно-бородовый", "Темно-зеленый", "Темной-синий"];
		let marks = ["Toyota", "Lexus", "BMW", "Mercedes-Benz", "Volvo", "Audi", "Cadillac", "Chevrolet", "Kia", "Hyundai", "Mazda", "Nissan", "Volkswagen"];
		//=============================================================================
		let toyota = ["Camry", "Corolla", "Highlander", "Land Cruiser Prado", "RAV4"];
		let lexus = ["ES", "GX", "LS", "LX", "NX", "RX"];
		let bmw = ["2", "3", "3 GT", "4", "5", "6 GT", "M4", "M6", "X5", "X6", "X7"];
		let mercedes = ["AMG GT", "A-Klasse", "AMG GT R", "AMG GT S", "B-Klasse", "C-Klasse", "E-Klasse", "G-Klasse", "S-Klasse"];
		let volvo = ["S60", "S90", "V60 Cross Country", "V90 Cross Country", "XC40", "XC60", "XC90"];
		let audi = ["A3", "A5", "A6", "A7", "A8", "Q3", "Q5", "Q7", "Q8", "S5", "S6", "S8", "SQ5", "SQ7", "SQ8"];
		let cadillac = ["CT6", "Escalade", "XT5", "XT6"];
		let chevrolet = ["Cobalt", "Nexia", "Niva", "Spark", "Tahoe", "Traverse"];
		let kia = ["Ceed", "Cerato", "K5", "K900", "Optima", "Rio", "Soul", "Stinger", "Xceed"];
		let hyundai = ["Creta", "Elantra", "Solaris", "Tucson"];
		let mazda = ["6", "CX-5"];
		let nissan = ["Almera", "GT-R", "Murano", "Sentra", "Terrano", "X-Trail"];
		let volkswagen = ["Amarok", "Beetle", "Caddy", "Golf", "Jetta", "Passat", "Tiguan", "Polo"];
		//=================================================================================================
		//Camry================================================================================================================================
		let camry = ["Седан 3456(249) БИ Передний АТ", "Седан 2494(181) БИ Передний АТ", "Седан 1998(148) БИ Передний АТ"];
		let corolla = ["Седан 1798(140) БИ Передний АТ", "Седан 1598(122) БИ Передний МТ", "Седан 1598(122) БИ Передний АТ"];
		let highlander = ["Внедорожник 5 Door 3456(249) БИ Полный АТ"];
		let prado = ["Внедорожник 5 Door 3956(282) БИ Полный АТ", "Внедорожник 5 Door 2755(177) БИ Полный АТ", "Внедорожник 5 Door 2694(163) БИ Полный МТ", "Внедорожник 5 Door 2694(163) БИ Полный АТ"];
		let rav4 = ["Внедорожник 5 Door 2494(180) БИ Полный АТ", "Внедорожник 5 Door 2231(150) ДТ Полный АТ", "Внедорожник 5 Door 1987(146) БИ Полный МТ", "Внедорожник 5 Door 1987(146) БИ Полный АТ", "Внедорожник 5 Door 1987(146) БИ Передний МТ", "Внедорожник 5 Door 1987(146) БИ Передний АТ"];
		let toyotacomplectation = ["Classic", "Comfort", "Comfort Plus", "Elegance", "Elegance Plus", "Prestige", "Prestige Plus", "Style", "Style Plus", "Standart"];
		//Lexus================================================================================================================================
		let es = ["Седан 3456(249) БИ Передний АТ", "Седан 2494(184) БИ Передний АТ", "Седан 1998(150) БИ Передний АТ"];
		let gx = ["Внедорожник 5 Door 4608(296) БИ Полный АТ"];
		let ls = ["Седан 4608(388) БИ Задний АТ", "Седан 4608(370) БИ Полный АТ", "Седан Long 4969(394) БГ Полный АТ", "Седан Long 4608(370) БИ Полный АТ"];
		let lx = ["Внедорожник 5 Door 5663(367) БИ Полный АТ", "Внедорожник 5 Door 4500(272) ДТ Полный АТ"];
		let nx = ["Внедорожник 5 door 2494(155) БГ Полный АТ", "Внедорожник 5 door 1986(238) БТ Полный АТ", "Внедорожник 5 door 1986(151) БИ Полный АТ", "Внедорожник 5 door 1986(151) БИ Передний АТ",];
		let rx = ["Внедорожник 5 Door 3456(300) БИ Полный АТ", "Внедорожник 5 Door 3456(263) БГ Полный АТ", "Внедорожник 5 Door 1998(238) БТ Полный АТ", "Внедорожник 5 Door 1998(238) БТ Передний АТ",];
		let lexuscomplectation = ["ES 250 Comfort", "ES 250 Executive", "ES 250 Luxury", "ES 250 Premium", "ES 250 Premium 2"];
		//BMW================================================================================================================================
		let two = ["Купе 2998(340) БТ Полный АТ", "Купе 1997(184) БТ Задний МТ", "Купе 1997(184) БТ Задний АТ", "Купе 1995(184) ДТ Задний АТ", "Купе 1995(184) ДТ Задний МТ"];
		let three = ["Седан 2998(326) БТ Полный АТ", "Седан 1998(249) БТ Полный АТ", "Седан 1998(184) БТ Полный АТ", "Седан 1998(184) БТ Задний АТ", "Седан 1995(190) ДТ Полный АТ", "Седан 1995(190) ДТ Задний АТ", "Седан 1499(136) БТ Задний МТ", "Седан 1499(136) БТ Задний АТ", "Седан (new) 1998(258) БТ Задний АТ"];
		let threegt = ["Хэтчбек 5 Door 2998(326) БТ Полный АТ", "Хэтчбек 5 Door 1998(249) БТ Полный АТ", "Хэтчбек 5 Door 1997(184) БТ Полный АТ", "Хэтчбек 5 Door 1997(184) БТ Задний АТ", "Хэтчбек 5 Door 1995(190) ДТ Полный АТ"];
		let four = ["Купе 1998(249) БТ Задний АТ", "Купе 1998(249) БТ Полный АТ", "Купе 1998(249) БТ Задний АТ", "Купе 1998(249) БТ Задний АТ", "Купе 1997(184) БТ Задний АТ", "Купе 1995(190) ДТ Полный АТ", "Купе 1995(190) ДТ Задний АТ", "Кабриолет 2998(326) БТ Задний АТ", "Кабриолет 1998(249) БТ Полный АТ", "Кабриолет 1998(249) БТ Задний АТ", "Кабриолет 1995(190) ДТ Задний АТ"];
		let five = ["Седан 4395(462) БТ Полный АТ", "Седан 2998(340) БТ Полный АТ", "Седан 2993(400) ДТ Полный АТ", "Седан 2993(249) ДТ Полный АТ", "Седан 1998(249) БТ Полный АТ", "Седан 1998(184) БТ Задний АТ", "Седан 1995(190) ДТ Полный АТ", "Седан 1995(190) ДТ Задний АТ"];
		let sixgt = ["Хэтчбек 5 Door 2998(340) БТ Полный АТ", "Хэтчбек 5 Door 2993(320) ДТ Полный АТ", "Хэтчбек 5 Door 2993(249) ДТ Полный АТ", "Хэтчбек 5 Door 1998(249) БТ Задний АТ", "Хэтчбек 5 Door 1995(190) ДТ Полный АТ"];
		let m4 = ["Купе 2979(431) БТ Задний МТ", "Купе 2979(431) БТ Задний АТ", "Купе (new) 2979(450) БТ Задний МТ", "Купе (new) 2979(450) БТ Задний АТ"];
		let m6 = ["Купе 4395(560) БТ Задний АТ", "Кабриолет 4395(560) БТ Задний АТ"];
		let x5 = ["Внедорожник 5 Door 4395(575) БТ Полный АТ", "Внедорожник 5 Door 4395(450) БТ Полный АТ", "Внедорожник 5 Door 2993(381) ДТ Полный АТ", "Внедорожник 5 Door 2993(313) ДТ Полный АТ", "Внедорожник 5 Door 2993(249) ДТ Полный АТ", "Внедорожник 5 Door 2993(218) ДТ Полный АТ", "Внедорожник 5 Door 2979(306) БТ Полный АТ", "Внедорожник 5 Door 1997(245) БГ Полный АТ", "Внедорожник 5 Door (new) 4395(462) БТ Полный АТ", "Внедорожник 5 Door (new) 2998(340) БТ Полный АТ", "Внедорожник 5 Door (new) 2993(400) ДТ Полный АТ", "Внедорожник 5 Door (new) 2993(249) ДТ Полный АТ"];
		let x6 = ["Внедорожник 5 Door 4395(575) БТ Полный АТ", "Внедорожник 5 Door 4395(450) БТ Полный АТ", "Внедорожник 5 Door 2993(381) ДТ Полный АТ", "Внедорожник 5 Door 2993(313) ДТ Полный АТ", "Внедорожник 5 Door 2993(249) ДТ Полный АТ", "Внедорожник 5 Door 2979(306) БТ Полный АТ"];
		let x7 = ["Внедорожник 5 Door 2993(400) ДТ Полный АТ", "Внедорожник 5 Door 2998(340) БТ Полный АТ", "Внедорожник 5 Door 2993(249) ДТ Полный АТ"];
		let bmwcomplectation = ["22d Base", "220d Luxury Line", "220d Sport Line"];
		//Merseces-Benz========================================================================================================================
		let amggt = ["Купе 3982(585) БТ Задний АТ", "Купе 3982(522) БТ Задний АТ", "Купе 3982(476) БТ Задний АТ"];
		let a_klasse = ["Хэтчбек 5 Door 1332(163) БТ Передний АТ"];
		let amggtr = ["Купе 3982(585) БТ Задний АТ"];
		let amggts = ["Купе 3982(522) БТ Задний АТ"];
		let b_klasse = ["Хэтчбек 5 Door 1332(150) БТ Передний АТ"];
		let c_klasse = ["Седан 3982(510) БТ Задний АТ", "Седан 2996(390) БТ Полный АТ", "Седан 1991(204) БТ Полный АТ", "Седан 1595(150) БТ Задний АТ", "Купе 3982(510) БТ Задний АТ", "Купе 2996(390) БТ Полный АТ", "Купе 1991(204) БТ Полный АТ", "Купе 1595(150) БТ Задний АТ"];
		let e_klasse = ["Универсал 1950(194) ДТ Полный АТ", "Универсал (new) 1950(194) ДТ Полный АТ", "Седан 3982(612) БТ Полный АТ", "Седан 2999(435) БТ Полный АТ", "Седан 2996(367) БТ Полный АТ", "Седан 2925(340) ДТ Полный АТ", "Седан 1991(197) БТ Полный АТ", "Седан 1991(197) БТ Задний АТ", "Седан 1950(194) ДТ Полный АТ", "Седан 1950(150) ДТ Задний АТ", "Седан (new) 3982(612) БТ Полный АТ", "Седан (new) 2999(435) БТ Полный АТ", "Седан (new) 2996(367) БТ Полный АТ", "Седан (new) 1991(320) БГ Задний АТ", "Седан (new) 1991(197) БТ Полный АТ", "Седан (new) 1991(197) БТ Задний АТ", "Седан (new) 1952(150) ДТ Задний АТ", "Седан (new) 1950(194) ДТ Полный АТ", "Купе 2996(435) БТ Полный АТ", "Купе 2996(367) БТ Полный АТ", "Купе 1991(249) БТ Задний АТ", "Купе 1991(197) БТ Полный АТ", "Купе 1991(197) БТ Задний АТ", "Кабриолет 2996(435) БТ Полный АТ", "Кабриолет 1991(249) БТ Задний АТ"];
		let g_klasse = ["Внедорожник 5 Door 3982(585) БТ Полный АТ", "Внедорожник 5 Door 3982(422) БТ Полный АТ", "Внедорожник 5 Door 2925(330) ДТ Полный АТ", "Внедорожник 5 Door 2925(249) ДТ Полный АТ"];
		let s_klasse = ["Седан Long 5980(530) БТ Задний АТ", "Седан Long 3982(612) БТ Полный АТ", "Седан Long 3982(469) БТ Полный АТ", "Седан Long 2996(367) БТ Полный АТ", "Седан Long 2925(340) ДТ Полный АТ", "Седан Long 2925(249) ДТ Полный АТ", "Купе 3982(612) БТ Полный АТ", "Купе 3982(469) БТ Полный АТ", "Купе 2996(367) БТ Полный АТ", "Кабриолет 3982(612) БТ Полный АТ", "Кабриолет 3982(469) БТ Полный АТ"];
		let mercedescomplectation = ["A 220 Progressive", "A 220 Sport", "A 35 AMG", "A 200 Comfort", "A 200 Style", "R", "G 63 AMG", "G 500", "S 65 AMG Long", "S 65 AMG", "C 200 Premium", "C 200 Sport"];
		//Volvo==================================================================================================================================
		let s60 = ["Седан 1969(249) БТ Полный АТ", "Седан 1969(190) БТ Передний АТ"];
		let s90 = ["Седан 1969(320) БТ Полный АТ", "Седан 1969(249) БТ Передний АТ", "Седан 1969(235) ДТ Полный АТ", "Седан 1969(190) БТ Передний АТ", "Седан (new) 1969(249) БТ Передний АТ", "Седан (new) 1969(235) ДТ Полный АТ", "Седан (new) 1969(190) БТ Передний АТ"];
		let v60cross = ["Универсал 1969(250) БТ Полный АТ"];
		let v90 = ["Универсал 1969(320) БТ Полный АТ", "Универсал 1969(249) БТ Полный АТ", "Универсал 1969(235) ДТ Полный АТ", "Универсал 1969(190) ДТ Полный АТ", "Универсал (new) 1969(249) БТ Полный АТ", "Универсал (new) 1969(235) ДТ Полный АТ", "Универсал (new) 1969(190) ДТ Полный АТ"];
		let xc40 = ["Внедорожник 5 Door 1969(249) БТ Полный АТ", "Внедорожник 5 Door 1969(190) ДТ Полный АТ", "Внедорожник 5 Door 1969(190) БТ Полный АТ", "Внедорожник 5 Door 1969(150) ДТ Полный АТ", "Внедорожник 5 Door 1969(150) ДТ Передний АТ"];
		let xc60 = ["Внедорожник 5 Door 1969(407) БГ Полный АТ", "Внедорожник 5 Door 1969(320) БТ Полный АТ", "Внедорожник 5 Door 1969(249) БТ Полный АТ", "Внедорожник 5 Door 1969(235) ДТ Полный АТ", "Внедорожник 5 Door 1969(190) ДТ Полный АТ"];
		let xc90 = ["Внедорожник 5 Door 1969(407) БГ Полный АТ", "Внедорожник 5 Door 1969(320) БТ Полный АТ", "Внедорожник 5 Door 1969(320) БТ Полный АТ", "Внедорожник 5 Door 1969(249) БТ Полный АТ", "Внедорожник 5 Door 1969(235) ДТ Полный АТ"];
		let volvocomplectation = ["Inscription", "Momentum", "R-Design"];
		//Audi====================================================================================================================================
		let a3 = ["Хэтчбек 5 Door 1984(190) БТ Полный АТ", "Хэтчбек 5 Door 1984(190) БТ Передний АТ", "Хэтчбек 5 Door 1395(150) БТ Передний АТ", "Седан 1984(190) БТ Полный АТ", "Седан 1984(190) БТ Передний АТ", "Седан 1395(150) БТ Передний АТ"];
		let a5 = ["Хэтчбек 5 Door 1984(249) БТ Полный АТ", "Хэтчбек 5 Door 1984(190) БТ Передний АТ", "Хэтчбек 5 Door 1968(190) ДТ Полный АТ", "Купе 1984(249) БТ Полный АТ", "Купе 1968(190) ДТ Полный АТ"];
		let a6 = ["Универсал 2967(249) ДТ Полный АТ", "Универсал 1984(190) ДТ Передний АТ", "Универсал 1984(190) БТ Передний АТ", "Седан 2995(340) БТ Полный АТ", "Седан 2967(249) ДТ Полный АТ", "Седан 1984(245) БТ Полный АТ", "Седан 1984(190) БТ Передний АТ", "Седан 1968(190) ДТ Передний АТ"];
		let a7 = ["Хэтчбек 5 Door 2995(340) БТ Полный АТ", "Хэтчбек 5 Door 2967(249) ДТ Полный АТ", "Хэтчбек 5 Door 1984(245) БТ Полный АТ"];
		let a8 = ["Седан 3996(460) БТ Полный АТ", "Седан 2995(340) БТ Полный АТ", "Седан 2967(249) ДТ Полный АТ", "Седан Long 3996(460) БТ Полный АТ", "Седан Long 2995(340) БТ Полный АТ", "Седан Long 2967(249) ДТ Полный АТ"];
		let q3 = ["Внедорожник 5 Door 1984(180) БТ Полный АТ", "Внедорожник 5 Door 1395(150) БТ Передний АТ"];
		let q5 = ["Внедорожник 5 Door 2967(249) ДТ Полный АТ", "Внедорожник 5 Door 1984(249) БТ Полный АТ"];
		let q7 = ["Внедорожник 5 Door 2967(249) ДТ Полный АТ"];
		let q8 = ["Внедорожник 5 Door 2995(340) БТ Полный АТ", "Внедорожник 5 Door 2967(249) ДТ Полный АТ"];
		let s5 = ["Хэтчбек 5 Door 2995(354) БТ Полный АТ", "Купе 2995(354) БТ Полный АТ"];
		let s6 = ["Седан 2894(450) БТ Полный АТ"];
		let s8 = ["Седан 3996(571) БТ Полный АТ"];
		let sq5 = ["Внедорожник 5 Door 2995(354) БТ Полный АТ"];
		let sq7 = ["Внедорожник 5 Door 3956(422) ДТ Полный АТ"];
		let sq8 = ["Внедорожник 5 Door 3956(422) ДТ Полный АТ"];
		let audicomplectation = ["Base", "Sport"];
		//Cadillac=============================================================================================================================================
		let ct6 = ["Седан 3649(335) БИ Полный АТ"];
		let escalade = ["Внедорожник 5 Door 6162(426) БИ Полный АТ"];
		let xt5 = ["Внедорожник 5 Door 1998(200) БТ Полный АТ"];
		let xt6 = ["Внедорожник 5 Door 1998(200) БТ Полный АТ"];
		let cadillaccomplectation = ["Luxury", "Luxury ESV", "Platinum", "Platinum ESV", "Premium", "Premium ESV"];
		//Chevrolet=============================================================================================================================================
		let cobalt = ["Седан 1485(106) БИ Передний МТ", "Седан 1485(106) БИ Передний АТ"];
		let nexia = ["Седан 1485(105) БИ Передний МТ", "Седан 1485(105) БИ Передний АТ"];
		let niva = ["Внедорожник 5 Door 1690(80) БИ Полный МТ"];
		let spark = ["Хэтчбек 5 Door 1249(85) БИ Передний АТ"];
		let tahoe = ["Внедорожник 5 Door 6152(426) БИ Полный АТ"];
		let traverse = ["Внедорожник 5 Door 3564(316) БИ Полный АТ"];
		let chevroletcomplectation = ["3LT", "LT", "Premier"];
		//Kia=============================================================================================================================
		let ceed = ["Хэтчбек 5 Door 1591(128) БИ Передний МТ", "Хэтчбек 5 Door 1591(128) БИ Передний АТ", "Хэтчбек 5 Door 1396(100) БИ Передний МТ", "Хэтчбек 5 Door 1353(140) БТ Передний АТ", "Универсал 1591(128) БИ Передний МТ", "Универсал 1591(128) БИ Передний АТ", "Универсал 1396(100) БИ Передний МТ", "Универсал 1353(140) БТ Передний АТ"];
		let cerato = ["Седан 1999(150) БИ Передний АТ", "Седан 1591(130) БИ Передний МТ", "Седан 1591(130) БИ Передний АТ", "Седан (new) 1999(150) БИ Передний АТ", "Седан (new) 1591(128) БИ Передний МТ", "Седан (new) 1591(128) БИ Передний АТ"];
		let k5 = ["Седан 2497(194) БИ Передний АТ", "Седан 1999(150) БИ Передний АТ"];
		let k900 = ["Седан 5038(413) БИ Полный АТ", "Седан 3342(249) БИ Полный АТ"];
		let optima = ["Седан 2359(188) БИ Передний АТ", "Седан 1998(245) БТ Передний АТ", "Седан 1998(150) БИ Передний МТ", "Седан 1998(150) БИ Передний АТ"];
		let rio = ["Седан 1591(123) БИ Передний МТ", "Седан 1591(123) БИ Передний АТ", "Седан 1368(100) БИ Передний МТ", "Седан 1368(100) БИ Передний АТ"];
		let soul = ["Универсал 1999(150) БИ Передний АТ", "Универсал 1591(200) БТ Передний АТ", "Универсал 1591(123) БИ Передний МТ", "Универсал 1591(123) БИ Передний АТ"];
		let stinger = ["Лифтбек 3342(370) БТ Полный АТ", "Лифтбек 1998(247) БТ Полный АТ", "Лифтбек 1998(197) БТ Полный АТ", "Лифтбек 1998(197) БТ Задний АТ"];
		let xceed = ["Универсал 1591(200) БТ Передний АТ", "Универсал 1353(140) БТ Передний АТ"];
		let kiacomplectation = ["Comfort (S175)", "Luxe (D741)", "Premium (DAPM)", "Prestige (D687)"]
		//Hyundai=============================================================================================================================================
		let creta = ["Внедорожник 5 Door 1999(150) БИ Полный АТ", "Внедорожник 5 Door 1999(150) БИ Передний АТ", "Внедорожник 5 Door 1591(123) БИ Передний МТ", "Внедорожник 5 Door 1591(123) БИ Передний АТ", "Внедорожник 5 Door 1591(121) БИ Полный МТ", "Внедорожник 5 Door 1591(121) БИ Полный АТ"];
		let elantra = ["Седан 1999(150) БИ Передний МТ", "Седан 1999(150) БИ Передний АТ", "Седан 1591(128) БИ Передний МТ", "Седан 1591(128) БИ Передний АТ"];
		let solaris = ["Седан 1591(123) БИ Передний МТ", "Седан 1591(123) БИ Передний АТ", "Седан 1368(100) БИ Передний МТ", "Седан 1368(100) БИ Передний АТ", "Седан (new) 1591(123) БИ Передний МТ", "Седан (new) 1591(123) БИ Передний АТ", "Седан (new) 1368(100) БИ Передний МТ", "Седан (new) 1368(100) БИ Передний АТ"];
		let tucson = ["Внедорожник 5 Door 2359(184) БИ Полный АТ", "Внедорожник 5 Door 1999(150) БИ Полный МТ", "Внедорожник 5 Door 1999(150) БИ Полный АТ", "Внедорожник 5 Door 1999(150) БИ Передний МТ", "Внедорожник 5 Door 1999(150) БИ Передний АТ", "Внедорожник 5 Door 1995(185) ДТ Полный АТ"];
		let hyundaicomplectation = ["Travel (D201)", "Travel + Advanced (D202)", "Travel + Advanced + Style (G018)"];
		//Mazda=============================================================================================================================================
		let mazda6 = ["Седан 2488(231) БТ Передний АТ", "Седан 2488(194) БИ Передний АТ", "Седан 1998(150) БИ Передний АТ"];
		let cx5 = ["Внедорожник 5 Door 2488(194) БИ Полный АТ", "Внедорожник 5 Door 1998(150) БИ Полный АТ", "Внедорожник 5 Door 1998(150) БИ Передний МТ", "Внедорожник 5 Door 1998(150) БИ Передний АТ"];
		let mazdacomplectation = ["Active+", "Drive", "Supreme", "Exclusive"];
		//Nissan=============================================================================================================================================
		let almera = ["Седан 1598(102) БИ Передний МТ", "Седан 1598(102) БИ Передний АТ"];
		let gtr = ["Купе 3799(570) БТ Полный АТ"];
		let murano = ["Внедорожник 5 Door 3498(249) БИ Полный АТ", "Внедорожник 5 Door 3498(249) БИ Передний АТ", "Внедорожник 5 Door 2488(254) БГ Полный АТ"];
		let terrano = ["Внедорожник 5 Door 1998(143) БИ Полный МТ", "Внедорожник 5 Door 1998(143) БИ Полный АТ", "Внедорожник 5 Door 1598(114) БИ Полный МТ", "Внедорожник 5 Door 1598(114) БИ Передний МТ"];
		let xtrail = ["Внедорожник 5 Door 2488(171) БИ Полный АТ", "Внедорожник 5 Door 1997(144) БИ Полный АТ", "Внедорожник 5 Door 1997(144) БИ Передний МТ", "Внедорожник 5 Door 1997(144) БИ Передний АТ", "Внедорожник 5 Door 1598(130) ДТ Полный МТ", "Внедорожник 5 Door (new) 2488(171) БИ Полный АТ", "Внедорожник 5 Door (new) 1997(144) БИ Полный АТ", "Внедорожник 5 Door (new) 1997(144) БИ Передний МТ", "Внедорожник 5 Door (new) 1997(144) БИ Передний АТ", "Внедорожник 5 Door (new) 1598(130) ДТ Полный МТ"];
		let sentra = ["Седан 1598(117) БИ Передний МТ", "Седан 1598(117) БИ Передний АТ"];
		let nissancomplectation = ["Mid", "High", "Mid+", "Top"];
		//Volkswagen=============================================================================================================================================
		let amarok = ["Пикап 1968(180) ДТ Полный МТ", "Пикап 1968(180) ДТ Полный АТ", "Пикап 1968(180) ДТ Задний МТ", "Пикап 1968(180) ДТ Задний АТ", "Пикап 1968(140) ДТ Полный МТ", "Пикап 1968(140) ДТ Задний МТ"];
		let beetle = ["Хэтчбек 3 Door 1984(210) БТ Передний АТ", "Хэтчбек 3 Door 1390(160) БТ Передний МТ", "Хэтчбек 3 Door 1390(160) БТ Передний АТ", "Хэтчбек 3 Door 1197(105) БТ Передний МТ", "Хэтчбек 3 Door 1197(105) БТ Передний АТ"];
		let caddy = ["Фургон 1968(110) ДТ Передний МТ", "Фургон 1197(86) БТ Передний МТ", "Фургон 1197(105) БТ Передний МТ", "Фургон (new) 1968(110) ДТ Передний МТ", "Универсал 1197(86) БТ Передний МТ", "Универсал 1197(105) БТ Передний МТ", "Универсал (new) 1968(110) ДТ Передний МТ", "Минивэн 1968(110) ДТ Передний МТ", "Минивэн 1197(105) БТ Передний МТ", "Минивэн (new) 1968(110) ДТ Передний МТ"];
		let golf = ["Хэтчбек 5 Door 1598(110) БИ Передний МТ", "Хэтчбек 5 Door 1598(110) БИ Передний АТ", "Хэтчбек 5 Door 1395(150) БТ Передний АТ", "Хэтчбек 5 Door 1395(140) БТ Передний АТ", "Хэтчбек 5 Door 1395(125) БТ Передний МТ", "Хэтчбек 5 Door 1395(125) БТ Передний АТ", "Хэтчбек 5 Door 1395(122) БТ Передний МТ", "Хэтчбек 5 Door 1395(122) БТ Передний АТ", "Хэтчбек 3 Door 1598(110) БИ Передний МТ", "Хэтчбек 3 Door 1598(110) БИ Передний АТ", "Хэтчбек 3 Door 1395(150) БТ Передний АТ", "Хэтчбек 3 Door 1395(125) БТ Передний МТ", "Хэтчбек 3 Door 1395(125) БТ Передний АТ"];
		let jetta = ["Седан 1598(90) БИ Передний МТ", "Седан 1598(85) БИ Передний МТ", "Седан 1598(105) БИ Передний МТ", "Седан 1598(105) БИ Передний АТ", "Седан 1390(150) БТ Передний АТ", "Седан 1390(122) БТ Передний МТ", "Седан 1390(122) БТ Передний АТ"];
		let passat = ["Универсал 1984(210) БТ Полный АТ", "Универсал 1968(170) ДТ Передний АТ", "Универсал 1798(152) БТ Передний МТ", "Универсал 1798(152) БТ Передний АТ", "Универсал 1390(122) БТ Передний МТ", "Универсал 1390(122) БТ Передний АТ", "Седан 1984(210) БТ Передний АТ", "Седан 1968(170) ДТ Передний АТ", "Седан 1798(152) БТ Передний МТ", "Седан 1798(152) БТ Передний АТ", "Седан 1390(122) БТ Передний МТ", "Седан 1390(122) БТ Передний АТ", "Седан (new) 1798(180) БТ Передний АТ", "Седан (new) 1395(150) БТ Передний АТ", "Седан (new) 1395(125) БТ Передний МТ"];
		let tiguan = ["Внедорожник 5 Door 1984(210) БТ Полный АТ", "Внедорожник 5 Door 1984(200) БТ Полный АТ", "Внедорожник 5 Door 1984(170) БТ Полный АТ", "Внедорожник 5 Door 1968(140) ДТ Полный АТ", "Внедорожник 5 Door 1390(150) БТ Полный МТ", "Внедорожник 5 Door 1390(150) БТ Передний АТ", "Внедорожник 5 Door 1390(122) БТ Передний МТ"];
		let polo = ["Седан 1598(105) БИ Передний МТ", "Седан 1598(105) БИ Передний АТ", "Седан (new) 1598(85) БИ Передний МТ", "Седан (new) 1598(105) БИ Передний МТ", "Седан (new) 1598(105) БИ Передний АТ"];
		let volkswagencomplectation = ["Aventura", "Canyon", "Dark Lebel", "Highline"];
		//===================================================================================================

		document.querySelector("#color").innerHTML = "<option>Выберите цвет...</option>";
		for (let i = 0; i < colors.length; i++) {
			document.querySelector("#color").innerHTML += "<option>" + colors[i] + "</option>";
		}

		document.querySelector("#mark").innerHTML = "<option>Выберите марку...</option>";
		for (let i = 0; i < marks.length; i++) {
			document.querySelector("#mark").innerHTML += "<option>" + marks[i] + "</option>";
		}

		function openMark() {
			document.querySelector("#mark").classList.remove("display_none");
		}
		function markSelected() {
			let select = document.querySelector("#mark");
			let getSelectText = select[select.selectedIndex].text;
			if (getSelectText != "Выберите марку..."){
				mark = getSelectText;
				document.querySelector("#title").innerHTML = "Название: " + mark;
				document.querySelector("#mark_s").innerHTML = "Марка: " + mark;
				document.querySelector("#mark").classList.add("display_none");

				document.querySelector("#modification_s").innerHTML = "Модификация: ";
				document.querySelector("#model_s").innerHTML = "Модель: ";
				document.querySelector("#complectation_s").innerHTML = "Комплектация: ";

				if (getSelectText == "Toyota") {
					for (let i = 0; i < toyota.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + toyota[i] + "</option>";
					}
				} else if (getSelectText == "Lexus") {
					for (let i = 0; i < lexus.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + lexus[i] + "</option>";
					}
				} else if (getSelectText == "Volvo") {
					for (let i = 0; i < volvo.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + volvo[i] + "</option>";
					}
				} else if (getSelectText == "BMW") {
					for (let i = 0; i < bmw.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + bmw[i] + "</option>";
					}
				} else if (getSelectText == "Mercedes-Benz") {
					for (let i = 0; i < mercedes.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + mercedes[i] + "</option>";
					}
				} else if (getSelectText == "Audi") {
					for (let i = 0; i < audi.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + audi[i] + "</option>";
					}
				} else if (getSelectText == "Cadillac") {
					for (let i = 0; i < cadillac.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + cadillac[i] + "</option>";
					}
				} else if (getSelectText == "Chevrolet") {
					for (let i = 0; i < chevrolet.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + chevrolet[i] + "</option>";
					}
				} else if (getSelectText == "Kia") {
					for (let i = 0; i < kia.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + kia[i] + "</option>";
					}
				} else if (getSelectText == "Hyundai") {
					for (let i = 0; i < hyundai.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + hyundai[i] + "</option>";
					}
				} else if (getSelectText == "Mazda") {
					for (let i = 0; i < mazda.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + mazda[i] + "</option>";
					}
				} else if (getSelectText == "Nissan") {
					for (let i = 0; i < nissan.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + nissan[i] + "</option>";
					}
				} else if (getSelectText == "Volkswagen") {
					for (let i = 0; i < volkswagen.length; i++) {
						document.querySelector("#model").innerHTML += "<option>" + volkswagen[i] + "</option>";
					}
				}

				if (mark == "Toyota") {
					for (let i = 0; i < toyotacomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + toyotacomplectation[i] + "</option>";
					}
				} else if (mark == "Lexus") {
					for (let i = 0; i < lexuscomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + lexuscomplectation[i] + "</option>";
					}
				} else if (mark == "Volvo") {
					for (let i = 0; i < volvocomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + volvocomplectation[i] + "</option>";
					}
				} else if (mark == "BMW") {
					for (let i = 0; i < bmwcomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + bmwcomplectation[i] + "</option>";
					}
				} else if (mark == "Mercedes-Benz") {
					for (let i = 0; i < mercedescomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + mercedescomplectation[i] + "</option>";
					}
				} else if (mark == "Audi") {
					for (let i = 0; i < audicomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + audicomplectation[i] + "</option>";
					}
				} else if (mark == "Cadillac") {
					for (let i = 0; i < cadillaccomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + cadillaccomplectation[i] + "</option>";
					}
				} else if (mark == "Chevrolet") {
					for (let i = 0; i < chevroletcomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + chevroletcomplectation[i] + "</option>";
					}
				} else if (mark == "Kia") {
					for (let i = 0; i < kiacomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + kiacomplectation[i] + "</option>";
					}
				} else if (mark == "Hyundai") {
					for (let i = 0; i < hyundaicomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + hyundaicomplectation[i] + "</option>";
					}
				} else if (mark == "Mazda") {
					for (let i = 0; i < mazdacomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + mazdacomplectation[i] + "</option>";
					}
				} else if (mark == "Nissan") {
					for (let i = 0; i < nissancomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + nissancomplectation[i] + "</option>";
					}
				} else if (mark == "Volkswagen") {
					for (let i = 0; i < volkswagencomplectation.length; i++) {
						document.querySelector("#complectation").innerHTML += "<option>" + volkswagencomplectation[i] + "</option>";
					}
				}
			}
		}
//=============================================================================================================
		function openModel() {
			document.querySelector("#model").classList.remove("display_none");
		}
		function modelSelected() {
			let select = document.querySelector("#model");
			let getSelectText = select[select.selectedIndex].text;
			
			if (getSelectText != "Выберите модель...") {
				model = getSelectText;
				let title = document.querySelector("#title").innerHTML;
				document.querySelector("#title").innerHTML = title +  " " + model;

				document.querySelector("#model_s").innerHTML = "Модель: " + model;
				document.querySelector("#model").classList.add("display_none");

				//Toyota
				//==========================================================================================
			}
				if (model == "Camry") {
					for (let i = 0; i < camry.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + camry[i] + "</option>";
					}
				} else if (model == "Corolla") {
					for (let i = 0; i < corolla.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + corolla[i] + "</option>";
					}
				} else if (model == "Highlander") {
					for (let i = 0; i < highlander.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + highlander[i] + "</option>";
					}
				} else if (model == "Land Cruiser Prado") {
					for (let i = 0; i < prado.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + prado[i] + "</option>";
					}
				} else if (model == "RAV4") {
					for (let i = 0; i < rav4.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + rav4[i] + "</option>";
					}
				}

				//Lexus
				//==========================================================================================
				else if (model == "ES") {
					for (let i = 0; i < es.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + es[i] + "</option>";
					}
				} else if (model == "GX") {
					for (let i = 0; i < gx.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + gx[i] + "</option>";
					}
				} else if (model == "LS") {
					for (let i = 0; i < ls.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + ls[i] + "</option>";
					}
				} else if (model == "LX") {
					for (let i = 0; i < lx.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + lx[i] + "</option>";
					}
				} else if (model == "NX") {
					for (let i = 0; i < nx.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + nx[i] + "</option>";
					}
				} else if (model == "RX") {
					for (let i = 0; i < rx.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + rx[i] + "</option>";
					}
				}

				//BMW 
				//=====================================================================================
				else if (model == "2") {
					for (let i = 0; i < two.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + two[i] + "</option>";
					}
				}
				else if (model == "3") {
					for (let i = 0; i < three.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + three[i] + "</option>";
					}
				} else if (model == "3 GT") {
					for (let i = 0; i < threegt.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + threegt[i] + "</option>";
					}
				} else if (model == "4") {
					for (let i = 0; i < four.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + four[i] + "</option>";
					}
				} else if (model == "5") {
					for (let i = 0; i < five.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + five[i] + "</option>";
					}
				} else if (model == "6 GT") {
					for (let i = 0; i < sixgt.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + sixgt[i] + "</option>";
					}
				} else if (model == "M4") {
					for (let i = 0; i < m4.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + m4[i] + "</option>";
					}
				} else if (model == "M6") {
					for (let i = 0; i < m6.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + m6[i] + "</option>";
					}
				} else if (model == "X5") {
					for (let i = 0; i < x5.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + x5[i] + "</option>";
					}
				} else if (model == "X6") {
					for (let i = 0; i < x6.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + x6[i] + "</option>";
					}
				} else if (model == "X7") {
					for (let i = 0; i < x7.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + x7[i] + "</option>";
					}
				}

				//Mercedes-Benz
				//=========================================================================================================
				else if (getSelectText == "AMG GT") {
					for (let i = 0; i < amggt.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + amggt[i] + "</option>";
					}
				} else if (getSelectText == "A-Klasse") {
					for (let i = 0; i < a_klasse.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + a_klasse[i] + "</option>";
					}
				} else if (getSelectText == "AMG GT R") {
					for (let i = 0; i < amggtr.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + amggtr[i] + "</option>";
					}
				} else if (getSelectText == "AMG GT S") {
					for (let i = 0; i < amggts.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + amggts[i] + "</option>";
					}
				} else if (getSelectText == "B-Klasse") {
					for (let i = 0; i < b_klasse.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + b_klasse[i] + "</option>";
					}
				} else if (getSelectText == "C-Klasse") {
					for (let i = 0; i < c_klasse.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + c_klasse[i] + "</option>";
					}
				} else if (getSelectText == "E-Klasse") {
					for (let i = 0; i < e_klasse.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + e_klasse[i] + "</option>";
					}
				} else if (getSelectText == "G-Klasse") {
					for (let i = 0; i < g_klasse.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + g_klasse[i] + "</option>";
					}
				} else if (getSelectText == "S-Klasse") {
					for (let i = 0; i < s_klasse.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + s_klasse[i] + "</option>";
					}
				}

				//Volvo
				//=======================================================================================================
				else if (getSelectText == "S60") {
					for (let i = 0; i < s60.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + s60[i] + "</option>";
					}
				} else if (getSelectText == "S90") {
					for (let i = 0; i < s90.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + s90[i] + "</option>";
					}
				} else if (getSelectText == "V60 Cross Country") {
					for (let i = 0; i < v60cross.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + v60cross[i] + "</option>";
					}
				} else if (getSelectText == "V90 Cross Country") {
					for (let i = 0; i < v90.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + v90[i] + "</option>";
					}
				} else if (getSelectText == "XC40") {
					for (let i = 0; i < xc40.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + xc40[i] + "</option>";
					}
				} else if (getSelectText == "XC60") {
					for (let i = 0; i < xc60.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + xc60[i] + "</option>";
					}
				} else if (getSelectText == "XC90") {
					for (let i = 0; i < xc90.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + xc90[i] + "</option>";
					}
				}

				//Audi
				//=====================================================================================================================
				else if (getSelectText == "A3") {
					for (let i = 0; i < a3.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + a3[i] + "</option>";
					}
				} else if (getSelectText == "A5") {
					for (let i = 0; i < a5.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + a5[i] + "</option>";
					}
				} else if (getSelectText == "A6") {
					for (let i = 0; i < a6.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + a6[i] + "</option>";
					}
				} else if (getSelectText == "A7") {
					for (let i = 0; i < a7.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + a7[i] + "</option>";
					}
				} else if (getSelectText == "A8") {
					for (let i = 0; i < a8.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + a8[i] + "</option>";
					}
				} else if (getSelectText == "Q3") {
					for (let i = 0; i < q3.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + q3[i] + "</option>";
					}
				} else if (getSelectText == "Q5") {
					for (let i = 0; i < q5.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + q5[i] + "</option>";
					}
				} else if (getSelectText == "Q7") {
					for (let i = 0; i < q7.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + q7[i] + "</option>";
					}
				} else if (getSelectText == "Q8") {
					for (let i = 0; i < q8.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + q8[i] + "</option>";
					}
				} else if (getSelectText == "S5") {
					for (let i = 0; i < s5.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + s5[i] + "</option>";
					}
				} else if (getSelectText == "S6") {
					for (let i = 0; i < s6.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + s6[i] + "</option>";
					}
				} else if (getSelectText == "S8") {
					for (let i = 0; i < s8.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + s8[i] + "</option>";
					}
				} else if (getSelectText == "SQ5") {
					for (let i = 0; i < sq5.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + sq5[i] + "</option>";
					}
				} else if (getSelectText == "SQ7") {
					for (let i = 0; i < sq7.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + sq7[i] + "</option>";
					}
				} else if (getSelectText == "SQ8") {
					for (let i = 0; i < sq8.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + sq8[i] + "</option>";
					}
				}

				//Cadillac
				//=================================================================================================
				else if (getSelectText == "CT6") {
					for (let i = 0; i < ct6.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + ct6[i] + "</option>";
					}
				} else if (getSelectText == "Escalade") {
					for (let i = 0; i < escalade.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + escalade[i] + "</option>";
					}
				} else if (getSelectText == "XT5") {
					for (let i = 0; i < xt5.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + xt5[i] + "</option>";
					}
				} else if (getSelectText == "XT6") {
					for (let i = 0; i < xt6.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + xt6[i] + "</option>";
					}
				}

				//Chevrolet
				//=============================================================================================
				else if (getSelectText == "Cobalt") {
					for (let i = 0; i < cobalt.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + cobalt[i] + "</option>";
					}	
				} else if (getSelectText == "Nexia") {
					for (let i = 0; i < nexia.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + nexia[i] + "</option>";
					}
				} else if (getSelectText == "Niva") {
					for (let i = 0; i < niva.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + niva[i] + "</option>";
					}
				} else if (getSelectText == "Spark") {
					for (let i = 0; i < spark.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + spark[i] + "</option>";
					}
				} else if (getSelectText == "Tahoe") {
					for (let i = 0; i < tahoe.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + tahoe[i] + "</option>";
					}
				} else if (getSelectText == "Traverse") {
					for (let i = 0; i < traverse.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + traverse[i] + "</option>";
					}
				}

				//Kia
				//=================================================================================================
				else if (getSelectText == "Ceed") {
					for (let i = 0; i < ceed.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + ceed[i] + "</option>";
					}
				} else if (getSelectText == "Cerato") {
					for (let i = 0; i < cerato.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + cerato[i] + "</option>";
					}
				} else if (getSelectText == "K5") {
					for (let i = 0; i < k5.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + k5[i] + "</option>";
					}
				} else if (getSelectText == "k900") {
					for (let i = 0; i < k900.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + k900[i] + "</option>";
					}
				} else if (getSelectText == "Optima") {
					for (let i = 0; i < optima.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + optima[i] + "</option>";
					}
				} else if (getSelectText == "Rio") {
					for (let i = 0; i < rio.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + rio[i] + "</option>";
					}
				} else if (getSelectText == "Soul") {
					for (let i = 0; i < soul.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + soul[i] + "</option>";
					}
				} else if (getSelectText == "Stinger") {
					for (let i = 0; i < stinger.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + stinger[i] + "</option>";
					}
				} else if (getSelectText == "Xceed") {
					for (let i = 0; i < xceed.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + xceed[i] + "</option>";
					}
				}

				//Hyundai
				//================================================================================================
				else if (getSelectText == "Creta") {
					for (let i = 0; i < creta.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + creta[i] + "</option>";
					}
				} else if (getSelectText == "Elantra") {
					for (let i = 0; i < elantra.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + elantra[i] + "</option>";
					}
				} else if (getSelectText == "Solaris") {
					for (let i = 0; i < solaris.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + solaris[i] + "</option>";
					}
				} else if (getSelectText == "Tucson") {
					for (let i = 0; i < tucson.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + tucson[i] + "</option>";
					}
				}

				//Mazda
				//================================================================================================
				else if (getSelectText == "6") {
					for (let i = 0; i < mazda6.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + mazda6[i] + "</option>";
					}
				} else if (getSelectText == "CX-5") {
					for (let i = 0; i < cx5.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + cx5[i] + "</option>";
					}
				}

				//Nissan
				//================================================================================================
				else if (getSelectText == "Almera") {
					for (let i = 0; i < almera.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + almera[i] + "</option>";
					}
				} else if (getSelectText == "GT-R") {
					for (let i = 0; i < gtr.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + gtr[i] + "</option>";
					}
				} else if (getSelectText == "Murano") {
					for (let i = 0; i < murano.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + murano[i] + "</option>";
					}
				} else if (getSelectText == "Sentra") {
					for (let i = 0; i < sentra.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + sentra[i] + "</option>";
					}
				} else if (getSelectText == "Terrano") {
					for (let i = 0; i < terrano.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + terrano[i] + "</option>";
					}
				} else if (getSelectText == "X-Trail") {
					for (let i = 0; i < xtrail.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + xtrail[i] + "</option>";
					}
				}

				//Volkswagen
				//===================================================================================================
				else if (getSelectText == "Amarok") {
					for (let i = 0; i < amarok.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + amarok[i] + "</option>";
					}
				} else if (getSelectText == "Beetle") {
					for (let i = 0; i < beetle.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + beetle[i] + "</option>";
					}
				} else if (getSelectText == "Caddy") {
					for (let i = 0; i < caddy.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + caddy[i] + "</option>";
					}
				} else if (getSelectText == "Golf") {
					for (let i = 0; i < golf.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + golf[i] + "</option>";
					}
				} else if (getSelectText == "Jetta") {
					for (let i = 0; i < jetta.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + jetta[i] + "</option>";
					}
				} else if (getSelectText == "Passat") {
					for (let i = 0; i < passat.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + passat[i] + "</option>";
					}
				} else if (getSelectText == "Tiguan") {
					for (let i = 0; i < tiguan.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + tiguan[i] + "</option>";
					}
				} else if (getSelectText == "Polo") {
					for (let i = 0; i < polo.length; i++) {
						document.querySelector("#modification").innerHTML += "<option>" + polo[i] + "</option>";
					}
				}
		}
//=============================================================================================================
		function openModification() {
			document.querySelector("#modification").classList.remove("display_none");
		}

		function modificationSelected() {
			let select = document.querySelector("#modification");
			let getSelectText = select[select.selectedIndex].text;
			if (getSelectText != "Выберите модификацию...") {
				modification = getSelectText;

				document.querySelector("#modification_s").innerHTML = "Модификация: " + modification;
				document.querySelector("#modification").classList.add("display_none");
			}
		}
//============================================================================================================
		function openComplectation() {
			document.querySelector("#complectation").classList.remove("display_none");
		}
		function complectationSelected() {
			let select = document.querySelector("#complectation");
			let getSelectText = select[select.selectedIndex].text;
			if (getSelectText != "Выберите комплектацию...") {
				complectation = getSelectText;
				let title = document.querySelector("#title").innerHTML;
				document.querySelector("#title").innerHTML = title +  " " + complectation;
				document.querySelector("#complectation_s").innerHTML = "Комплектация: " + complectation;
				document.querySelector("#complectation").classList.add("display_none");
			}
		}
//=============================================================================================================
		function openYear() {
			document.querySelector("#year").classList.remove("display_none");
		}
		function yearSelected() {
			let select = document.querySelector("#year");
			let getSelectText = select[select.selectedIndex].text;
			if (getSelectText != "Выберите год...") {
				year = getSelectText;
				document.querySelector("#year_s").innerHTML = "Год: " + year;
				document.querySelector("#year").classList.add("display_none");
			}
		}
//=============================================================================================================
		function openColor() {
			document.querySelector("#color").classList.remove("display_none");
		}
		function colorSelected() {
			let select = document.querySelector("#color");
			let getSelectText = select[select.selectedIndex].text;
			if (getSelectText != "Выберите цвет...") {
				color = getSelectText;
				document.querySelector("#color_").innerHTML = "Цвет: " + color;
				document.querySelector("#color").classList.add("display_none");
			}
		}
//=============================================================================================================
		function openPrice() {
			document.querySelector("#pric").classList.remove("hidden");
		}
		function priceSelected() {
			let select = document.querySelector("#price").value;
			if (select != "") {
				price = select;
				document.querySelector("#price_s").innerHTML = "Цена: " + price;
				document.querySelector("#pric").classList.add("hidden");
			}
		}
//=============================================================================================================
		function openMileage() {
			document.querySelector("#mileag").classList.remove("hidden")
		}
		function mileageSelected() {
			let select = document.querySelector("#mileage").value;
			if (select != "") {
				mileage = select;
				console.log(mileage);
				document.querySelector("#mileage_s").innerHTML = "Цена: " + mileage;
				document.querySelector("#mileag").classList.add("hidden");
			}
		}
//=============================================================================================================
		function openPhoto() {
			document.querySelector("#srcc").classList.remove("display_none");
		}
		function photoSelected() {
			let select = document.querySelector("#src").value;
			if (select != "") {
				src = select;
				document.querySelector("#srcc").classList.add("display_none");
			}
		}
//=============================================================================================================
		function openPhone() {
			document.querySelector("#phon").classList.remove("hidden");
		}
		function phoneSelected() {
			let select = document.querySelector("#phone").value;
			if (select != "") {
				phone = select;
				console.log(mileage);
				document.querySelector("#phone_s").innerHTML = "Телефон: " + phone;
				document.querySelector("#phon").classList.add("hidden");
			}
		}
//=============================================================================================================
		function openMail() {
			document.querySelector("#mai").classList.remove("hidden");
		}
		function mailSelected() {
			let select = document.querySelector("#mail").value;
			if (select != "") {
				mail = select;
				document.querySelector("#mail_s").innerHTML = "E-mail: " + mail;
				document.querySelector("#mai").classList.add("hidden");
			}
		}


		let color = '<?php echo $result['color']?>';
		let mark = '<?php echo $result['brand']?>';
		let model = '<?php echo $result['model']?>';
		let modification = '<?php echo $result['modification']?>';
		let complectation = '<?php echo $result['complectation']?>';
		let price = <?php echo $result['price']?>;
		let year = <?php echo $result['year']?>;
		let src = "";
		let mileage = <?php echo $result['mileage']?>;
		let title = mark + " " + model + " " + complectation;
		let phone = '<?php echo $result['phone']?>';
		let mail = '<?php echo $result['e-mail']?>';
		let delete_src = "";

		function go() {
			document.querySelector("#year_t").value = year;
			document.querySelector("#color_t").value = color;
			document.querySelector("#mark_t").value = mark;
			document.querySelector("#model_t").value = model;
			document.querySelector("#modification_t").value = modification;
			document.querySelector("#complectation_t").value = complectation;
			document.querySelector("#price_t").value = price;
			document.querySelector("#src_t").value = src;
			document.querySelector("#mileage_t").value = mileage;
			document.querySelector("#title_t").value = title;
			document.querySelector("#phone_t").value = phone;
			document.querySelector("#mail_t").value = mail;
			document.querySelector("#delete_img_t").value = delete_src;
		}
		setInterval(go, 100);

		let a = document.querySelectorAll(".delete_img_btn");
		for (let addBasket of a) {
		    addBasket.addEventListener('click', delete_img);
		}

		function delete_img() {
			console.log("DS");
			let a = event.currentTarget.parentNode.querySelector('.edit_img').src;
			event.currentTarget.parentNode.classList.add("display_none");
			delete_src += " " + a;
			console.log(delete_src);
		}
	</script>
</html>