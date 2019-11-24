const http = require('http');
const mysql = require('mysql');


const hostname = 'localhost';
const port = 3000;

const server = http.createServer((req, res) => {
  res.statusCode = 200;
  res.setHeader('Content-Type', 'text/plain');
  res.end('Hello, World!\n');
});

var con = mysql.createConnection({
    host: "localhost",
    user: "joel",
    password: "test",
    database: "Measles"
});

con.connect(function(err) {
    if (err) throw err;
    con.query("SELECT * FROM Location", function (err, result, fields) {
        if (err) throw err;
        console.log(result);
    });
});

server.listen(port, hostname, () => {
  console.log(`Server running at http://${hostname}:${port}/`);
});
