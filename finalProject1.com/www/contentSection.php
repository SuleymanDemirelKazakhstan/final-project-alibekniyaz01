<link rel="stylesheet" href="./style/contentSectionStyle.css">

<div class="filter">
    <div class="container">

        <div class="text_cotegory">
            <h1> ALL PRODUCTS </h1>
        </div>

        <div class="filter_inner">
            <form action="">
                <div class="options">

                    <select name="" id="" onchange = filterGender(this)>
                       <option  selected>GENDER</option>
                       <option value="">Men</option>
                       <option value="">Women</option>
                       <option value="">Kids</option>
                    </select>

                    <select name="" id="" onchange = filterCategory(this)>
                        <option  selected>CATEGORY</option>
                        <option value="">Clothes</option>
                        <option value="">Shoes</option>
                        <option value="">Accessories</option>
                    </select>

                </div>
            </form>
        </div>

    </div>

    <script defer>
                let gender = "";
                let category = "";

                function filterGender(event){
                    gender = event[event.selectedIndex].text;

                    if(gender == "GENDER"){
                        gender = "";
                    }

                    filter();
                }

                function filterCategory(event){
                    category = event[event.selectedIndex].text;

                    if(category == "CATEGORY"){
                        category = "";
                    }

                    filter();
                }

                function filter(){
                    document.querySelector(".Content__Container").innerHTML = "";

                    fetch("products.php").then(data => data.json()).then(data => {

                        fetch("images.php").then(photo => photo.json()).then(photo => {
                            let photos = [];

                            for (let i = 0; i < data.length; i++) {
                                for (let j = 0; j < photo.length; j++) {
                                    
                                    if (data[i]['id'] == photo[j]['product_id']){
                                        photos[photos.length] = photo[j]['image_srces'];
                                        break;
                                    }
                                }

                            }

                            let template = "";
                            if(gender != "" && category != ""){
                                for(let i=0;i<data.length;i++){
                                    if(data[i]['gender'] == gender && data[i]['category'] == category){
                                        template += `
                                        <div class="card__container" onclick = "openCard(this)">
                                            <a href="#">
                                                <div class="card__img">
                                                     <img src="`+photos[i]+`">
                                                 </div>

                                                 <input type="hidden" value="`+ data[i]["id"] +`">

                                                <div class="card__content">

                                                    <div class="nameOfProduct">`+data[i]['name']+`</div>

                                                    <div class="priceOfProduct"> $<span id="priceOfProduct">`+data[i]['price']+`</span></div>

                                                </div>
                                            </a>
                                        </div>`;
                                    }

                                }

                                document.querySelector(".text_cotegory h1").innerHTML = gender + " PRODUCTS";
                            }

                            else if(gender != "" && category == ""){
                                for(let i=0;i<data.length;i++){
                                    if(data[i]['gender'] == gender){
                                        template += `
                                        <div class="card__container" onclick = "openCard(this)">
                                            <a href="#">
                                                <div class="card__img">
                                                     <img src="`+photos[i]+`">
                                                 </div>

                                                 <input type="hidden" value="`+ data[i]["id"] +`">

                                                <div class="card__content">

                                                    <div class="nameOfProduct">`+data[i]['name']+`</div>

                                                    <div class="priceOfProduct"> $<span id="priceOfProduct">17000</span></div>

                                                </div>
                                            </a>
                                        </div>`;
                                    }

                                }

                                document.querySelector(".text_cotegory h1").innerHTML = gender + " PRODUCTS";
                            }

                            else if(gender == "" && category != ""){
                                for(let i=0;i<data.length;i++){
                                    if(data[i]['category'] == category){
                                        template += `
                                        <div class="card__container" onclick = "openCard(this)">
                                            <a href="#">
                                                <div class="card__img">
                                                     <img src="`+photos[i]+`">
                                                 </div>

                                                 <input type="hidden" value="`+ data[i]["id"] +`">

                                                <div class="card__content">

                                                    <div class="nameOfProduct">`+data[i]['name']+`</div>

                                                    <div class="priceOfProduct"> $<span id="priceOfProduct">17000</span></div>

                                                </div>
                                            </a>
                                        </div>`;
                                    }

                                }
                            }

                            else{
                                for(let i=0;i<data.length;i++){
                                    if(true){
                                        template += `
                                        <div class="card__container" onclick = "openCard(this)">
                                            <a href="#">
                                                <div class="card__img">
                                                     <img src="`+photos[i]+`">
                                                 </div>

                                                 <input type="hidden" value="`+ data[i]["id"] +`">

                                                <div class="card__content">

                                                    <div class="nameOfProduct">`+data[i]['name']+`</div>

                                                    <div class="priceOfProduct"> $<span id="priceOfProduct">17000</span></div>

                                                </div>
                                            </a>
                                        </div>`;
                                    }

                                }

                            
                                document.querySelector(".text_cotegory h1").innerHTML = "ALL" + " PRODUCTS";
                            }

                       
                            for (let index = 0; index < 3; index++) {
                                     template += `
                                    <div class="card__container f">

                                        <div class="card__img">
                                            <img src="./ima/hoodie.jpg">
                                        </div>

                                        <div class="card__content">

                                            <div class="nameOfProduct">Real Madrid training top</div>

                                            <div class="priceOfProduct"> <span id="priceOfProduct">17000</span> tenge </div>

                                        </div>

                                    </div>`;
                                }

                            document.querySelector(".Content__Container").innerHTML = template;
                        });

                    });

                    
                }


    </script>
