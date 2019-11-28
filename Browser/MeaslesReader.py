import csv
csvfile = open('Browser/measles.csv')
reader = csv.DictReader(csvfile)


def CreateScript(filePath):
    fileoutput = open(filePath).readlines()

    statements = []
    temporary = ""
    for i in fileoutput:
        if i.replace(" ","")[0] == "#":
            continue
        temp = i.replace("\n","")
        if len(temp) == 0:
            continue
        if temp.replace(" ","")[0] == "-":
            if temporary == "":
                continue
            statements.append(temporary)
            temporary = ""
            continue
        temporary += temp
    return statements


Database = CreateScript("Browser/Measles.sql")
#print(Database)

Scripts = CreateScript("Browser/SQLQueries")

'''
for i in statements:
    print("----------------")
    print(i)
#print(statements)
import sys
sys.exit(0)
'''

import mysql.connector

Databases = [
    "CREATE DATABASE IF NOT EXISTS `RawDataMeasles` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "CREATE DATABASE IF NOT EXISTS `CleanedDataMeasles` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "CREATE DATABASE IF NOT EXISTS `Measles` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
]

mydb = mysql.connector.connect(
    host="localhost",
    user="joel",
    passwd="test"
)
mycursor = mydb.cursor()
for i in Databases:
    try:
        mycursor.execute(i)
        mydb.commit()
    except mysql.connector.Error as err:
        print(err)
mycursor.close()
mydb.close()

#-----------------------------------


nydb = mysql.connector.connect(
    host="localhost",
    user="joel",
    passwd="test",
    database="RawDataMeasles"
)
nycursor = nydb.cursor()
try:
    nycursor.execute("DROP TABLE IF EXISTS `DATA`;"
        "CREATE TABLE IF NOT EXISTS `DATA` ("
        "`ConditionName` varchar(255) DEFAULT NULL,"
        "`ConditionSNOMED` int(255) DEFAULT NULL,"
        "`PathogenName` varchar(255) DEFAULT NULL,"
        "`PathogenTaxonID` varchar(255) DEFAULT NULL,"
        "`Fatalities` int(255) DEFAULT NULL,"
        "`CountryName` varchar(255) DEFAULT NULL,"
        "`CountryISO` varchar(255) DEFAULT NULL,"
        "`Admin1Name` varchar(255) DEFAULT NULL,"
        "`Admin1ISO` varchar(255) DEFAULT NULL,"
        "`Admin2Name` varchar(255) DEFAULT NULL,"
        "`CityName` varchar(255) DEFAULT NULL,"
        "`PeriodStartDay` int(255) DEFAULT NULL,"
        "`PeriodStartMonth` int(255) DEFAULT NULL,"
        "`PeriodStartYear` int(255) DEFAULT NULL,"
        "`PeriodEndDay` int(255) DEFAULT NULL,"
        "`PeriodEndMonth` int(255) DEFAULT NULL,"
        "`PeriodEndYear` int(255) DEFAULT NULL,"
        "`PartOfCumulativeCountSeries` tinyint(1) DEFAULT NULL,"
        "`AgeRange` varchar(255) DEFAULT NULL,"
        "`Subpopulation` varchar(255) DEFAULT NULL,"
        "`PlaceOfAcquisition` varchar(255) DEFAULT NULL,"
        "`DiagnosisCertainty` varchar(255) DEFAULT NULL,"
        "`SourceName` varchar(255) DEFAULT NULL,"
        "`CountValue` varchar(255) DEFAULT NULL"
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8",multi=True)
except nysql.connector.Error as err:
    print(err)
nydb.commit()
nycursor.close()
nydb.close()




import sys
sys.exit(1)

#=============================================================
nydb = mysql.connector.connect(
    host="localhost",
    user="joel",
    passwd="test",
    database="Mea"
)
nycursor = nydb.cursor()

for i in Database[3:]:
    nycursor.execute(i,multi=True)
nydb.commit()


'''
for row in reader:
    PeriodStart = row["PeriodStartDate"].split("-")
    PeriodStartDay = PeriodStart[2]
    PeriodStartMonth = PeriodStart[1]
    PeriodStartYear = PeriodStart[0]
    #print(PeriodStart)
    PeriodEnd = row["PeriodEndDate"].split("-")
    PeriodEndDay = PeriodEnd[2]
    PeriodEndMonth = PeriodEnd[1]
    PeriodEndYear = PeriodEnd[0]
    #print(PeriodEnd)

    string = "'" + row["ConditionName"] + "', " + row["ConditionSNOMED"] + ", '" + row["PathogenName"] + "', '" + row["PathogenTaxonID"] + "', " + row["Fatalities"] + ", '" + row["CountryName"] + "', '" + row["CountryISO"] + "', '" + row["Admin1Name"] + "', '" + row["Admin1ISO"] + "', '" + row["Admin2Name"] + "', '" + row["CityName"] + "', " + PeriodStartDay + ", " + PeriodStartMonth + ", " + PeriodStartYear + ", " +  PeriodEndDay + ", " + PeriodEndMonth + ", " + PeriodEndYear + ", " + row["PartOfCumulativeCountSeries"] + ", '" + row["AgeRange"] + "', '" + row["Subpopulation"] + "', '" + row["PlaceOfAcquisition"] + "', '" + row["DiagnosisCertainty"] + "', '" + row["SourceName"] + "', " + row["CountValue"] + ""
    #print(string)
    mycursor.execute('INSERT INTO DATA(ConditionName,ConditionSNOMED,PathogenName,PathogenTaxonID,Fatalities,CountryName,CountryISO,Admin1Name,Admin1ISO,Admin2Name,CityName,PeriodStartDay,PeriodStartMonth,PeriodStartYear,PeriodEndDay,PeriodEndMonth,PeriodEndYear,PartOfCumulativeCountSeries,AgeRange,Subpopulation,PlaceOfAcquisition,DiagnosisCertainty,SourceName,CountValue) VALUES(' + string + ');')
    #break

mydb.commit()
'''
'''for i in Scripts:
    nycursor.execute(i,multi=True)
nydb.commit()'''