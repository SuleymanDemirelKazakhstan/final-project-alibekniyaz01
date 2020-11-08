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
	<title><?php echo $config['title']?></title>
</head>
<body>
	<?php
		include "header.php";
		$result = mysqli_query($connection, "SELECT * FROM announcement");		
		$image_link = mysqli_query($connection, "SELECT * FROM photo");

		if (isset($_GET['save_like'])) {
			$link = $_SERVER['REQUEST_URI']; 		      
		  	$b = explode(("="), $link);
			$a = mysqli_query($connection, "SELECT islike FROM announcement WHERE id=".$b[2]);
			$a = mysqli_fetch_row($a);
			if ($a[0] == 'no') {
				$a = mysqli_query($connection, "UPDATE announcement SET islike='yes' WHERE id=".$b[2]);
				if ($a) {
				} else echo "ERROR1";
			} else {
				$a = mysqli_query($connection, "UPDATE announcement SET islike='no' WHERE id=".$b[2]);
				if ($a) {
				} else echo "ERROR2";
			}?>
			<script type="text/javascript">
				window.location.replace("http://webpro.com/index.php");
			</script>
			<?php
   			exit(); 
		}

		$rows = mysqli_num_rows($result);
		$rows_photo = mysqli_num_rows($image_link);
		for ($i = 0; $i < $rows; $i++) {
			$row = mysqli_fetch_row($result);
			$id[$i] = $row[0];
			$title[$i] = $row[1];
			$model[$i] = $row[2];
			$year[$i] = $row[3];
			$brand[$i] = $row[4];
			$modification[$i] = $row[5];
			$complectation[$i] = $row[6];
			$mileage[$i] = $row[7];
			$phone[$i] = $row[8];
			$mail[$i] = $row[9];
			$price[$i] = $row[10];
			$date[$i] = $row[11];
			$color[$i] = $row[12];
			$isLike[$i] = $row[14];
			$image_link = mysqli_query($connection, "SELECT * FROM photo WHERE idd=" . $row[0]);
			for ($j = 0; $j < $rows_photo; $j++) {
				$row_photo = mysqli_fetch_row($image_link);
				if ($row_photo[1] == $row[0]) {
					$photo[$i] = $row_photo[2];
					break;
				}
			}
		}
	?>


	<div class="container">
		<h1 class="body__title">Online car store</h1>
		<div class="body_and_search">
			<div class="search">
				<form style="display: flex; flex-direction: column; justify-content: center;">
					<select class="all_form" id="year" onchange="selectYear()">
						<option class="" value="-1">Choose year...</option>
						<?php
							for ($i = 2020; $i >= 2010; $i--) {
								echo "<option>" . $i . "</option>";
							}
						?>
					</select>
					<select class="all_form" id="mark" onchange="selectMark()">
						<option class="" value="-1">Choose brand...</option>
					</select>
					<select class="all_form" id="model" onchange="selectModel()">
						<option class="option1" value="-1">Choose model...</option>
					</select>
					<select class="all_form" id="color" onchange="selectColor()">
						<option>Choose color...</option>
					</select>
					<a style="text-align: center; font-size: 18px; margin: 15px 0 5px 0;">Price</a>
					<div class="from_till">
						<div class="">
							from
							<input id="from" style="width: 75px" class="from_t" type="number" onkeyup="selectFrom()">
						</div>
						<div style="margin-bottom: 5px" class="">
							before
							<input id="to" style="width: 75px" class="from_t" type="number" onkeyup="selectTo()">
						</div>
					</div>
					<a id="search_btn" class="search_btn all_form">Search</a>
					<script type="text/javascript">
						let i = 0;

						let search_btn = document.querySelector('#search_btn');
						search_btn.addEventListener('click', search);						

						function search() {
							let mark = document.querySelector("#mark_t").value;
							if (mark == "Choose brand...") {
								mark = '';
							}
							let model = document.querySelector("#model_t").value;
							let year = document.querySelector("#finish_t").value;
							if (year == "Choose year...") {
								year = '';
							}
							let color = document.querySelector("#color_t").value;
							if (color == "Choose color...") {
								color = '';
							}
							let price_from = document.querySelector("#price_from").value;
							let price_to = document.querySelector("#price_to").value;

							//===========================================================

							
							document.querySelector(".fffffff").innerHTML = '';
							fetch("cars.php").then(data => data.text()).then(data => {
								let cars = JSON.parse(data);
								fetch("links.php").then(data => data.text()).then(data => {
									let links = JSON.parse(data);
									if (mark != '' || model != '' || year != '' || color != '' || price_from != '' || price_to != '') {
									if (mark != '' && model != '' && year != '' && color != '' && price_from != '' && price_to != '') {
										for (let i = 0; i < cars.length; i++) {
											console.log(mark, model, year, color)
											if (cars[i]['brand'].includes(mark) && cars[i]['year'].includes(year) && cars[i]['model'].includes(model) && cars[i]['color'].includes(color)) {
													let link = null;
													for (let j = 0; j < links.length; j++) {
														if (links[j]['idd'] == cars[i]['id']) {
															link = links[j]['src'];
															break;
														}
													}
													document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' km. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Saved'; else echo 'Save'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' tg</div></div></div>'
											}
										}
									}
									else if (mark != '' && model == '' && year == '' && color == '' && price_from == '' && price_to == '') {
										for (let i = 0; i < cars.length; i++) {
											if (cars[i]['brand'].includes(mark)) {
												let link = null;
													for (let j = 0; j < links.length; j++) {
														if (links[j]['idd'] == cars[i]['id']) {
															link = links[j]['src'];
															break;
														}
													}
													document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' km. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Saved'; else echo 'Save'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' tg</div></div></div>'
											}
										}
									}
									else if (mark != '' && model != '' && year == '' && color == '' && price_from == '' && price_to == '') {
										for (let i = 0; i < cars.length; i++) {
											if (cars[i]['brand'].includes(mark) && cars[i]['model'].includes(model)) {
												let link = null;
													for (let j = 0; j < links.length; j++) {
														if (links[j]['idd'] == cars[i]['id']) {
															link = links[j]['src'];
															break;
														}
													}
													document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' км. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Сохранено'; else echo 'Сохранить'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' тг</div></div></div>'
											}
										}
									}
									else if (mark != '' && model != '' && year != '' && color == '' && price_from == '' && price_to == '') {
										for (let i = 0; i < cars.length; i++) {
											if (cars[i]['brand'].includes(mark) && cars[i]['model'].includes(model) && cars[i]['year'].includes(year)) {
												for (let j = 0; j < links.length; j++) {
														if (links[j]['idd'] == cars[i]['id']) {
															link = links[j]['src'];
															break;
														}
													}
													document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' км. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Сохранено'; else echo 'Сохранить'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' тг</div></div></div>'
											}}
									}
									else if (mark != '' && model == '' && year != '' && color == '' && price_from == '' && price_to == '') {
										for (let i = 0; i < cars.length; i++) {
											if (cars[i]['brand'].includes(mark) && cars[i]['year'] == year) {
												for (let j = 0; j < links.length; j++) {
														if (links[j]['idd'] == cars[i]['id']) {
															link = links[j]['src'];
															break;
														}
													}
													document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' км. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Сохранено'; else echo 'Сохранить'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' тг</div></div></div>'
											}
										}
									}
									else if (mark == '' && year == '' && color != '' && price_from == '' && price_to == '' && price_from == '') {
										for (let i = 0; i < cars.length; i++) {
											if (cars[i]['color'].includes(color)) {
												for (let j = 0; j < links.length; j++) {
														if (links[j]['idd'] == cars[i]['id']) {
															link = links[j]['src'];
															break;
														}
													}
													document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' км. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Сохранено'; else echo 'Сохранить'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' тг</div></div></div>'
											}
										}
									}
									else if (mark == '' && year == '' && color != '' && price_from != '' && price_to == '') {
										for (let i = 0; i < cars.length; i++) {
											if (cars[i]['color'].includes(color) && cars[i]['price'] >= price_from) {
												for (let j = 0; j < links.length; j++) {
														if (links[j]['idd'] == cars[i]['id']) {
															link = links[j]['src'];
															break;
														}
													}
													document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' км. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Сохранено'; else echo 'Сохранить'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' тг</div></div></div>'
											}
										}
									}
									else if (mark == '' && year == '' && color == '' && price_from != '' && price_to == '') {
										for (let i = 0; i < cars.length; i++) {
											if (cars[i]['price'] >= price_from) {
												for (let j = 0; j < links.length; j++) {
														if (links[j]['idd'] == cars[i]['id']) {
															link = links[j]['src'];
															break;
														}
													}
													document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' км. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Сохранено'; else echo 'Сохранить'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' тг</div></div></div>'
											}
										}
									}
									else if (mark == '' && year == '' && color == '' && price_from != '' && price_to != '') {
										for (let i = 0; i < cars.length; i++) {
											if (cars[i]['price'] >= price_from && cars[i]['price'] <= price_to) {
												for (let j = 0; j < links.length; j++) {
														if (links[j]['idd'] == cars[i]['id']) {
															link = links[j]['src'];
															break;
														}
													}
													document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' км. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Сохранено'; else echo 'Сохранить'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' тг</div></div></div>'
											}
										}
									}
									else if (mark == '' && year == '' && color == '' && price_from == '' && price_to != '') {
										for (let i = 0; i < cars.length; i++) {
											if (cars[i]['price'] <= price_to) {
												for (let j = 0; j < links.length; j++) {
														if (links[j]['idd'] == cars[i]['id']) {
															link = links[j]['src'];
															break;
														}
													}
													document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' км. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Сохранено'; else echo 'Сохранить'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' тг</div></div></div>'
											}
										}
									}
									else if (year != '' && mark == '' && color == '' && price_from == '' && price_to == '') {
										for (let i = 0; i < cars.length; i++) {
											if (cars[i]['year'].includes(year)) {
												for (let j = 0; j < links.length; j++) {
														if (links[j]['idd'] == cars[i]['id']) {
															link = links[j]['src'];
															break;
														}
													}
													document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' км. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Сохранено'; else echo 'Сохранить'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' тг</div></div></div>'
											}
										}	
									}
									
								}
								else  {
										for (let i = 0; i < cars.length; i++) {
											let link = null;
												for (let j = 0; j < links.length; j++) {
													if (links[j]['idd'] == cars[i]['id']) {
														link = links[j]['src'];
														break;
													}
												}
												document.querySelector(".fffffff").innerHTML += '<div class="content"><div class="image__content"><img src="'+link+'"></div><div class="about__car"><div class="title__content"><a href="element.php?id='+cars[i]['id']+'" class="a">'+cars[i]['title']+'</a><a class="a">'+cars[i]['year']+'</a><a class="b">'+cars[i]['mileage']+' км. '+cars[i]['modification']+'</a></div></div><div class="like__and__price"><form method="get" id="src"><input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Сохранено'; else echo 'Сохранить'?>"><input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>"></form><div class="price">'+cars[i]['price']+' тг</div></div></div>'
										}
									}

								});
							});

							

							//===========================================================

							
							
							
						}
					</script>

					<form method="get">
						<input type="hidden" name="finish_t" id="finish_t">
						<input type="hidden" name="mark_t" id="mark_t">
						<input type="hidden" name="model_t" id="model_t">
						<input type="hidden" name="color_t" id="color_t">
						<input type="hidden" name="price_from" id="price_from">
						<input type="hidden" name="price_to" id="price_to">
					</form>
				</form>
			</div>


			<div class="fffffff">
				
				<?php
					if (isset($_GET['search'])) {
						if ($isEmpty) {
							echo '<div class=container><a class="result_zero">No results were found for your search :(</a></div>';
						} else {
							echo '<div class=container><a class="result_zero">Found on your request ' . $count[0] . ' ads</a></div>
								<div>Year: '.$finish.'</div>
								<div>Brand: '.$mark_t.'</div>
								<div>Model: '.$model_t.'</div>
								<div>Color: '.$color_t.'</div>
								<div>Price: from '.$price_from.' before '.$price_to.'</div>
							';
						}
					}
				?>
				<?php	
					$res = mysqli_fetch_assoc($result);
					$rows = mysqli_num_rows($result);
					for ($i = 0; $i < $rows; $i++) {
				?>
					<div class="content">
						<div class="image__content">
							<img src="<?php echo $photo[$i];?>">
						</div>
						<div class="about__car">
							<div class="title__content">
								<a href="element.php?id=<?php echo $id[$i];?>" class="a"><?php echo $title[$i];?></a>
								<a class="a"><?php echo $year[$i]?></a>
								<a class="b"><?php echo $mileage[$i]?> km. <?php echo $modification[$i]?></a>
							</div>
						</div>
						<div class="like__and__price">
							<form method="get" id="src">
								<input id="src" type="submit" name="save_like" value="<?php if ($isLike[$i] == 'yes') echo 'Saved'; else echo 'Save'?>">
								<input type="hidden" name="like" id="like_t" value="<?php echo $id[$i];?>">
							</form>
							<div class="price"><?php echo $price[$i]?> tg</div>
						</div>
					</div>
				<?php
					}
				?>
			</div>
		
			
		</div>
	</div>
	<?php require "footer.php"?>
	<?php
		if(isset($_POST['save'])) {
			echo $id_save;
		}
	?>
