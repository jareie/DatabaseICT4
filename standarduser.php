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

	<form name="oo" action="standarduser.php" method="POST" >
	<input name="submit" type="submit" value="advisor">
	<input name="submit2" type="submit" value="courses">
	</form>
		
		
			<?php
			
		
 
			if(isset($_POST['submit'])||isset($_POST['submit2'])){
				
			if(isset($_POST['submit'])){
			$select = "*";
			$from = "advisor";
			$where = "1";
			}
			if(isset($_POST['submit2'])){
			$select = "*";
			$from = "course";
			$where = "1";
			}
			if ($select == "" || $from == "")
			{
				die("Please provide input in select and from fields.");
			}
			// Generate sql
			$sql = "select ".$select." from ".$from;
			if (trim($where) != "" )
			{
				$sql = $sql." where ".$where;
			}
			echo "<p><font color=\"red\">".$sql."</font></p>";

			
			// Create connection
			$servername = "localhost";
			$username = "joel";
			$password = "test";
			$database = "curdb";
			$conn = new mysqli($servername, $username, $password,$database);

			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			echo "<p><font color=\"red\">Connected successfully</font></p>";

			// Run a sql
			$sql = "CREATE TABLE MyGuests (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			firstname VARCHAR(30) NOT NULL,
			lastname VARCHAR(30) NOT NULL,
			email VARCHAR(50),
			reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
			)";

			if ($conn->query($sql) === TRUE) {
	echo "Table MyGuests created successfully";
		} else {
    echo "Error creating table: " . $conn->error;
		}
				/*
			$result = $conn->query($sql);
			if ($result)
			{
				echo "<table border=1px>";
				while($row = $result->fetch_assoc())
				{
					echo "<tr>";
					foreach($row as $key=>$value)
					{
						echo "<td>$value</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
			$result->free();

			// Close connection
			mysqli_close($conn);
			*/}
		?>
	
</body>
</HTML>
