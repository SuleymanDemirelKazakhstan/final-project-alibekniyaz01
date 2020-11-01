const express = require('express');
const app = express();

app.get('/', function (req, res) {
    res.send('Hello World '.repeat(1000));
})
app.listen(3000);