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
			<input name ="submit" type="submit" value="CleanedRawdata">
			<input name ="fill" type="submit" value="Time">
			<input name ="Sick" type="submit" value="Conditiontable">
			<input name ="Loc" type="submit" value="Locationtable">
			<input name ="Report" type="submit" value="Reportstable">
		</form>
		
		
			<?php
			// Create connection
			$servername = "localhost";
			$username = "joel";
			$password = "test";
			$database = "measles";
			$conn = new mysqli($servername, $username, $password,$database);
			
			
			$database = "measlesodb";
			$connodb = new mysqli($servername, $username, $password,$database);
			
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			echo "<p><font color=\"red\">Connected successfully</font></p>";
			
			if(isset($_POST['submit'])){
			
			// Generate sql
			$sql2 = "DROP TABLE IF EXISTS `cleaneddata`;";
			$sql = "
			CREATE TABLE IF NOT EXISTS `cleaneddata` (
  `ConditionName` varchar(255) NOT NULL,
  `ConditionSNOMED` int(11) NOT NULL,
  `PathogenName` varchar(255) NOT NULL,
  `PathogonTaxonsID` varchar(255) NOT NULL,
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
  `PlaceOfAquisition` varchar(255) NOT NULL,
  `SourceName` varchar(255) NOT NULL,
  `CountValue` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
	$sql3 ="INSERT INTO `cleaneddata`(`ConditionName`, `ConditionSNOMED`, `PathogenName`, `PathogonTaxonsID`, `Fatalities`, `CountryName`, `CountryISO`, `Admin1Name`, `Admin1ISO`, `Admin2Name`, `CityName`, `PeriodStartDay`, `PeriodStartMonth`, `PeriodStartYear`, `PeriodEndDay`, `PeriodEndMonth`, `PeriodEndYear`, `PlaceOfAquisition`, `SourceName`, `CountValue`) SELECT ConditionName,ConditionSNOMED,PathogenName,PathogenTaxonID,Fatalities,CountryName,CountryISO,Admin1Name,Admin1ISO,Admin2Name,CityName,PeriodStartDay,PeriodStartMonth,PeriodStartYear,PeriodEndDay,PeriodEndMonth,PeriodEndYear,PlaceOfAcquisition,SourceName,CountValue From data WHERE PartOfCumulativeCountSeries = 0";		


			
			
			// Run a sql
				if ($conn->query($sql2) === TRUE) {
	echo $sql2 . " ran correctly;";
		} else {
    echo "Error: " . $conn->error;
		}
			if ($conn->query($sql) === TRUE) {
	echo $sql . " ran correctly;";
		} else {
    echo "Error: " . $conn->error;
		}
			if ($conn->query($sql3) === TRUE) {
	echo $sql3 . " ran correctly;";
		} else {
    echo "Error: " . $conn->error;
		}
			}

if(isset($_POST['fill'])){
			
			// Generate sql
			$sql2 = "DROP TABLE IF EXISTS `time`;";
			$sql = "
	CREATE TABLE IF NOT EXISTS `time` (
  `TimeID` int(11) NOT NULL AUTO_INCREMENT,
  `PeriodStartDay` int(11) NOT NULL,
  `PeriodStartMonth` int(11) NOT NULL,
  `PeriodStartYear` int(11) NOT NULL,
  `PeriodEndDay` int(11) NOT NULL,
  `PeriodEndMonth` int(11) NOT NULL,
  `PeriodEndYear` int(11) NOT NULL,
  `PeriodStartQuarter` int(11) NOT NULL,
  PRIMARY KEY (`TimeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
	$sql3 =" INSERT INTO `time`(`PeriodStartDay`, `PeriodStartMonth`, `PeriodStartYear`, `PeriodEndDay`, `PeriodEndMonth`, `PeriodEndYear`,`PeriodStartQuarter` ) SELECT DISTINCT PeriodStartDay,PeriodStartMonth,PeriodStartYear,PeriodEndDay,PeriodEndMonth,PeriodEndYear,1 from measles.cleaneddata";
			
			
			// Run a sql
				if ($connodb->query($sql2) === TRUE) {
	echo $sql2 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
			if ($connodb->query($sql) === TRUE) {
	echo $sql . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
			if ($connodb->query($sql3) === TRUE) {
	echo $sql3 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
	$q1 ="UPDATE `time` SET `PeriodStartQuarter`=1 WHERE PeriodStartMonth=1 OR PeriodStartMonth=2 OR PeriodStartMonth=3";
	$q2 ="UPDATE `time` SET `PeriodStartQuarter`=2 WHERE PeriodStartMonth=4 OR PeriodStartMonth=5 OR PeriodStartMonth=6";
	$q3 ="UPDATE `time` SET `PeriodStartQuarter`=3 WHERE PeriodStartMonth=7 OR PeriodStartMonth=8 OR PeriodStartMonth=9";
	$q4 ="UPDATE `time` SET `PeriodStartQuarter`=4 WHERE PeriodStartMonth=10 OR PeriodStartMonth=11 OR PeriodStartMonth=12";
		if ($connodb->query($q1) === TRUE) {
	echo $q1 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
		if ($connodb->query($q2) === TRUE) {
	echo $q2 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
		if ($connodb->query($q3) === TRUE) {
	echo $q3 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
		if ($connodb->query($q4) === TRUE) {
	echo $q4 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
			}
			
if(isset($_POST['Sick'])){
			
			// Generate sql
			$sql2 = "DROP TABLE IF EXISTS `conditions`;";
			$sql = "
	CREATE TABLE IF NOT EXISTS `conditions` (
  `ConditionID` int(11) NOT NULL AUTO_INCREMENT,
  `ConditionName` varchar(255) NOT NULL,
  `ConditionSNOMED` int(11) NOT NULL,
  `PathogenName` varchar(255) NOT NULL,
  `PathogenTaxonsID` varchar(255) NOT NULL,
  PRIMARY KEY (`ConditionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
	$sql3 ="INSERT INTO `conditions`(`ConditionName`, `ConditionSNOMED`, `PathogenName`, `PathogenTaxonsID`) Select DISTINCT ConditionName,ConditionSNOMED,PathogenName,PathogonTaxonsID from measles.cleaneddata ";
			
			// Run a sql
				if ($connodb->query($sql2) === TRUE) {
	echo $sql2 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
			if ($connodb->query($sql) === TRUE) {
	echo $sql . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}

	if ($connodb->query($sql3) === TRUE) {
	echo $sql3 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
		
			}
			
	if(isset($_POST['Loc'])){
			
			// Generate sql
			$sql2 = "DROP TABLE IF EXISTS `Location`;";
			$sql = "
CREATE TABLE IF NOT EXISTS `location` (
  `LocationID` int(11) NOT NULL AUTO_INCREMENT,
  `CountryName` varchar(255) NOT NULL,
  `CountryISO` varchar(255) NOT NULL,
  `Admin1Name` varchar(255) NOT NULL,
  `Admin1ISO` varchar(255) NOT NULL,
  `Admin2Name` varchar(255) NOT NULL,
  `CityName` varchar(255) NOT NULL,
  `SourceName` varchar(255) NOT NULL,
  PRIMARY KEY (`LocationID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
	$sql3 ="INSERT INTO `location`(`CountryName`, `CountryISO`, `Admin1Name`, `Admin1ISO`, `Admin2Name`, `CityName`, `SourceName`) SELECT DISTINCT CountryName,CountryISO,Admin1Name,Admin1ISO,Admin2Name,CityName,SourceName from measles.cleaneddata";	
			// Run a sql
				if ($connodb->query($sql2) === TRUE) {
	echo $sql2 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
			if ($connodb->query($sql) === TRUE) {
	echo $sql . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}

	if ($connodb->query($sql3) === TRUE) {
	echo $sql3 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
			}
	

if(isset($_POST['Report'])){
			
			// Generate sql
			$sql2 = "DROP TABLE IF EXISTS `EventReports`;";
			$sql = "
CREATE TABLE IF NOT EXISTS `eventreports` (
  `ReportID` int(11) NOT NULL AUTO_INCREMENT,
  `LocationID` int(11) NOT NULL,
  `ConditionID` int(11) NOT NULL,
  `TimeID` int(11) NOT NULL,
  `fatalities` int(11) NOT NULL,
  `PlaceOfAcquisition` varchar(255) NOT NULL,
  `Count` varchar(255) NOT NULL,
  PRIMARY KEY (`ReportID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
	$sql3 ="INSERT INTO `eventreports`(`LocationID`, `ConditionID`, `TimeID`, `fatalities`, `PlaceOfAcquisition`, `Count`) 

SELECT  loc.LocationID, con.ConditionID, time.TimeID, data.fatalities, data.PlaceOfAquisition, data.CountValue 

from measles.cleaneddata as data, conditions as con,time as time,location as loc 

Where loc.CountryName = data.CountryName AND loc.CountryISO = data.CountryISO AND loc.Admin1Name = data.Admin1Name AND loc.Admin1ISO = data.Admin1ISO AND loc.Admin2Name = data.Admin2Name AND loc.CityName = data.CityName AND con.PathogenName = data.PathogenName AND time.PeriodStartDay = data.PeriodStartDay AND time.PeriodStartMonth = data.PeriodStartMonth AND time.PeriodStartYear = data.PeriodStartYear AND time.PeriodEndDay = data.PeriodEndDay AND time.PeriodEndMonth = data.PeriodEndMonth AND time.PeriodEndYear = data.PeriodEndYear";
	
	
	
	// Run a sql
				if ($connodb->query($sql2) === TRUE) {
	echo $sql2 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
			if ($connodb->query($sql) === TRUE) {
	echo $sql . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}

	if ($connodb->query($sql3) === TRUE) {
	echo $sql3 . " ran correctly;";
		} else {
    echo "Error: " . $connodb->error;
		}
		
		
			}
	






			// Close connection
			mysqli_close($conn);
			mysqli_close($connodb);
			
		?>
	
</body>
</HTML>
