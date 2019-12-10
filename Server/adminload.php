<HTML>

<head>
    <title>Analytical Database</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="dashboard.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Data Warehouse</a>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="#">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <span data-feather="home"> Home </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="adminload.php">
                                <span data-feather="home"></span> DB Load <span class="sr-only">(current)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Database Loading</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                    </div>
                </div>

                <form name="queryInput" action="adminload.php" method="POST">
                    <button name="createDb" type="submit" class="btn btn-primary my-2">1. Create Databse</button>
                    <button name="loadData" type="submit" class="btn btn-primary my-2">2. Load Data</button>
                    <button name="submit" type="submit" class="btn btn-primary my-2">3. Clean Rawdata</button>
                    <button name="Sick" type="submit" class="btn btn-primary my-2">4. Condition table</button>
                    <button name="Loc" type="submit" class="btn btn-primary my-2">5. Location table</button>
                    <button name="Report" type="submit" class="btn btn-primary my-2">6. Reports table</button>
                    <button name="createadb" type="submit" class="btn btn-primary my-2">7. Create ADB</button>
                    <button name="insertadb" type="submit" class="btn btn-primary my-2">8. Add data to ADB</button>
                </form>

<?php
  require_once('Admin_DB.php');


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
    echo "This functionality is unavailable at the moment. Please use the Python scripts: load.py and MeaslesReader.py";
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
            </main>
        </div>
    </div>

</body>

</HTML>
