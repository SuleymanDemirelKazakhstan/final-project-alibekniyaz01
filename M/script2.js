let countries = ["Kazakhstan", "Russia", "England", "France", "Spain"];
let cities_by_country = {
    "Kazakhstan": ["Almaty", "Astana", "Shymkent"], "Russia": ["Moscow", "Saint-Petersburg", "Kazan"], "England": ["London", "Manchester", "Liverpool"], "France": ["Paris", "Lyon", "Marseille"],
    "Spain": ["Madrid", "Barcelona", "Seville", "Valencia", "Malaga"]
};
let selCountry = document.getElementById('countries');

function addCountries() {
    for (let i = 0; i < countries.length; i++) {
        var addCountry = document.createElement('option');
        addCountry.textContent = countries[i];
        addCountry.value = i;
        selCountry.appendChild(addCountry);
    }
}
addCountries();

function changeCities(event) {
    let selCities = document.querySelector('#cities');
    var countr = event.currentTarget.value;

    selCities.innerHTML = '';

    let empty = document.createElement('option');
    empty.textContent = 'Select city';
    selCities.appendChild(empty);

    let con = countries[countr];

    if (isNaN(countr)) {
        event.stopPropagation();
    }
    else {
        for (let city of cities_by_country[con]) {
            selCities.innerHTML = selCities.innerHTML + '<option>' + city + '</option>';
        }
    }
}

selCountry.addEventListener("change", changeCities);