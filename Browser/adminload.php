<HTML>
<head>
<title>.p-.</title>
</head>
<body>
<nav>
  <ul>
    <li><a href="index.php"><strong>Home</strong></li>
    <li><a href="standarduser.php">Standard User</a></li>
    <li><a href="standardadmin.php">Standard Admin</a></li>
    <li><a href="adminload.php">Admin loading</a></li>
    <li><a href="nodejs.html">nodeJS</a></li>
    <li><a href="mongodb.html">MongoDB</a></li>
  </ul>
</nav>

	<form name="queryInput" action="adminload.php" method="POST">
			<input name ="createDb" type="submit" value="Create Database">
			<input name ="loadData" type="submit" value="Load Data">
			<input name ="submit" type="submit" value="Clean Rawdata">
			<input name ="fill" type="submit" value="Time">
			<input name ="Sick" type="submit" value="Condition table">
			<input name ="Loc" type="submit" value="Location table">
			<input name ="Report" type="submit" value="Reports table">
			<input name ="createadb" type="submit" value="Create ADB">
			<input name ="insertadb" type="submit" value="Add data to ADB">
		</form>
		
		
			<?php
			// Create connection
			$servername = "localhost";
			$username = "joel";
			$password = "test";
			$conn = new mysqli($servername, $username, $password);
			
			
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			echo "<p><font color=\"red\">Connected successfully</font></p>";
			
if(isset($_POST['createDb'])){
$sqlLi = array(
"CREATE DATABASE IF NOT EXISTS `measles` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
"CREATE DATABASE IF NOT EXISTS `measlesodb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
"USE measles",
"DROP TABLE IF EXISTS data",
"CREATE TABLE IF NOT EXISTS data (
  ConditionName varchar(255) DEFAULT NULL,
  ConditionSNOMED int(11) DEFAULT NULL,
  PathogenName varchar(255) DEFAULT NULL,
  PathogenTaxonID varchar(255) DEFAULT NULL,
  Fatalities int(11) DEFAULT NULL,
  CountryName varchar(255) DEFAULT NULL,
  CountryISO varchar(255) DEFAULT NULL,
  Admin1Name varchar(255) DEFAULT NULL,
  Admin1ISO varchar(255) DEFAULT NULL,
  Admin2Name varchar(255) DEFAULT NULL,
  CityName varchar(255) DEFAULT NULL,
  PeriodStartDay int(11) DEFAULT NULL,
  PeriodStartMonth int(11) DEFAULT NULL,
  PeriodStartYear int(11) DEFAULT NULL,
  PeriodEndDay int(11) DEFAULT NULL,
  PeriodEndMonth int(11) DEFAULT NULL,
  PeriodEndYear int(11) DEFAULT NULL,
  PartOfCumulativeCountSeries tinyint(1) DEFAULT NULL,
  AgeRange varchar(255) DEFAULT NULL,
  Subpopulation varchar(255) DEFAULT NULL,
  PlaceOfAcquisition varchar(255) DEFAULT NULL,
  DiagnosisCertainty varchar(255) DEFAULT NULL,
  SourceName varchar(255) DEFAULT NULL,
  CountValue varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8"
);

$arrlength = count($sqlLi);
for($x = 0; $x < $arrlength; $x++) {
    if($conn->query($sqlLi[$x]) == FALSE) {
	echo "Error: " . $conn->error;
    }
}

}

