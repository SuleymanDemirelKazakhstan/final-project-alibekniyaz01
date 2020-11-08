<?php
  require "config.php";
  if(isset($_GET['id'])){
      $topic =$_GET['id'];
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="css/header-style.css" />
    <link rel="stylesheet" href="css/element-style.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="scripts/element.js" defer></script>
    
  </head>
  <body>
    <?php 
      include "header.php"
    ?>

    <?php
      $result = mysqli_query($connection, "SELECT * FROM `announcement` WHERE id = " . $topic);      
      $photos = mysqli_query($connection, "SELECT * FROM `photo` WHERE idd = " . $topic);

      $res = mysqli_fetch_assoc($result);
      $link_row = mysqli_num_rows($photos);
      $row = mysqli_num_rows($result);

      for ($i = 0; $i < $link_row; $i++) {
        $link = mysqli_fetch_assoc($photos);
        $links[$i] = $link['src'];
      }

      $r = $res['modification'];
      $array = explode(" ", $r);

      $privod = $array[sizeof($array) - 2];
      $transmission = $array[sizeof($array) - 1];
      if ($transmission == "АТ") {
        $transmission = "Автомат";
      } else $transmission = "Механика";
      $kuzov = $array[0];
    ?>
    <title><?php echo $res['title']?></title>
    <div class="container">
      <div class="body">
        <a class="title_element"><?php echo $res['title']?></a><br>
        <div style="margin: 15px 0">
        <a style="font-size: 15px;">Announcement published <?php 
          $date = explode(("-"), $res['date']);
          echo $date[2].'.'.$date[1].'.'.$date[0];
        ?></a></div>
        <div id="block">
          <div class="images">
            <div class="">
              <img class="bigImage" src="<?php echo $links[0]?>">
            </div>
            <div class="images_main">
            <?php
              for ($i = 0; $i < $link_row; $i++) {
            ?>
              <img id="<?php echo $i;?>" onclick="bigImage(this.id)" class="main_images" src="<?php echo $links[$i];?>">
            <?php
            }
            ?>
            </div>
          </div>
          <div class="about_car">
            <div>
              <a style="padding-bottom: 50px" class="pricee"><?php echo $res['price']?> тг.</a>
            </div>
            <div class="div_about_car">
              <div class="contente">
                <a>Brand</a>
                <a><?php echo $res['brand']?></a>
              </div>
              <div class="contente">
                <a>Model</a>
                <a><?php echo $res['model']?></a>
              </div>
              <div class="contente">
                <a>Complectation</a>
                <a><?php echo $res['complectation']?></a>
              </div>
              <div class="contente">
                <a>Year</a>
                <a><?php echo $res['year']?></a>
              </div>
              <div class="contente">
                <a>Mileage</a>
                <a><?php echo $res['mileage']?> km.</a>
              </div>
              <div class="contente">
                <a>Color</a>
                <a><?php echo $res['color']?></a>
              </div>
              <div class="contente">
                <a>Privod</a>
                <a><?php echo $privod?></a>
              </div>
              <div class="contente">
                <a>Transmission</a>
                <a><?php echo $transmission?></a>
              </div>
              <div class="contente">
                <a>Kuzov</a>
                <a><?php echo $kuzov?></a>
              </div>
              <div class="contente">
                <a>Phone</a>
                <a><?php echo $res['phone']?></a>
              </div>
              <div class="contente">
                <a>E-mail</a>
                <a><?php echo $res['e-mail']?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="description" style="">
        <a style="margin-bottom: 20px">Description:</a>
        <?php echo "<a style='line-height: 2'>" . $res['about_car'] . '</a>';?>

      </div>
    </div>

    <?php 
      $result = mysqli_query($connection, "SELECT * FROM announcement ORDER BY RAND()");
      
    ?>
    <div class="container">
      <div class="interest">
          <a class="interest_title">Cars that may interest you</a>
          <div class="interest_car">
            <?php
              $count = 0;
              while ( $row = mysqli_fetch_assoc($result) ) {
                if ($count == 4) break;
                $count++;
                $img = mysqli_query($connection, "SELECT * FROM `photo` WHERE idd = " . $row['id']);
                $src_img = mysqli_fetch_assoc($img);
            ?>
            <div class="interest_car_content">
              <img class="interest_img" src="<?php echo $src_img['src'];?>">
              <div class="interest_car_title">
                <a class="interst_car_link" href="element.php?id=<?php echo $row['id']?>"><?php echo $row['title']?></a>
              </div>
            </div> 
            <?php
              }
            ?>
          </div>
      </div>
    </div>

    <?php
      include "footer.php";
    ?>

    <style type="text/css">
      .div_about_car {
        width: 350px; display: flex; justify-content: center; flex-wrap: wrap;
      }
      .description {
        margin-top: 50px; display: flex; flex-direction: column; width: 700px; border: 1px solid gray; padding: 20px
      }

      @media (max-width: 820px) {
        .bigImage {
          display: none;
        }
        .images_main {
          width: auto;
          display: flex;
          flex-wrap: wrap;
        }
        .main_images {
          width: 30%;
          height: auto;

          cursor: inherit;
        }
        .images {
          width: 100%;
        }
      }

      @media (max-width: 1170px) {
        .container {
          display: flex;
          flex-direction: column;
          align-items: center;
        }
        #block {
          display: flex;
          flex-direction: column;

          justify-content: center;
        }

        .interest {
          display: flex;
          flex-wrap: wrap;
        }

        .interest_car {
          width: auto;
        }

        .interest_car_content {
          width: auto;
        }

        .images {
          justify-content: center;
          display: flex;
          flex: auto;
          width: 100%;
        }
        .about_car {
          width: 100%;
        }

        .description {
          width: 90%;
        }
      }

      @media (max-width: 900px) {
        #block {
          align-items: center
        }
        .body {
          
        }

        .about_car {
          width: 70%;
        }

        .bigImage {
          width: 100%;
         
        }
        .images {
          margin: 5px 5px 0 5px;
        }

      }
    </style>
  </body>
</html>