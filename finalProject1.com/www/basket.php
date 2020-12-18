<link rel="stylesheet" href="./style/basketStyle.css">
<div class="basketContainer">
<section class="Basket__Section">

    <div class="close" onclick="closeBasket()"><span>&#88;</span></div>

    <div class="text__basket">BASKET</div>


    <div class="cards"></div>
    

    <div class="basket__total">
        <div class="text__total">Total: </div>

        <div class="total">$ <span id="basket_total">0</span></div>
    </div>

</section>
</div>

<style>
    .basketContainer{
    width: 100%;
    height: 100vh;

    display: none;
    justify-content: flex-end;

    /* border: 2px solid blue; */

    position: absolute;

    background:rgba(0,0,0,.7);
    
    }

    .Basket__Section{
        background-color: white;
        overflow: auto;
    }

</style>

<script defer>

    function countTotal() {
        var prices = document.querySelectorAll("#item__price");

        var total = 0;

        for (const price of prices) {
            total += parseInt(price.textContent);
        }

        var basket_total = document.querySelector("#basket_total");

        basket_total.textContent = total;
    }

    function removeItem(event) {
        // console.log(event.parentNode);

        // event.parentNode.classList.remove("item__container");
        // event.parentNode.innerHTML = "";

        let id = event.querySelector("input").value;
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
        isInBasket();
        countBasket();
    }

    showBasket();

    function showBasket(){
        let basket = localStorage.getItem('basket');

        if(basket){
            basket = JSON.parse(basket);
        }
        else{
            basket = [];
        }

        let template = "";

        for(let i=0;i<basket.length;i++){
            // console.log(basket[i]);
            template += `
                <div class="item__container">

                <div class="remove__item" onclick="removeItem(this)">&#88; <input type="hidden" value = "`+ basket[i]["id"] +`"></div>

                <img class="item__Img"
                    src="`+ basket[i]["image"] +`">

                <div class="item__content">
                    <div class="item__name">`+  basket[i]["name"] +`</div>
                    <div class="item__price">$ <span id="item__price">`+  basket[i]["price"] +`</span> </div>
                </div>

                </div>`;
        }
        // console.log(basket.length);

        document.querySelector(".cards").innerHTML = template;
        countTotal();
        
    }

    countTotal();

</script>