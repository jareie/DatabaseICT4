<HTML>
<head>
<title>Admin Page</title>
</head>
<body>
<nav>
  <ul>
    <li><a href="index.php"><strong>Home</strong></li>
    <li><a href="adminload.php">Admin</a></li>
  </ul>
</nav>

<form name="queryInput" action="adminload.php" method="POST">
  <input name ="createDb" type="submit" value="Create Database">
  <input name ="loadData" type="submit" value="Load Data">
  <input name ="submit" type="submit" value="Clean Rawdata">
  <input name ="Sick" type="submit" value="Condition table">
  <input name ="Loc" type="submit" value="Location table">
  <input name ="Report" type="submit" value="Reports table">
  <input name ="createadb" type="submit" value="Create ADB">
  <input name ="insertadb" type="submit" value="Add data to ADB">
</form>
		
		
<?php
  require_once('db_config.php');

  $conn = new MySQLI($db_host,$db_user,$db_password);
  // Create connection
        
        
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
        PeriodStartDate DATE NOT NULL,
        PeriodEndDate DATE NOT NULL,
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
    echo "Query done";
  }
  
  if(isset($_POST['loadData'])){
  //require dirname(__FILE__) . "/MeaslesReader.py";
  //echo "python " . dirname(__FILE__) . "/MeaslesReader.py";
    //popen("MeaslesReader.py","r");
    echo "This functionality is unaviable at the moment. Please use the PythonScripts: load.py and MeaslesReader.py";
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
        `PeriodStartDate` DATE NOT NULL,
        `PeriodEndDate` DATE NOT NULL,
        `PlaceOfAcquisition` varchar(255) NOT NULL,
        `CountValue` varchar(255) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
      "INSERT INTO `cleaneddata`(`ConditionName`, `ConditionSNOMED`, `PathogenName`, `PathogenTaxonID`, `Fatalities`, `CountryName`, `CountryISO`, `Admin1Name`, `Admin1ISO`, `Admin2Name`, `CityName`, `PeriodStartDate`, `PeriodEndDate`, `PlaceOfAcquisition`, `CountValue`)
      SELECT ConditionName, ConditionSNOMED, PathogenName, PathogenTaxonID, Fatalities, CountryName, CountryISO, Admin1Name, Admin1ISO, Admin2Name, CityName, PeriodStartDate, PeriodEndDate, PlaceOfAcquisition, CountValue
      FROM data WHERE PartOfCumulativeCountSeries = 0"
      );	
        // Run a sql
    $arrlength = count($sqlLi);
    for($x = 0; $x < $arrlength; $x++) {
        if($conn->query($sqlLi[$x]) == FALSE) {
      echo "Error: " . $conn->error;
        }
    }
    echo "Query done";
  }
  if(isset($_POST['fill'])){
        
    // Generate sql
    $sqlLi = array(
      "USE measlesodb",
      "DROP TABLE IF EXISTS `time`",
      "CREATE TABLE IF NOT EXISTS `time` (
        `TimeId` int(255) NOT NULL AUTO_INCREMENT,
        `PeriodStartDate` DATE NOT NULL,
        `PeriodEndDate` DATE NOT NULL,
        PRIMARY KEY (`TimeId`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8",
      "INSERT INTO `time`(`PeriodStartDay`, `PeriodStartMonth`, `PeriodStartYear`, `PeriodEndDay`, `PeriodEndMonth`, `PeriodEndYear`,`PeriodStartQuarter` )
      SELECT DISTINCT PeriodStartDay,PeriodStartMonth,PeriodStartYear,PeriodEndDay,PeriodEndMonth,PeriodEndYear,1
      FROM measles.cleaneddata"
      );
        
    $arrlength = count($sqlLi);
    for($x = 0; $x < $arrlength; $x++) {
        if($conn->query($sqlLi[$x]) == FALSE) {
      echo "Error: " . $conn->error;
        }
    }
    echo "Query done";
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
      SELECT DISTINCT ConditionName, ConditionSNOMED, PathogenName, PathogenTaxonID
      FROM measles.cleaneddata"
      );
        // Generate sql
    $arrlength = count($sqlLi);
    for($x = 0; $x < $arrlength; $x++) {
        if($conn->query($sqlLi[$x]) == FALSE) {
      echo "Error: " . $conn->error;
        }
    }
    echo "Query done";
  }
        
  if(isset($_POST['Loc'])){
    $sqlLi = array(
      "USE measlesodb",
      "DROP TABLE IF EXISTS `location`;",
      "CREATE TABLE IF NOT EXISTS `location` (
        `CountryName` varchar(255) NOT NULL,
        `CountryISO` varchar(255) NOT NULL,
        `Admin1Name` varchar(255) NOT NULL,
        `Admin1ISO` varchar(255) NOT NULL,
        `Admin2Name` varchar(255) NOT NULL,
        `CityName` varchar(255) NOT NULL,
        PRIMARY KEY (`Admin1ISO`,`CityName`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
      "INSERT INTO `location`(`CountryName`, `CountryISO`, `Admin1Name`, `Admin1ISO`, `Admin2Name`, `CityName`)
      SELECT DISTINCT CountryName, CountryISO, Admin1Name, Admin1ISO, Admin2Name, CityName
      FROM measles.cleaneddata"
      );
    $arrlength = count($sqlLi);
    for($x = 0; $x < $arrlength; $x++) {
        if($conn->query($sqlLi[$x]) == FALSE) {
      echo "Error: " . $conn->error . $sqlLi[$x];
        }
    }
    echo "Query done";
  }
  if(isset($_POST['Report'])){
    $sqlLi = array(
      "USE measlesodb",
      "DROP TABLE IF EXISTS `EventReports`;",
      "CREATE TABLE IF NOT EXISTS `EventReports` (
        `Admin1ISO` varchar(255) NOT NULL,
        `Admin2Name` varchar(255) NOT NULL,
        `CityName` varchar(255) NOT NULL,
        `ConditionSNOMED` int(255) NOT NULL,
        `PeriodStartDate` DATE NOT NULL,
        `PeriodEndDate` DATE NOT NULL,
        `PlaceOfAcquisition` varchar(255) NOT NULL,
        `Fatalities` int(11) NOT NULL,
        `CountValue` int(11) NOT NULL,
        PRIMARY KEY (`Admin1ISO`,`Admin2Name`,`CityName`,`PeriodStartDate`,`ConditionSNOMED`,`PlaceOfAcquisition`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
      ",
      "INSERT INTO EventReports(Admin1ISO,Admin2Name,CityName,PeriodStartDate,PeriodEndDate, ConditionSNOMED, PlaceOfAcquisition, Fatalities, CountValue)
      SELECT m.Admin1ISO,m.Admin2Name,m.CityName, m.PeriodStartDate,m.PeriodEndDate, m.ConditionSNOMED, m.PlaceOfAcquisition, MAX(m.Fatalities), SUM(m.CountValue)
      FROM measles.cleaneddata as m
      GROUP BY m.Admin1ISO, m.Admin2Name, m.CityName, m.PeriodStartDate, m.PeriodEndDate, m.ConditionSNOMED, m.PlaceOfAcquisition"
      );
      
    $arrlength = count($sqlLi);
    for($x = 0; $x < $arrlength; $x++) {
        if($conn->query($sqlLi[$x]) == FALSE) {
      echo "Error: " . $conn->error . $sqlLi[$x];
        }
    }
    echo "Query done";	
  }
  if(isset($_POST['createadb'])){
    $sqlLi = array(
      "CREATE DATABASE IF NOT EXISTS `measlesadb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
      "USE measlesadb",
      "DROP TABLE IF EXISTS `timedim`",
      "CREATE TABLE IF NOT EXISTS `timedim` (
        `TimeId` int(11) NOT NULL AUTO_INCREMENT,
        `PeriodStartYear` int(11) NOT NULL,
        `PeriodStartMonth` int(11) NOT NULL,
        `PeriodStartQuarter` int(11) NOT NULL,
        PRIMARY KEY (`TimeId`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8",
      "DROP TABLE IF EXISTS `locdim`",
      "CREATE TABLE IF NOT EXISTS `locdim` (
        `CountryName` varchar(255) NOT NULL,
        `CountryISO` varchar(255) NOT NULL,
        `Admin1Name` varchar(255) NOT NULL,
        `Admin1ISO` varchar(255) NOT NULL,
        PRIMARY KEY (`Admin1ISO`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8",
      "DROP TABLE IF EXISTS `conddim`",
      "CREATE TABLE IF NOT EXISTS `conddim` (
        `ConditionName` varchar(255) NOT NULL,
        `ConditionSNOMED` varchar(255) NOT NULL,
        `PathogenName` varchar(255) NOT NULL,
        `PathogenTaxonID` varchar(255) NOT NULL,
        PRIMARY KEY (`ConditionSNOMED`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8",
      "DROP TABLE IF EXISTS `fact`",
      "CREATE TABLE IF NOT EXISTS `fact` (
        `TimeId` int(11) NOT NULL,
        `Admin1ISO` Varchar(255) NOT NULL,
        `ConditionSNOMED` varchar(255) NOT NULL,
        `PlaceOfAcquisition` varchar(255) NOT NULL,
        `fatalities` int(11) NOT NULL,
        `count` int(11) NOT NULL,
        PRIMARY KEY (`TimeId`,`Admin1ISO`,`ConditionSNOMED`,`PlaceOfAcquisition`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8"
      );
    $arrlength = count($sqlLi);
    for($x = 0; $x < $arrlength; $x++) {
      if($conn->query($sqlLi[$x]) == FALSE) {
        echo "Error: " . $conn->error;
      }
    }
    echo "Query done";
  }

  if(isset($_POST['insertadb'])){
    $sqlLi = array(
      "USE measlesadb",
      "INSERT INTO timedim(PeriodStartYear, PeriodStartMonth, PeriodStartQuarter)
      SELECT DISTINCT EXTRACT(YEAR FROM PeriodStartDate), EXTRACT(MONTH FROM PeriodStartDate),
      CASE
        WHEN EXTRACT(MONTH FROM PeriodStartDate) < 4 THEN 1
        WHEN EXTRACT(MONTH FROM PeriodStartDate) < 7 THEN 2
        WHEN EXTRACT(MONTH FROM PeriodStartDate) < 10 THEN 3
        WHEN EXTRACT(MONTH FROM PeriodStartDate) < 13 THEN 4
      END AS PeriodStartQuarter
      FROM measlesodb.EventReports",
      "INSERT INTO conddim
      SELECT DISTINCT ConditionName, ConditionSNOMED, PathogenName, PathogenTaxonID
      FROM measlesodb.condition",
      "INSERT INTO fact(TimeId,Admin1ISO,PlaceOfAcquisition,ConditionSNOMED,fatalities,count)
      SELECT timedim.TimeId, ev.Admin1ISO,ev.PlaceOfAcquisition, ev.ConditionSNOMED, MAX(ev.Fatalities), SUM(ev.CountValue)
      FROM measlesodb.EventReports as ev,timedim
      WHERE timedim.PeriodStartYear = EXTRACT(YEAR FROM ev.PeriodStartDate) 
      AND timedim.PeriodStartMonth = EXTRACT(MONTH FROM ev.PeriodStartDate)
      GROUP BY timedim.TimeId, ev.PlaceOfAcquisition, ev.Admin1ISO, ev.ConditionSNOMED",
      "INSERT INTO locdim(CountryName, CountryISO, Admin1Name, Admin1ISO)
      SELECT DISTINCT loc.CountryName, loc.CountryISO, loc.Admin1Name, loc.Admin1ISO
      FROM measlesodb.location as loc, fact
      Where fact.Admin1ISO = loc.Admin1ISO"
      );
    
    $arrlength = count($sqlLi);
    for($x = 0; $x < $arrlength; $x++) {
      if($conn->query($sqlLi[$x]) == FALSE) {
        echo "Error: " . $conn->error;
      }
    }
    echo "Query done";
  }

  // Close connection
  mysqli_close($conn);
?>
	
</body>
</HTML>
