<?php
    require "config.php";
?>

<?php
  $rows = mysqli_query($connection, "SELECT COUNT(`islike`) FROM `announcement` WHERE `islike` = \"yes\"");
  $row = mysqli_fetch_array($rows);

  $like = mysqli_query($connection, "SELECT * FROM announcement WHERE `islike` = 'yes'");
  $result = mysqli_query($connection, "SELECT * FROM photo");

  $al = mysqli_query($connection, "SELECT COUNT(`id`) FROM announcement");
  $all = mysqli_fetch_row($al);
  $all = $all[0];
?>
<header class="header">
    <div class="container">

        <div id="about">
            <div class="cars">
                <span> <a href="index.php">Cars</a> </span>
                <span> <a href="sell.php">Sell a car</a> </span>
            </div>
            <div class="fdsa">
                <div>
                    <a class="all_announcement" href="/all.php">Edit ad (<?php echo $all;?>)</a>
                </div>
                <div class="like">
                    <img id="like" onclick="open_basket()" src="images/whitelike.png" alt="" />
                    <span class="count__like"><a><?php echo $row[0];?></a></span>
                </div>
            </div>
        </div>
    </div>
    <div id="basket" class="display_close" style="">
        <div class="title_basket">
            <div class="bas">
                <a class="asdf">
                Favorites
                </a>
                <div onclick="close_basket()" style="cursor: pointer;">
                    <img class="close_icon" src="images/close.png">
                </div>
            </div>
            <div class="basket_content">
                <?php 
                    while( $res = mysqli_fetch_assoc($like) ) {
                        $result = mysqli_query($connection, "SELECT * FROM photo WHERE idd = " . $res['id']);
                        $link = mysqli_fetch_assoc($result); 
                ?>
                <div class="content_basket" style="">
                    <div class="image__content">
                        <img src="<?php echo $link['src']; $cat[""]?>">
                    </div>
                    <div class="about__car">
                        <div class="title__content_basket">
                            <span class="fapweoruf">
                                <a href="element.php?id=<?php echo $res['id'];?>" class="a"><?php echo $res['title'];?></a>
                            </span>
                            <a class="a"><?php echo $res['year']?></a>
                            <span class="fapweoruf">
                                <a class="b"><?php echo $res['mileage']?> км. <?php echo $res['modification']?></a>
                            </span>
                        </div>
                    </div>
                    <div class="like__and__price">
                            <img onclick="like(this.src)" src="
                            <?php
                                if ($res['like'] == "no") {
                                    echo "images/like.png";
                                } else if ($res['like'] == "yes") {
                                    echo "images/redlike.png";
                                }
                            ?>">
                        <div class="price"><?php echo $res['price']?> тг</div>
                    </div>
                </div>
        <?php } ?>
            </div>
        </div>
    </div>
    
    
    <script type="text/javascript" src="scripts/header.js" defer></script>
</header>
<div id="back" class="" style="">
        
    </div>

<style type="text/css">
    a {
        transition: .1s linear;
    }
    .all_announcement {
        text-decoration: none;
        color: white;
        opacity: .7;
    }

    .all_announcement:hover {
        opacity: 1;
    }

.title__content_basket {
    display: flex;
    flex-direction: column;

    color: black;
}

.content_basket {
    margin-top: 30px;

    width: 90%;
    height: 150px;

    border: 1px solid gray;

    display: flex;
    justify-content: space-between;

    margin-left: 40px;
}

.bas {
    position: relative;

    width: 100%;
    height: 70px;

    background-color: gray;

    display: flex;
    justify-content: space-between;
    align-items: center;
}

.background_close {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 1000;

    width: 100%;
    height: 100%;

    background-color: black;
    opacity: .5;
}

.basket {
    position: absolute;
    right: 0;
    top: 0;
    z-index: 10000;

    width: 100%;
    height: 1000%;

    overflow: auto;

    background-color: white;

    justify-content: center;
}

.display_close {
    width: 100%;
    display: none;
}

.title_basket { 
    position: absolute;

    background-color: white;

    width: 100%;

    padding-bottom: 30px;
}

.asdf {
    margin-left: 20px;

    color: white;

    font-size: 25px;
}

.close_icon {
    width: 30px;

    margin-right: 20px;
} 

.fdsa {
    display: flex;
    justify-content: space-between;
    width: 60%;
}

@media (max-width: 900px) {
    #about {
        flex-direction: column;
        justify-content: center;
    }
    .fdsa {
        width: 100%;
    }

    .content_basket {
        width: 90%;

        margin: 5px;

        justify-content: flex-start;
    }

    .image__content {
        margin: 0;
    }

}

@media (max-width: 1170px) {
    .container {
        padding: 0 30px;
    }

    .cars {
        font-size: 18px;
    }  

    #about {
        height: 80px;
    }  

    .header {
        height: 85px;
    }

    .about {
        height: 100px;
    }

    .all_announcement {
        font-size: 18px;
    }

    .count__like {
        font-size: 18px;
    }

    #like {
        width: 35px;
        height: 30px;
    }
}

@media (max-width: 700px) {
    .content_basket {
        display: inherit;
        height: 300px;
    }

    .image__content {
        display: flex;
        justify-content: center;
    }

    .like__and__price {
        display: flex;
        justify-content: space-between;
    }

    .price {
        padding: 0 10px 0 0;
        display: flex;
        align-items: center;
    }
}

@media (max-width: 500px) {
    #about400 {
        background-color: red;
        display: none;
    }

    .cars400 {
        display: none;
    }

    .fapweoruf {
        display: flex;
        flex-wrap: wrap;
    }
}
</style>