if(isset($_POST['loadData'])){
//require dirname(__FILE__) . "/MeaslesReader.py";
//echo "python " . dirname(__FILE__) . "/MeaslesReader.py";
	//popen("MeaslesReader.py","r");

echo "Hello";
}


			if(isset($_POST['submit'])){
			
			// Generate sql
			$sqlLi = array(
"USE measles",
"DROP TABLE IF EXISTS `cleaneddata`;",
"CREATE TABLE IF NOT EXISTS `cleaneddata` (
  `ConditionName` varchar(255) NOT NULL,
  `ConditionSNOMED` int(11) NOT NULL,
  `PathogenName` varchar(255) NOT NULL,
  `PathogenTaxonID` varchar(255) NOT NULL,
  `Fatalities` int(11) NOT NULL,
  `CountryName` varchar(255) NOT NULL,
  `CountryISO` varchar(255) NOT NULL,
  `Admin1Name` varchar(255) NOT NULL,
  `Admin1ISO` varchar(255) NOT NULL,
  `Admin2Name` varchar(255) NOT NULL,
  `CityName` varchar(255) NOT NULL,
  `PeriodStartDay` int(11) NOT NULL,
  `PeriodStartMonth` int(11) NOT NULL,
  `PeriodStartYear` int(11) NOT NULL,
  `PeriodEndDay` int(11) NOT NULL,
  `PeriodEndMonth` int(11) NOT NULL,
  `PeriodEndYear` int(11) NOT NULL,
  `PlaceOfAcquisition` varchar(255) NOT NULL,
  `SourceName` varchar(255) NOT NULL,
  `CountValue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
"INSERT INTO `cleaneddata`(`ConditionName`, `ConditionSNOMED`, `PathogenName`, `PathogenTaxonID`, `Fatalities`, `CountryName`, `CountryISO`, `Admin1Name`, `Admin1ISO`, `Admin2Name`, `CityName`, `PeriodStartDay`, `PeriodStartMonth`, `PeriodStartYear`, `PeriodEndDay`, `PeriodEndMonth`, `PeriodEndYear`, `PlaceOfAcquisition`, `SourceName`, `CountValue`) SELECT ConditionName,ConditionSNOMED,PathogenName,PathogenTaxonID,Fatalities,CountryName,CountryISO,Admin1Name,Admin1ISO,Admin2Name,CityName,PeriodStartDay,PeriodStartMonth,PeriodStartYear,PeriodEndDay,PeriodEndMonth,PeriodEndYear,PlaceOfAcquisition,SourceName,CountValue From data WHERE PartOfCumulativeCountSeries = 0");	
			// Run a sql
$arrlength = count($sqlLi);
for($x = 0; $x < $arrlength; $x++) {
    if($conn->query($sqlLi[$x]) == FALSE) {
	echo "Error: " . $conn->error;
    }
}
}

if(isset($_POST['fill'])){
			
			// Generate sql
$sqlLi = array(
"USE measlesodb",
"DROP TABLE IF EXISTS `time`",
"CREATE TABLE IF NOT EXISTS `time` (
  `TimeId` int(255) NOT NULL AUTO_INCREMENT,
  `PeriodStartDay` int(11) NOT NULL,
  `PeriodStartMonth` int(11) NOT NULL,
  `PeriodStartYear` int(11) NOT NULL,
  `PeriodEndDay` int(11) NOT NULL,
  `PeriodEndMonth` int(11) NOT NULL,
  `PeriodEndYear` int(11) NOT NULL,
  `PeriodStartQuarter` int(11) NOT NULL,
  PRIMARY KEY (`TimeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8",
" INSERT INTO `time`(`PeriodStartDay`, `PeriodStartMonth`, `PeriodStartYear`, `PeriodEndDay`, `PeriodEndMonth`, `PeriodEndYear`,`PeriodStartQuarter` ) SELECT DISTINCT PeriodStartDay,PeriodStartMonth,PeriodStartYear,PeriodEndDay,PeriodEndMonth,PeriodEndYear,1 from measles.cleaneddata",
"UPDATE `time` SET `PeriodStartQuarter`=1 WHERE PeriodStartMonth=1 OR PeriodStartMonth=2 OR PeriodStartMonth=3",
"UPDATE `time` SET `PeriodStartQuarter`=2 WHERE PeriodStartMonth=4 OR PeriodStartMonth=5 OR PeriodStartMonth=6",
"UPDATE `time` SET `PeriodStartQuarter`=3 WHERE PeriodStartMonth=7 OR PeriodStartMonth=8 OR PeriodStartMonth=9",
"UPDATE `time` SET `PeriodStartQuarter`=4 WHERE PeriodStartMonth=10 OR PeriodStartMonth=11 OR PeriodStartMonth=12"
);

			
	$arrlength = count($sqlLi);
	for($x = 0; $x < $arrlength; $x++) {
	    if($conn->query($sqlLi[$x]) == FALSE) {
		echo "Error: " . $conn->error;
	    }
	}
}
			
