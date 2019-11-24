var express = require("express"),
    uuid = require('uuid'),
    bodyParser = require('body-parser'),
    app = express(),
    server = require("http").createServer(app),
    path = require("path"),
    port = 8080,
    mysql = require('mysql'),
    spawn = require("child_process").spawn;

//Spawn Python Process. Meaning SQL can be run in separate process
const pythonProcess = spawn('python',["Browser/Printer.py"]);

const sessionId = uuid.v4();

server.listen(port)
console.log(Date.now() + " : Server running on http://localhost:"+port+"/");

app.use(bodyParser.urlencoded({     // to support URL-encoded bodies
  extended: true
})); 
app.use(bodyParser.json() ); // to support JSON-encoded bodies
app.use(express.static(path.join(__dirname, 'public')));

//Creation of the server
app.post('/', function(req, res) {
  console.log("Hello");
});

app.post('/login', function(req, res) {
  console.log("Hello");
  res.send(index.html);
});

//Listen to the python program for data
pythonProcess.stdout.on('data', (data) => {
  console.log(data.toString())
});

//Connect to the database
var con = mysql.createConnection({
  host: "localhost",
  user: "joel",
  password: "test",
  database: "Measles"
});

//Query on the database
/*con.connect(function(err) {
  if (err) throw err;
  con.query("SELECT * FROM Location", function (err, result, fields) {
      if (err) throw err;
      console.log(result);
  });
});*/

