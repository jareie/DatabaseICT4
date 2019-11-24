import csv
csvfile = open('measles.csv')
reader = csv.DictReader(csvfile)


def CreateDate(String):
    output = []
    temporary = String.split("-")
    for i in temporary:
        output.append(int(i))
    return output

def FindOverlap(startDate1,endDate1,startDate2,endDate2):
    truths = [False,False,False]
    if startDate2[0] >= startDate1[0] and startDate2[0] <= endDate1[0]:
        truths[0] = True
    
    if startDate2[1] >= startDate1[1] and startDate2[1] <= endDate1[1]:
        truths[1] = True
    
    if startDate2[2] >= startDate1[2] and startDate2[2] <= endDate1[2]:
        truths[2] = True
    
    if truths[0] and truths[1] and truths[2]:
        return True


import mysql.connector

mydb = mysql.connector.connect(
    host="localhost",
    user="joel",
    passwd="test",
    database="Measles"
)

mycursor = mydb.cursor()
mycursor.execute("DROP TABLE DATA")
mycursor.execute('''CREATE TABLE DATA (
    ConditionName varchar(255),
    ConditionSNOMED int(255),
    PathogenName varchar(255),
    PathogenTaxonID varchar(255),
    Fatalities int(255),
    CountryName varchar(255),
    CountryISO varchar(255),
    Admin1Name varchar(255),
    Admin1ISO varchar(255),
    Admin2Name varchar(255),
    CityName varchar(255),
    PeriodStartDay int(255),
    PeriodStartMonth int(255),
    PeriodStartYear int(255),
    PeriodEndDay int(255),
    PeriodEndMonth int(255),
    PeriodEndYear int(255),
    PartOfCumulativeCountSeries BOOL,
    AgeRange varchar(255),
    Subpopulation varchar(255),
    PlaceOfAcquisition varchar(255),
    DiagnosisCertainty varchar(255),
    SourceName varchar(255),
    CountValue varchar(255)
    );''')
    
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
