import mysql.connector

mydb = mysql.connector.connect(
    host="sjorso.no",
    user="sjurso_no_odb_measles",
    passwd="a3r4daXPrGP2jm",
    database="sjurso_no_odb_measles"
)

mycursor = mydb.cursor()
mycursor.execute('''SELECT * FROM M''')