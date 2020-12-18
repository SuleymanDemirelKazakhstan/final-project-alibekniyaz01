<link rel="stylesheet" href="./style/editPageStyle.css">

<?php
    require "header.php";

    $delete = mysqli_query($connection, "DELETE FROM `products` WHERE id=".$_GET["id"]);
    $deleteImg = mysqli_query($connection, "DELETE FROM `images` WHERE product_id=".$_GET["id"]);

?>

<section class="section__editPage">
        <div class="editPage__form">

            <h1>PRODUCT SUCCESSFULLY DELETED</h1> 
            <a href="editElementList.php">BACK</a> 

        </div>
</section>

<script defer>
      function whenDeleted() {
        

        let id = <?php echo $_GET["id"];?>;

        let basket = localStorage.getItem('basket');

        basket = JSON.parse(basket);



        let json = [];

        for(let i=0;i<basket.length;i++){
            if(id != basket[i]["id"]){
                json[json.length] = basket[i];
            }
        }

        if(json.length == 0){
            localStorage.removeItem('basket');
        }
        else{
            localStorage.setItem('basket', JSON.stringify(json));

        }

        showBasket();
        countTotal();
        countBasket();
    }

    whenDeleted();
</script>