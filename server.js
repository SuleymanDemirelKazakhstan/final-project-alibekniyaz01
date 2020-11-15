var express = require('express');
var exphbs = require('express-handlebars');
var cookieParser = require('cookie-parser');



var app = express();
var hbs = exphbs.create();

app.engine('handlebars', hbs.engine);
app.set('view engine', 'handlebars');
app.use(cookieParser());

app.get('/', (req, res) => {
    let selCity = req.cookies['city'];

    if (!selCity) {
        res.render('form.handlebars');
    }
    else {
        res.send(`<body><p>Your city is ${selCity}</p></body>`);
    }

});

app.get('/setCity', (req, res) => {
    let city = req.query.city;
    res.cookie('city', city);
    res.send(`<body><p>${city}</p></body>`);
});

app.listen(3000);