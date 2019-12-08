from flask import Flask
import MeaslesReader as mr
app = Flask(__name__)

@app.route("/LoadData")
def hello():
    print("RUN")
    mr.LoadData()