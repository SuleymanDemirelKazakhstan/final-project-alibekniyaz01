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
    <!-- <div class="mainPage"> -->

    <header class="header">
        <div class="container">
            <div class="header__inner">

                <div class="logo" onclick="openMain(this)"> <a href="#"> <img src="./ima/logoadi.png"> </a> </div>

                <nav class="nav">
        

                    <div class="basket__icon">
                         <a href="#"><img onclick="" src="./ima/basket.png">
                            <div class="count__basket">0</div>
                        </a>
                    </div>


                    <a href="#" class="post_an_ad">+ <span>EDIT</span> </a>
                    
                </nav>

            </div>
        </div>
    </header>

<script defer>
    function openMain(event){
        window.location.href = "/";
    }
</script>