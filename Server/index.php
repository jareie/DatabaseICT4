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
                            <a class="nav-link active" href="index.php">
                                <span data-feather="home"></span> Home <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adminload.php">
                                <span data-feather="file">DB Load</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Query</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                    </div>
                </div>

                <div class="">
                    <form class="form-horizontal" method="POST">
                        <fieldset>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="select">Select</label>
                                <div class="col-md-8">
                                    <input id="select" name="select" type="text" placeholder="" class="form-control input-md" required="">
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="from">From</label>
                                <div class="col-md-8">
                                    <input id="from" name="from" type="text" placeholder="" class="form-control input-md" required="">

                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="where">Where</label>
                                <div class="col-md-8">
                                    <input id="where" name="where" type="text" placeholder="" class="form-control input-md">

                                </div>
                            </div>

                            <!-- Button -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-4">
                                    <button id="submit" name="queryInput" value="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>

<form name="queries" action="index.php" method="POST">
	<button name="stateCount" type="submit" class="btn btn-primary my-2">Get Count By State</button>
	<button name="All" type="submit" class="btn btn-primary my-2">Get Event For Time And State</button>
	<button name="Year" type="submit" class="btn btn-primary my-2">Get Count By Year</button>
	<button name="Quarter" type="submit" class="btn btn-primary my-2">Get Count By Quarter</button>
	<button name ="Conditions" type="submit" class="btn btn-primary my-2">Get Conditions</button>
	<button name ="Locations" type="submit" class="btn btn-primary my-2">Get Locations</button>
</form>
		
<?php
//Create Connection
require_once('User_DB.php');
$conn = new MySQLI($db_host,$db_user,$db_password,$db_database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
echo "<p><font color=\"red\">Connected successfully</font></p>";

if(isset($_POST['stateCount'])){
	$sql = "SELECT Admin1Name,
		Sum(count) AS total
		FROM   fact AS f,
		locdim AS l
		WHERE  f.Admin1ISO = l.Admin1ISO
		GROUP  BY Admin1Name
		ORDER  BY total DESC";
	// Run a sql
	$result = $conn->query($sql);
	
	echo "Query done";
	if($result){
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
	} else {
		echo "Error: " . $conn->error;
	}

	$result->free();

	// Close connection
	mysqli_close($conn);
}

if(isset($_POST['All'])){
	$sql = "SELECT t.PeriodStartYear,
		t.PeriodStartMonth,
		l.CountryISO,
		l.Admin1ISO,
		c.ConditionSNOMED,
		f.fatalities,
		f.count
 FROM   fact AS f,
		locdim AS l,
		timedim AS t,
		conddim AS c
 WHERE  f.Admin1ISO = l.Admin1ISO
		AND f.TimeId = t.TimeId
		AND f.ConditionSNOMED = c.ConditionSNOMED
 ORDER  BY l.Admin1ISO ASC";
	// Run a sql
	$result = $conn->query($sql);
	
	echo "Query done";
	if($result){
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
	} else {
		echo "Error: " . $conn->error;
	}

	$result->free();

	// Close connection
	mysqli_close($conn);
}

if(isset($_POST['Quarter'])){
	$sql = "SELECT PeriodStartYear, PeriodStartQuarter, COUNT(count)
	FROM fact,timedim
	WHERE timedim.TimeId = fact.TimeId
	GROUP BY PeriodStartYear,PeriodStartQuarter
	ORDER BY PeriodStartYear,PeriodStartQuarter
	ASC";
	// Run a sql
	$result = $conn->query($sql);
	
	echo "Query done";
	if($result){
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
	} else {
		echo "Error: " . $conn->error;
	}

	$result->free();

	// Close connection
	mysqli_close($conn);
}

if(isset($_POST['Year'])){
	$sql = "SELECT PeriodStartYear, SUM(count)
	FROM fact,timedim WHERE timedim.TimeId = fact.TimeId
	GROUP BY PeriodStartYear
	ORDER BY timedim.PeriodStartYear
	ASC ";
	// Run a sql
	$result = $conn->query($sql);
	
	echo "Query done";
	if($result){
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
	} else {
		echo "Error: " . $conn->error;
	}

	$result->free();

	// Close connection
	mysqli_close($conn);
}

if(isset($_POST['Conditions'])){
	$sql = "SELECT * FROM conddim;";
	// Run a sql
	$result = $conn->query($sql);
	
	echo "Query done";
	if($result){
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
	} else {
		echo "Error: " . $conn->error;
	}

	$result->free();

	// Close connection
	mysqli_close($conn);
}

if(isset($_POST['Locations'])){
	$sql = "SELECT * FROM locdim";
	// Run a sql
	$result = $conn->query($sql);
	
	echo "Query done";
	if($result){
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
	} else {
		echo "Error: " . $conn->error;
	}

	$result->free();

	// Close connection
	mysqli_close($conn);
}

if(isset($_POST['createDb'])){
	$sql =
		"SELECT PeriodStartYear,
		PeriodStartMonth,
		PeriodStartQuarter
 FROM   timedim
 ORDER  BY timedim.PeriodStartYear,
		   timedim.PeriodStartMonth ASC";
	// Run a sql
	$result = $conn->query($sql);
	
	echo "Query done";
	if($result){
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
	} else {
		echo "Error: " . $conn->error;
	}

	$result->free();

	// Close connection
	mysqli_close($conn);
}

if(isset($_POST['queryInput'])){
	$select = $_POST["select"];
	$from = $_POST["from"];
	$where = $_POST["where"];
	
	if ($select == "" || $from == "")
	{
		die("Please provide input in select and from fields.");
	}

	$sql = "select ".$select." from ".$from;
	if (trim($where) != "" )
	{
		$sql = $sql." where ".$where;
	}
	echo "<p><font color=\"red\">".$sql."</font></p>";


	// Run a sql
	$result = $conn->query($sql);
	
	echo "Query done";
	if($result){
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
	} else {
		echo "Error: " . $conn->error;
	}

	$result->free();

	// Close connection
	mysqli_close($conn);
}
?>

            </main>
        </div>
    </div>	
</body>

</HTML>
