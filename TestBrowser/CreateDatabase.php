<?php
$servername = "localhost";
$username = "joel";
$password = "test";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS `RawDataMeasles` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}
$sql = "CREATE DATABASE IF NOT EXISTS `CleanedDataMeasles` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}
$sql = "CREATE DATABASE IF NOT EXISTS `Measles` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}
$conn->close();
?>
