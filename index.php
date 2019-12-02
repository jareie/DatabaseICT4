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

	<form name="queryInput" action="index.php" method="POST">
			Select:<input type="text" name="select">
			From:<input type="text" name="from">
			Where:<input type="text" name="where">
			<input type="submit" value="submit">
		</form>
		
		
			<?php
			
			if(isset($_POST['queryInput'])){
			$select = $_POST["select"];
			$from = $_POST["from"];
			$where = $_POST["where"];
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
			}
		?>
	
</body>
</HTML>
