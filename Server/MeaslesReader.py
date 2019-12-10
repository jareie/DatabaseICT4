import csv
csvfile = open('measles.csv')
reader = csv.DictReader(csvfile)


import mysql.connector

mydb = mysql.connector.connect(
    host="localhost",
    user="joel",
    passwd="test",
    database="measles"
)
mycursor = mydb.cursor()

amount = 50000000
count = 0
for row in reader:
    '''PeriodStart = row["PeriodStartDate"].split("-")
    PeriodStartDay = PeriodStart[2]
    PeriodStartMonth = PeriodStart[1]
    PeriodStartYear = PeriodStart[0]
    #print(PeriodStart)
    PeriodEnd = row["PeriodEndDate"].split("-")
    PeriodEndDay = PeriodEnd[2]
    PeriodEndMonth = PeriodEnd[1]
    PeriodEndYear = PeriodEnd[0]'''
    #print(PeriodEnd)

    string = "'" + row["ConditionName"] + "', " + row["ConditionSNOMED"] + ", '" + row["PathogenName"] + "', '" + row["PathogenTaxonID"] + "', " + row["Fatalities"] + ", '" + row["CountryName"] + "', '" + row["CountryISO"] + "', '" + row["Admin1Name"] + "', '" + row["Admin1ISO"] + "', '" + row["Admin2Name"] + "', '" + row["CityName"] + "', '" + row["PeriodStartDate"] + "', '" + row["PeriodEndDate"] + "', " + row["PartOfCumulativeCountSeries"] + ", '" + row["AgeRange"] + "', '" + row["Subpopulation"] + "', '" + row["PlaceOfAcquisition"] + "', '" + row["DiagnosisCertainty"] + "', '" + row["SourceName"] + "', " + row["CountValue"] + ""
    #print(string)
    mycursor.execute('INSERT INTO data (ConditionName,ConditionSNOMED,PathogenName,PathogenTaxonID,Fatalities,CountryName,CountryISO,Admin1Name,Admin1ISO,Admin2Name,CityName,PeriodStartDate,PeriodEndDate,PartOfCumulativeCountSeries,AgeRange,Subpopulation,PlaceOfAcquisition,DiagnosisCertainty,SourceName,CountValue) VALUES(' + string + ');')
    
    count += 1
    if count >= amount:
        break

mydb.commit()
mycursor.close()
mydb.close()

'''

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