</body>

<style type="text/css">
	.divloading {
		
	}

	.loading {
		width: 150px;
	}

	.mini_search {
		display: none;
	}
	input[id='src'] {
		background-color: white;
		border: none;
		cursor: pointer;

		border: 1px solid lightgray;
		background-color: lightgray;

		opacity: .7;
	}
	input[id='src'] {

		opacity: 1;
	}

	.result_zero_div {
	}

	.result_zero {
		margin: 20px 0;

		color: brown;
		font-size: 18px;
	}

	.from_t {
		width: 40%;
		margin: 0 5px;
	}

	.from_till {
		display: flex;
		justify-content: space-between;
	}

	.search_btn {
		background-color: black;
		color: white;

		cursor: pointer;

		text-align: center;
		opacity: .7;
	}

	.search_btn:hover {
		opacity: 1;
	}

	.all_form {
		font-size: 18px;
    	padding: 5px 20px;
    	margin-bottom: 5px;
	}

	.body_and_search {
		display: flex;
		justify-content: space-between;
	}

	.search {
		position: relative;
		background-color: lightgray;

		display: flex;
		justify-content: center;
		align-items: center;

		width: 250px;
		height: 350px;

		margin-bottom: 112px;
	}

	@media (max-width: 700px) {
		
		.about__car {
			width: 100%;
			margin: 0;
		}
		.title__content {
			width: 100%;
		}
		.a {
			text-align: center;
		}
		.b {
			text-align: center;
		}
		.like__and__price {
			margin: 20px;
		}
		.content {
			display: flex;
			flex-direction: column;
			justify-content: center;
		}
	}

	@media (max-width: 1050px) {
		.body_and_search {
			display: inherit;
			justify-content: space-between;
		}

		.search {
			width: 400px;
		}
	}
