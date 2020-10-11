let cars = [{ brand: 'Toyota', model: 'Camry', 'year': 1999, 'price': 20000, image_url: "https://media.ed.edmunds-media.com/toyota/camry/2016/ot/2016_toyota_camry_LIFE1_ot_902163_1280.jpg" },
{ brand: 'BMW', model: 'X6', year: 2014, price: 25000, image_url: "https://media.ed.edmunds-media.com/bmw/x6/2016/oem/2016_bmw_x6_4dr-suv_xdrive50i_fq_oem_5_1280.jpg" },
{ brand: 'Daewoo', model: 'Nexia', year: 2007, price: 15000, image_url: "https://s.auto.drom.ru/i24207/c/photos/fullsize/daewoo/nexia/daewoo_nexia_695410.jpg" },
{ brand: 'Daewoo', model: 'Nexia', year: 2007, price: 15000, image_url: "https://s.auto.drom.ru/i24207/c/photos/fullsize/daewoo/nexia/daewoo_nexia_695410.jpg" },
{ brand: 'Toyota', model: 'Camry', 'year': 1999, 'price': 20000, image_url: "https://media.ed.edmunds-media.com/toyota/camry/2016/ot/2016_toyota_camry_LIFE1_ot_902163_1280.jpg" },
{ brand: 'BMW', model: 'X6', year: 2014, price: 25000, image_url: "https://media.ed.edmunds-media.com/bmw/x6/2016/oem/2016_bmw_x6_4dr-suv_xdrive50i_fq_oem_5_1280.jpg" }];

/* Write your code here */
function addCards() {
    let divCars = document.querySelector('#cars');
    for (var i = 0; i < cars.length; i++) {
        var addCard = document.createElement('card');
        addCard.id = 'card';
        divCars.appendChild(addCard);
    }
}

function addDivInCards() {
    let cardOfCards = document.querySelector('#cars').getElementsByTagName('card');

    for (let i = 0; i < cars.length; i++) {
        var addDivInCard = document.createElement('div');
        addDivInCard.classList.add('card');
        addDivInCard.style.width = '150px';
        cardOfCards[i].appendChild(addDivInCard);
    }
}

let q = document.querySelector('#cars').getElementsByTagName('card');

function addImagesOfCars() {
    for (let i = 0; i < cars.length; i++) {
        var divForImageOfCar = q[i].getElementsByClassName('card');
        var addImageOfCar = document.createElement('img');
        addImageOfCar.src = cars[i].image_url;
        addImageOfCar.id = 'imaOfCar';
        addImageOfCar.classList.add('card');
        addImageOfCar.style.width = '150px';
        divForImageOfCar[0].appendChild(addImageOfCar);

    }
}

function addImagesOfBasket() {
    for (let i = 0; i < cars.length; i++) {
        var divForImageOfBasket = q[i].getElementsByClassName('card');
        var addImageOfBasket = document.createElement('img');
        addImageOfBasket.src = 'https://www.iconfinder.com/data/icons/interface-elements-iii-1/512/Basket-512.png';
        addImageOfBasket.classList.add('basket');
        addImageOfBasket.id = '' + i;
        addImageOfBasket.style.width = '40px';
        addImageOfBasket.style.marginTop = '5px';
        addImageOfBasket.style.marginRight = '-5px';
        divForImageOfBasket[0].appendChild(addImageOfBasket);
    }
}

function addNameOfCars() {
    for (let i = 0; i < cars.length; i++) {
        var nameOFCar = q[i].getElementsByClassName('card');
        var addNameOfCar = document.createElement('p');
        addNameOfCar.textContent = cars[i].brand + " " + cars[i].model;
        addNameOfCar.style.marginTop = '-5px';
        addNameOfCar.style.fontWeight = "1000";
        addNameOfCar.style.fontSize = '23px';
        nameOFCar[0].appendChild(addNameOfCar);
    }
}

addCards();
addDivInCards();
addImagesOfCars();
addImagesOfBasket();
addNameOfCars();

function clickFn(event) {
    var basket = event.currentTarget;
    var sourceOf$ = 'https://w7.pngwing.com/pngs/224/294/png-transparent-dollar-sign-currency-symbol-united-states-dollar-dollar-sign-text-logo-number.png';
    var sourceOfBasket = 'https://www.iconfinder.com/data/icons/interface-elements-iii-1/512/Basket-512.png';
    let item = document.getElementById('items');
    let price = document.getElementById('sum');

    if (basket.src === sourceOf$) {
        item.innerHTML = parseInt(item.innerHTML) - parseInt(1);
        price.innerHTML = parseInt(price.innerHTML) - parseInt(cars[basket.id].price);
        basket.src = sourceOfBasket;
    }
    else {
        item.innerHTML = parseInt(item.innerHTML) + parseInt(1);
        price.innerHTML = parseInt(price.innerHTML) + parseInt(cars[basket.id].price);
        basket.src = sourceOf$;
    }

}

for (let i = 0; i < cars.length; i++) {
    var basket = document.getElementById(i);
    basket.addEventListener('click', clickFn);
}