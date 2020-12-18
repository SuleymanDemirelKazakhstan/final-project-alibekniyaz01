<?php
    require "header.php";

    $id = $_GET['id'];

    $product = mysqli_query($connection , "SELECT * FROM products WHERE id=".$id);

    $photos = mysqli_query($connection , "SELECT * FROM images WHERE product_id=".$id);

    $res = mysqli_fetch_assoc($product);

    $photo = mysqli_fetch_assoc($photos);
?>

<link rel="stylesheet" href="./style/elementPage.css">

<section class="section__element">
    <div class="container">
        <div class="element__container">

                <div class="element__left">
                    <div class="bigImage">
                        <img id="bigImage" src="<?php echo $photo["image_srces"] ?>"/>
                    </div>

                    <div class="thumb-img">

                            <div class="box " onclick="changeImage(this)">
                                <img src="<?php echo $photo["image_srces"]?>" alt="thumb">
                            </div>

                        <?php while($photo = mysqli_fetch_assoc($photos)) { ?>

                            <div class="box " onclick="changeImage(this)">
                                <img src="<?php echo $photo["image_srces"]?>" alt="thumb">
                            </div>

                        <? } ?>

                    </div>
                </div>

                <div class="element__right">
                    <div class="element__gender"><? echo $res["gender"] ?></div>
                    <div class="element__name"><? echo $res["name"] ?></div>
                    <div class="element__price">$<? echo $res["price"] ?></div>
                    <div class="add__to__basket">
                        <button class="btn__addtobasket" onclick = "addBasket(this)"> <span id="bas">ADD TO BASKET</span>
                         <span class="arrow">&#8594;</span>
                        </button>
                        <div class="alreadyInBasket">Already In Basket</div>
                    </div>
                </div>

        </div>
    </div>
</section>


<script defer>

    let basket = localStorage.getItem('basket');
    let id = <?php echo $res['id'];?>

            // console.log(id);

    if(basket){
        basket = JSON.parse(basket);

        for (let i = 0; i < basket.length; i++) {
                                        
            if(basket[i]["id"] == id){
                document.querySelector(".alreadyInBasket").style.display = "block";
                document.querySelector(".btn__addtobasket").style.display = "none";
                break;
            }

        }
    }
    else if(!basket){
        basket = [];
    }  

    <?php
        $photos = mysqli_query($connection, "SELECT * FROM images WHERE product_id=".$id);
        $photo = mysqli_fetch_assoc($photos);
    ?>

    let name = "<?php echo $res["name"];?>";
    let price = <?php echo $res['price'];?>;
    let bigIma = "<?php echo $photo["image_srces"]; ?>"; 
    let arr = {"name": name, "id": id, "price": price, "image":bigIma};        

    function  addBasket(event){
        let basket1 = localStorage.getItem('basket');

     

       

        document.querySelector(".alreadyInBasket").style.display = "block";
        document.querySelector(".btn__addtobasket").style.display = "none";
        // console.log();

        if (basket1) {
           basket1 = JSON.parse(basket1);
        }
        else{
            basket1 = [];
        }

        basket1[basket1.length] = arr;
        localStorage.setItem("basket", JSON.stringify(basket1));

        isInBasket();                         
        countBasket();  
    }  

    function isInBasket(){
        let basket1 = localStorage.getItem("basket");
        if(basket1){
            basket1 = JSON.parse(basket1);
        }
        else{
            basket1 = [];
        }

        for(let i=0;i<basket1.length;i++){
            if(basket1 == arr){
                document.querySelector(".alreadyInBasket").style.display = "block";
                document.querySelector(".btn__addtobasket").style.display = "none";
                console.log(4654);
                break;
            }
        }

        if(basket1.length == 0){
            document.querySelector(".alreadyInBasket").style.display = "none";
                document.querySelector(".btn__addtobasket").style.display = "block";
        }
       
    }
    isInBasket();


</script>

<script defer> // chande Image

    const thumbs = document.querySelector(".thumb-img").children;

    thumbs[0].classList.add("active");

    function changeImage(event) {
        document.getElementById("bigImage").src = event.children[0].src;

        for (const thumb of thumbs) {
            thumb.classList.remove("active");
        }
        event.classList.add("active");
    }

</script>

<style>
    /* .alreadyInBasket{

margin-top: 50px;
    } */

    .btn__addtobasket,
.alreadyInBasket{
    margin-top: 229px;

    cursor: pointer;

    max-width: 300px;

    width: 100%;
    height: 45px;

    display: flex;

    justify-content: space-between;
    align-items: center;

    padding: 10px 10px;

    user-select: none;

    border: 1px solid black;
    border-radius: 0;

    font-size: 15px;
    font-weight: 700;
    font-family:  Helvetica, Arial, sans-serif;

    /* display: block; */
}

.btn__addtobasket{
    display: block;
    background-color: black;
    color: white;
}
.alreadyInBasket{
    display: none;
    background-color: white;
    color: black;
}
</style>

<?php
    require "footer.php";
?>