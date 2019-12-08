var express = require("express"),
    uuid = require('uuid'),
    bodyParser = require('body-parser'),
    app = express(),
    server = require("http").createServer(app),
    path = require("path"),
    port = 8080,
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


app.get('/', function(req, res) {
  res.send(index.php);
  console.log("Hello");
});

app.post('/login', function(req, res) {
  console.log("Hello");
  res.send(adminload.php);
});

//Listen to the python program for data
pythonProcess.stdout.on('data', (data) => {
  console.log(data.toString())
});


