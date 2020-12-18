<?php
    require "header.php";
    
    if(isset($_GET["addingBtn"])){
        $result = mysqli_query($connection, "INSERT INTO 
        products(`id`, `gender`, `category`, `name`, `price`) 
        VALUES (NULL,'".$_GET["gender"]."','".$_GET["category"]."','".$_GET["name"]."',".$_GET["price"].")");

        if($result){
            $res = mysqli_query($connection, "SELECT * FROM products");
            $lastId = 1;

            while($a = mysqli_fetch_assoc($res)){
                $lastId = $a["id"];
            }

            $result = mysqli_query($connection, "INSERT INTO `images`(`id`, `product_id`, `image_srces`) VALUES (NULL,".$lastId.",'".$_GET["src_img"]."')");
            
            ?>

            <script defer>
                window.location.href = "/addingPage.php";
            </script>

            <?php
        }
    }

?>



<link rel="stylesheet" href="./style/addingPageStyle.css">


    <section class="adding__section">
        <div class="section__form">

            <form action="" method = "get">

                <select name="" id="select1">
                    <option value="" disabled selected>Category</option>
                    <option value="">Clothes</option>
                    <option value="">Shoes</option>
                    <option value="">Accessories</option>
                </select>

                <input type="hidden" name="category" id="category">

                <select name="" id="select2">
                    <option value="" disabled selected>Gender</option>
                    <option value="">Men</option>
                    <option value="">Women</option>
                    <option value="">Kids</option>
                </select>

                <input type="hidden" name="gender" id="gender">


                <input type="text" placeholder="Name of product" id="name" name="name">
                <input type="number" placeholder="Price" id="price" name="price">

                <input type="src" placeholder="Source of images" id="src_img" name="src_img">

                <input type="submit" value="ADD" class="btn__add" style = "display: none;" id="addingBtn" name="addingBtn">
                <span class="btn__add nonactive">ADD</span>

            </form>
        </div>
    </section>

    <style>
        .nonactive{
            cursor: not-allowed;
            height: 29px;
            font-family:Arial;
            font-size: 20px;
            opacity: 0.7;
            display: flex;
            justify-content:center;
            align-items:center;
            user-select:none; 

        }
        .nonactive:hover{
            background-color: black;
            color: white;
        }
        .btn__add{
            display: flex;
            justify-content:center;
            align-items:center;
        }
    </style>


    <script defer>

        document.querySelector("#select1").onchange = function(){
            document.querySelector("#category").value = this[this.selectedIndex].text;
        }

        document.querySelector("#select2").onchange = function(){
            document.querySelector("#gender").value = this[this.selectedIndex].text;
        }

        setInterval(checkAddingForm, 500);

        function checkAddingForm(){
            if(document.querySelector("#category").value != "" &&
                document.querySelector("#gender").value != "" &&
                document.querySelector("#name").value != "" &&
                document.querySelector("#price").value != "" &&
                document.querySelector("#src_img").value != ""){
                    document.querySelector("#addingBtn").style.display = "inherit";
                    document.querySelector(".nonactive").style.display = "none";
            }else{
                document.querySelector("#addingBtn").style.display = "none";
                    document.querySelector(".nonactive").style.display = "inherit";
            }
        }

    </script>