if(isset($_POST['Sick'])){
$sqlLi = array(
"USE measlesodb",
"DROP TABLE IF EXISTS `condition`;",
"CREATE TABLE IF NOT EXISTS `condition` (
  `ConditionName` varchar(255) NOT NULL,
  `ConditionSNOMED` varchar(255) NOT NULL,
  `PathogenName` varchar(255) NOT NULL,
  `PathogenTaxonID` varchar(255) NOT NULL,
  PRIMARY KEY (`ConditionSNOMED`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
"INSERT INTO `condition`(`ConditionName`,`ConditionSNOMED`,`PathogenName`,`PathogenTaxonID`)
    SELECT DISTINCT ConditionName, ConditionSNOMED, PathogenName, PathogenTaxonID from measles.cleaneddata "
);
			// Generate sql
$arrlength = count($sqlLi);
for($x = 0; $x < $arrlength; $x++) {
    if($conn->query($sqlLi[$x]) == FALSE) {
	echo "Error: " . $conn->error;
    }
}
			}
			
	if(isset($_POST['Loc'])){
$sqlLi = array(
"USE measlesodb",
"DROP TABLE IF EXISTS `location`;",
"CREATE TABLE IF NOT EXISTS `location` (
  `Lid` int(255) NOT NULL AUTO_INCREMENT,
  `CountryName` varchar(255) NOT NULL,
  `CountryISO` varchar(255) NOT NULL,
  `Admin1Name` varchar(255) NOT NULL,
  `Admin1ISO` varchar(255) NOT NULL,
  `Admin2Name` varchar(255) NOT NULL,
  `CityName` varchar(255) NOT NULL,
  `SourceName` varchar(255) NOT NULL,
  PRIMARY KEY (`Lid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
"INSERT INTO `location`(`CountryName`, `CountryISO`, `Admin1Name`, `Admin1ISO`, `Admin2Name`, `CityName`, `SourceName`)
    SELECT DISTINCT CountryName, CountryISO, Admin1Name, Admin1ISO, Admin2Name, CityName, SourceName from measles.cleaneddata"
);

$arrlength = count($sqlLi);
for($x = 0; $x < $arrlength; $x++) {
    if($conn->query($sqlLi[$x]) == FALSE) {
	echo "Error: " . $conn->error . $sqlLi[$x];
    }
}	
}

if(isset($_POST['Report'])){
$sqlLi = array(
"USE measlesodb",
"DROP TABLE IF EXISTS `EventReports`;",
"CREATE TABLE IF NOT EXISTS `EventReports` (
  `LocationId` int(255) NOT NULL,
  `TimeId` int(11) NOT NULL,
  `ConditionSNOMED` int(255) NOT NULL,
  `PlaceOfAcquisition` varchar(255) NOT NULL,
  `Fatalities` int(11) NOT NULL,
  `CountValue` int(11) NOT NULL,
  PRIMARY KEY (`LocationId`,`TimeId`,`ConditionSNOMED`,`PlaceOfAcquisition`)
  FOREIGN KEY (LocationId) REFERENCES location(LocationId)
  FOREIGN KEY (TimeId) REFERENCES time(TimeId)
  FOREIGN KEY (ConditionSNOMED) REFERENCES condition(ConditionSNOMED)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
",
"DROP TABLE IF EXISTS eventtemp",
"
CREATE TABLE eventtemp (
  ConditionName varchar(255) NOT NULL,
  ConditionSNOMED int(11) NOT NULL,
  PathogenName varchar(255) NOT NULL,
  PathogenTaxonID varchar(255) NOT NULL,
  Fatalities int(11) NOT NULL,
  CountryName varchar(255) NOT NULL,
  CountryISO varchar(255) NOT NULL,
  Admin1Name varchar(255) NOT NULL,
  Admin1ISO varchar(255) NOT NULL,
  Admin2Name varchar(255) NOT NULL,
  CityName varchar(255) NOT NULL,
  PeriodStartDay int(11) NOT NULL,
  PeriodStartMonth int(11) NOT NULL,
  PeriodStartYear int(11) NOT NULL,
  PeriodEndDay int(11) NOT NULL,
  PeriodEndMonth int(11) NOT NULL,
  PeriodEndYear int(11) NOT NULL,
  PlaceOfAcquisition varchar(255) NOT NULL,
  SourceName varchar(255) NOT NULL,
  CountValue varchar(255) NOT NULL
)",
"INSERT INTO eventtemp SELECT * FROM measles.cleaneddata",
"ALTER TABLE eventtemp ADD LocID INT(11)",
"ALTER TABLE eventtemp ADD timeID INT(11)",
"ALTER TABLE eventtemp ADD pathID INT(11)",
"UPDATE eventtemp
SET eventtemp.LocID = (SELECT location.Lid FROM location
WHERE location.CountryName = eventtemp.CountryName AND location.CountryISO = eventtemp.CountryISO AND location.Admin1Name = eventtemp.Admin1Name AND location.Admin1ISO = eventtemp.Admin1ISO AND location.Admin2Name = eventtemp.Admin2Name AND location.CityName = eventtemp.CityName)",
"UPDATE eventtemp
SET eventtemp.timeID = (SELECT time.TimeId FROM time
WHERE time.PeriodStartDay = eventtemp.PeriodStartDay AND time.PeriodStartMonth = eventtemp.PeriodStartMonth AND time.PeriodStartYear = eventtemp.PeriodStartYear AND time.PeriodEndDay = eventtemp.PeriodEndDay AND time.PeriodEndMonth = eventtemp.PeriodEndMonth AND time.PeriodEndYear = eventtemp.PeriodEndYear)",
"INSERT INTO EventReports(LocationId, TimeId, ConditionSNOMED, PlaceOfAcquisition, Fatalities, CountValue) SELECT LocID, timeID, ConditionSNOMED, PlaceOfAcquisition, MAX(Fatalities), SUM(CountValue) FROM eventtemp GROUP BY LocID, timeID, ConditionSNOMED, PlaceOfAcquisition",
"DROP TABLE IF EXISTS eventtemp"
/*"UPDATE eventtemp SET eventtemp.LocID=(SELECT l.Lid FROM location as l, eventtemp as d WHERE l.CountryName = d.CountryName AND l.CountryISO = d.CountryISO AND l.Admin1Name = d.Admin1Name AND l.Admin1ISO = d.Admin1ISO AND l.Admin2Name = d.Admin2Name AND l.CityName = d.CityName)"*/

/*"INSERT INTO `EventReports`(`LocationID`, `ConditionSNOMED`, `TimeId`, `Fatalities`, `PlaceOfAcquisition`, `CountValue`) 
SELECT  l.Lid, t.Timeid, d.ConditionSNOMED, d.PlaceOfAcquisition, SUM(d.Fatalities),SUM(d.CountValue)
FROM measles.cleaneddata as d,time as t,location as l 
WHERE (l.CountryName = d.CountryName AND l.CountryISO = d.CountryISO AND l.Admin1Name = d.Admin1Name AND l.Admin1ISO = d.Admin1ISO AND l.Admin2Name = d.Admin2Name AND l.CityName = d.CityName)
    AND (t.PeriodStartDay = d.PeriodStartDay AND t.PeriodStartMonth = d.PeriodStartMonth AND t.PeriodStartYear = d.PeriodStartYear AND t.PeriodEndDay = d.PeriodEndDay AND t.PeriodEndMonth = d.PeriodEndMonth AND t.PeriodEndYear = d.PeriodEndYear)
	GROUP BY l.Lid, t.Timeid, d.ConditionSNOMED, d.PlaceOfAcquisition"*/
);

		
$arrlength = count($sqlLi);
for($x = 0; $x < $arrlength; $x++) {
    if($conn->query($sqlLi[$x]) == FALSE) {
	echo "Error: " . $conn->error . $sqlLi[$x];
    }
}		
}


if(isset($_POST['createadb'])){
$sqlLi = array(
"CREATE DATABASE IF NOT EXISTS `measlesadb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
"USE measlesadb",
"DROP TABLE IF EXISTS `timedim`",
"CREATE TABLE IF NOT EXISTS `timedim` (
  `TimeId` int(11) NOT NULL AUTO_INCREMENT,
  `PeriodStartYear` int(11) NOT NULL,
  `PeriodStartQuarter` int(11) NOT NULL,
  PRIMARY KEY (`TimeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8",

"DROP TABLE IF EXISTS `locdim`",
"CREATE TABLE IF NOT EXISTS `locdim` (
  `LocId` int(11) NOT NULL AUTO_INCREMENT,
  `CountryName` varchar(255) NOT NULL,
  `CountryISO` varchar(255) NOT NULL,
  `Admin1Name` varchar(255) NOT NULL,
  `Admin1ISO` varchar(255) NOT NULL,
  `SourceName` varchar(255) NOT NULL,
  PRIMARY KEY (`LocId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8",

"DROP TABLE IF EXISTS `conddim`",
"CREATE TABLE IF NOT EXISTS `conddim` (
  `ConditionName` varchar(255) NOT NULL,
  `ConditionSNOMED` varchar(255) NOT NULL,
  `PathogenName` varchar(255) NOT NULL,
  `PathogenTaxonID` varchar(255) NOT NULL,
  PRIMARY KEY (`ConditionSNOMED`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8"
);

$arrlength = count($sqlLi);
for($x = 0; $x < $arrlength; $x++) {
    if($conn->query($sqlLi[$x]) == FALSE) {
	echo "Error: " . $conn->error;
    }
}

}

if(isset($_POST['insertadb'])){
$sqlLi = array(
"USE measlesadb",
"INSERT INTO timedim(PeriodStartYear, PeriodStartQuarter)
SELECT DISTINCT PeriodStartYear, PeriodStartQuarter
FROM measlesodb.time",
"INSERT INTO conddim
SELECT DISTINCT ConditionName, ConditionSNOMED, PathogenName, PathogenTaxonID FROM measlesodb.condition",
"INSERT INTO locdim(CountryName, CountryISO, Admin1Name, Admin1ISO, SourceName)
SELECT DISTINCT CountryName, CountryISO, Admin1Name, Admin1ISO, SourceName FROM measlesodb.location"
);

$arrlength = count($sqlLi);
for($x = 0; $x < $arrlength; $x++) {
    if($conn->query($sqlLi[$x]) == FALSE) {
	echo "Error: " . $conn->error;
    }
}
}






			// Close connection
			mysqli_close($conn);
			
		?>
	
</body>
</HTML>
