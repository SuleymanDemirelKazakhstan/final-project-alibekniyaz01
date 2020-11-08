<?php
	require "config.php";
	mysql_set_charset('utf8');
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/header-style.css">
	<link rel="icon" href="images/icon.png">
	<script type="text/javascript" src="scripts/index.js" defer></script>
	<title>Edit ads</title>
</head>
<body>

	<?php require "header.php"?>

	<?php 
		$res = mysqli_query($connection, "SELECT * FROM announcement");
		$photo = mysqli_query($connection, "SELECT * FROM photo");
	?>

	<div class="container">
		<?php 
		$count = 0;
		while($result = mysqli_fetch_assoc($res)){		
			$photo = mysqli_query($connection, "SELECT * FROM photo WHERE idd=" . $result['id']);	
			while( $link = mysqli_fetch_assoc($photo) ) {
				if ( $link['idd'] == $result['id']) {
					$link[$count] = $link['src'];
					break;
				}
			}
		?>
		<div class="content">
			
			<div class="image__content">
				<img src="<?php echo $link[$count];?>">
			</div>

			<div class="about__car">
				<div class="title__content">
					<a href="element.php?id=<?php echo $result['id'];?>" class="a"><?php echo $result['title'];?></a>
					<a class="a"><?php echo $result['year']?></a>
					<a class="b"><?php echo $result['mileage']?> km. <?php echo $result['modification']?></a>
				</div>
			</div>
				
			<div class="like__and__price">
				<div class="price"><?php echo $result['price']?> тг</div>
				<div>
					<a class="edit" href="edit.php?id=<?php echo $result['id']?>">Edit</a>
				</div>
			</div>
		</div>	
		<?php 
		$count++;
	}
	?>
	</div>

	<?php require "footer.php"?>
</body>

<style type="text/css">
	.edit {
		text-decoration: none;
		color: gray;
		transition: .1s linear;
	}
	.edit:hover {
		color: black;
	}

	@media screen and (max-width: 500px) {
  		
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

	@media (max-width: 900px) {

	}
</style>
</html>