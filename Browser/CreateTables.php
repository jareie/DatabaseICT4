<?php
$servername = "localhost";
$username = "joel";
$password = "test";
$dbname = "Measles";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "DROP TABLE IF EXISTS `DATA`;
CREATE TABLE IF NOT EXISTS `DATA` (
  `ConditionName` varchar(255) DEFAULT NULL,
  `ConditionSNOMED` int(255) DEFAULT NULL,
  `PathogenName` varchar(255) DEFAULT NULL,
  `PathogenTaxonID` varchar(255) DEFAULT NULL,
  `Fatalities` int(255) DEFAULT NULL,
  `CountryName` varchar(255) DEFAULT NULL,
  `CountryISO` varchar(255) DEFAULT NULL,
  `Admin1Name` varchar(255) DEFAULT NULL,
  `Admin1ISO` varchar(255) DEFAULT NULL,
  `Admin2Name` varchar(255) DEFAULT NULL,
  `CityName` varchar(255) DEFAULT NULL,
  `PeriodStartDay` int(255) DEFAULT NULL,
  `PeriodStartMonth` int(255) DEFAULT NULL,
  `PeriodStartYear` int(255) DEFAULT NULL,
  `PeriodEndDay` int(255) DEFAULT NULL,
  `PeriodEndMonth` int(255) DEFAULT NULL,
  `PeriodEndYear` int(255) DEFAULT NULL,
  `PartOfCumulativeCountSeries` tinyint(1) DEFAULT NULL,
  `AgeRange` varchar(255) DEFAULT NULL,
  `Subpopulation` varchar(255) DEFAULT NULL,
  `PlaceOfAcquisition` varchar(255) DEFAULT NULL,
  `DiagnosisCertainty` varchar(255) DEFAULT NULL,
  `SourceName` varchar(255) DEFAULT NULL,
  `CountValue` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Events`
--

DROP TABLE IF EXISTS `Events`;
CREATE TABLE IF NOT EXISTS `Events` (
  `LocationId` int(255) NOT NULL,
  `TimeId` int(255) NOT NULL,
  `ConditionSNOMED` int(255) NOT NULL,
  `PlaceOfAquisition` varchar(255) NOT NULL,
  `Fatalities` int(255) NOT NULL,
  `PartOfCumulativeSeries` tinyint(1) NOT NULL,
  `CountValue` int(255) NOT NULL,
  PRIMARY KEY (`LocationId`,`TimeId`,`ConditionSNOMED`,`PlaceOfAquisition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Location`
--

DROP TABLE IF EXISTS `Location`;
CREATE TABLE IF NOT EXISTS `Location` (
  `Lid` int(255) NOT NULL AUTO_INCREMENT,
  `CountryName` varchar(255) NOT NULL,
  `CountryISO` varchar(255) NOT NULL,
  `Admin1Name` varchar(255) NOT NULL,
  `Admin1ISO` varchar(255) NOT NULL,
  `Admin2Name` varchar(255) NOT NULL,
  `CityName` varchar(255) NOT NULL,
  PRIMARY KEY (`Lid`)
) ENGINE=InnoDB AUTO_INCREMENT=3070 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Sickness`
--

DROP TABLE IF EXISTS `Condition`;
CREATE TABLE IF NOT EXISTS `Condition` (
  `ConditionName` varchar(255) NOT NULL,
  `ConditionSNOMED` varchar(255) NOT NULL,
  `PathogenName` varchar(255) NOT NULL,
  `PathogenTaxonID` varchar(255) NOT NULL,
  PRIMARY KEY (`ConditionSNOMED`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `TimePeriod`
--

DROP TABLE IF EXISTS `TimePeriod`;
CREATE TABLE IF NOT EXISTS `TimePeriod` (
  `TimeId` int(255) NOT NULL AUTO_INCREMENT,
  `PeriodStartDay` int(255) NOT NULL,
  `PeriodStartMonth` int(255) NOT NULL,
  `PeriodStartYear` int(255) NOT NULL,
  `PeriodEndDay` int(255) NOT NULL,
  `PeriodEndMonth` int(255) NOT NULL,
  `PeriodEndYear` int(255) NOT NULL,
  PRIMARY KEY (`TimeId`)
) ENGINE=InnoDB AUTO_INCREMENT=40958 DEFAULT CHARSET=utf8;";

if ($conn->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}


$conn->close();
?>