</div>

<section class="Content">
            <div class="container">
                <div class="Content__Container">

                    <?php
                        $result = mysqli_query($connection, "SELECT * FROM products");		
                        $image_link = mysqli_query($connection, "SELECT * FROM images");
                        $rows = mysqli_num_rows($result);
                        $rows_photo = mysqli_num_rows($image_link);
                        for ($i = 0; $i < $rows; $i++) {
                            $row = mysqli_fetch_row($result);
                            $image_link = mysqli_query($connection, "SELECT * FROM images WHERE product_id=" . $row[0]);
                            for ($j = 0; $j < $rows_photo; $j++) {
                                $row_photo = mysqli_fetch_row($image_link);
                                if ($row_photo[1] == $row[0]){
                                    $photo[$i] = $row_photo[2];
                                    break;
                                }

                            }}

                        $result = mysqli_query($connection, "SELECT * FROM `products`");
                        
                        $i = 0;

                        while ($res = mysqli_fetch_assoc($result)){
                    ?>

                    <div class="card__container" onclick="openCard(this)">
                        <a href="#">
                            <div class="card__img">
                                <img src="<?php echo $photo[$i] ?>">
                            </div>

                            <input type="hidden" value="<?php echo $res['id'];?>" >

                            <div class="card__content">

                                <div class="nameOfProduct"><?php echo $res['name'];?></div>

                                <div class="priceOfProduct"> $<span id="priceOfProduct"><?php echo $res['price'];?></span></div>

                            </div>
                        </a>
                    </div>

                     <?php
                        $i++;
                        }
                     ?> 

                     <!-- script of open card -->

                     <script defer>
                        function openCard(event){
                            window.location.href = "/elementPage.php?id=" + event.querySelector("input").value;
                        }
                     </script>

                    <!-- ------------------------------------------------------------------------------ -->

                    <div class="card__container f">

                        <div class="card__img">
                            <img src="./ima/hoodie.jpg">
                        </div>

                        <div class="card__content">

                            <div class="nameOfProduct">Real Madrid training top</div>

                            <div class="priceOfProduct"> <span id="priceOfProduct">17000</span> tenge </div>

                        </div>

                    </div>
                    <div class="card__container f">

                        <div class="card__img">
                            <img src="./ima/hoodie.jpg">
                        </div>

                        <div class="card__content">

                            <div class="nameOfProduct">Real Madrid training top</div>

                            <div class="priceOfProduct"> <span id="priceOfProduct">17000</span> tenge </div>

                        </div>

                    </div>
                    <div class="card__container f">

                        <div class="card__img">
                            <img src="./ima/hoodie.jpg">
                        </div>

                        <div class="card__content">

                            <div class="nameOfProduct">Real Madrid training top</div>

                            <div class="priceOfProduct"> <span id="priceOfProduct">17000</span> tenge </div>

                        </div>

                    </div>

                    <!-- ---------------------------------------------------------------------------------------- -->
                </div>
            </div>
</section>