</style>

<script type="text/javascript">
	let colors = ["Белый", "Бежевый", "Голубой", "Синий", "Зеленый", "Красный", "Черный", "Оливкого-зеленый", "Серебристо-зеленый", "Темно-красный", "Темно-бородовый", "Темно-зеленый", "Темной-синий"];
	document.querySelector("#color").innerHTML = "<option>Choose color...</option>";
	for (let i = 0; i < colors.length; i++) {
		document.querySelector("#color").innerHTML += "<option>" + colors[i] + "</option>";
	}

	function like(src) {
		let a = src.split("/");
		let isLike = (a[4] == "redlike.png");

		if (isLike) {
			document.querySelector("#src").src = "like.png";
		} else {
			document.querySelector("#src").src = "redlike.png"
		}
	}

	let marks = ["Toyota", "Lexus", "BMW", "Mercedes-Benz", "Volvo", "Audi", "Cadillac", "Chevrolet", "Kia", "Hyundai", "Mazda", "Nissan", "Volkswagen"];
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

	let year = '';
	let model = '';
	let mark = '';
	let color = '';
	let price_from = '';
	let price_to = '';

	function selectYear() {
		let select = document.querySelector("#year");
		let getSelectText = select[select.selectedIndex].text;

		year = getSelectText;
	}

	document.querySelector("#mark").innerHTML = "<option selected class=\"option1\" value=\"-1\">Choose brand...</option>";
	for (let i = 0; i < marks.length; i++) {
		document.querySelector("#mark").innerHTML += "<option value=" + marks[i] + ">" + marks[i] + "</option>";
	}

	function selectMark() {
		let select = document.querySelector("#mark");
		let getSelectText = select[select.selectedIndex].text;

		mark = getSelectText;

		document.querySelector("#model").innerHTML = "<option class=\"option1\" value=\"-1\">Choose model...</option>";
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
	}

	function selectModel() {
		let select = document.querySelector("#model");
		let getSelectText = select[select.selectedIndex].text;
		model = getSelectText;
	}

	function selectColor() {
		let select = document.querySelector("#color");
		let getSelectText = select[select.selectedIndex].text;
		color = getSelectText;
	}

	function selectFrom() {
		let select = document.querySelector("#from").value;
		price_from = select;
	}

	function selectTo() {
		let select = document.querySelector("#to").value;
		price_to = select;
	}

	function fin() {
		document.querySelector("#finish_t").value = year;
		document.querySelector("#mark_t").value = mark;
		document.querySelector("#model_t").value = model;
		document.querySelector("#color_t").value = color;
		document.querySelector("#price_from").value = price_from;
		document.querySelector("#price_to").value = price_to;
	}

	setInterval(fin, 500);
</script>
<!-- <?php
	$mysqli = new mysqli('localhost', 'root', '', "kolesakz");
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

	$a->close();
	$b->close();
	$mysqli->close();
?> -->
</html>