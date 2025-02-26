<?php
    $connection = mysqli_connect('localhost', 'root', '', 'adidas');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./style/headerStyle.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:ital@1&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./ima/favicon.png">
    <title>ADIDAS</title>
</head>


<body>
    <header class="header">
        <div class="container">
            <div class="header__inner">

                <div class="logo" onclick="openMain(this)"> <a href="#"> <img src="./ima/logoadi.png"> </a> </div>

                <nav class="nav">
        

                    <div class="basket__icon" onclick="openBasket()">
                         <a href="#"><img  src="./ima/basket.png">
                            <div class="count__basket">0</div>
                        </a>
                    </div>

                    <a href="/addingPage.php" class="post_an_ad"><span class="span">ADD</span> <span class="plusSpan">+</span></a>
                    <a href="/editElementList.php" class="post_an_ad"><span class="span">DELETE</span> <span class="minusSpan">-</span> </a>
                    
                </nav>

            </div>
        </div>
    </header>

<?php
    require "basket.php";
?>

<script defer>
    countBasket();
    function countBasket(){
        
        let json = localStorage.getItem("basket");


        if(json){
            json = JSON.parse(json);
        }
        else{
            json = [];
        }

        if(json.length > 9){
            document.querySelector(".count__basket").innerHTML = 9 + "+";
        }
        else{
            document.querySelector(".count__basket").innerHTML = json.length;
        }
    }





    function openMain(event){
        window.location.href = "/";
        isInBasket();
    }

    function openBasket(){
        document.querySelector(".basketContainer").style.display = "flex";
        document.querySelector("body").style.overflow = "hidden";
        showBasket();
        countBasket();
    }

    function closeBasket(){
        
        document.querySelector(".basketContainer").style.display = "none";
        document.querySelector("body").style.overflow = "auto";
        countBasket();

        isInBasket();
        window.location.href = "/";
    }
</script>

<style>
    
    .plusSpan,
    .minusSpan{
        display: none;
    }

    @media screen and (max-width: 500px){
        .plusSpan,
        .minusSpan{
            display: inherit;
        }
    }


    .post_an_ad{
        margin-left:10px;
    }

</style>