const template = `<a href="/sport">Sport news</a> | <a href="/politics">Politic news</a><br/>
		<a href="/sport/json">Sport news (JSON)</a> | <a href="/politics/json">Politic news (JSON)</a><br/><br/>`;
let news = { "sport": ["C. Ronaldo has scored three goals in last five matches", "Golovkin has won match for title"], "politics": ["Trump has cancelled his visit to North Corea, because of sanction", "N. Nazarbayev has approved new version of alphabet"] };

const express = require('express');
const app = express();

app.get('/', (req, res) => {
	res.send(template);
});

app.get('/sport', (req, res) => {
	res.send(template + '<hr>' + news.sport[0] + '<hr>' + news.sport[1]);
});

app.get('/politics', (req, res) => {
	res.send(template + '<hr>' + news.politics[0] + '<hr>' + news.politics[1]);
});

app.get('/sport/json', (req, res) => {
	res.send(template + JSON.stringify(news.sport));
});
app.get('/politics/json', (req, res) => {
	res.send(template + JSON.stringify(news.politics));
});


app.listen(3000);