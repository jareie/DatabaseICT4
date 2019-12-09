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
                            <a class="nav-link" href="standarduser.php">
                                <span data-feather="file">Standard User</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="standardadmin.php">
                                <span data-feather="file">Standard Admin</span>
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
                                    <button id="submit" name="submit" value="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>

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

            </main>
        </div>
    </div>
</body>

</HTML>
