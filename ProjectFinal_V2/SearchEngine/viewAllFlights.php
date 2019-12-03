<?php
session_start();
require '../database-connection.php';
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>JetRed</title>
    <style>
        #account {
            color: white;

        }

        .account {
            color: white;
        }

    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <!-- nav -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <a class="navbar-brand" href="SearchEngine.php">Flight Search</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="SearchEngine.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="booking.php">Booking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../directory.php">Directory</a>
                    </li>

                    <?php
					//change nav if signed in
                    if(isset($_SESSION['searchEngineAdmin'])){
                        	print '

					<li class="nav-item">
						<a class="nav-link" href="admin.php">Admin Settings</a>
					</ li>
					';
                    }
					else if (isset($_SESSION["customerLoggedIn"])) {
						print '

					<li class="nav-item">
						<a class="nav-link" href="myprofile.php">My Flights</a>
					</ li>
					';
					}
					?>
                </ul>
            </div>
            <div id="account">
                <?php
				print ' <a> Today is  ' . $_SESSION['currentDate'] . '  </a><br>';
				?>
                <?php
				//change nav if signed in
				if(isset($_SESSION['searchEngineAdmin'])){
                    print " Logged In: ";
					print '<a id="myprofile" class="account" S href="myprofile.php">   ' . $_SESSION['searchAdmin'] . '  </a>';
					print " | ";
					print '<a id="signOut" class="account" S href="signout.php">Log Out</a>';
                }

				else if (!isset($_SESSION["customerLoggedIn"])) {
					print '
							<a id="userAccount" class="account" href="login.php">Sign in</a>
							<a id="registerAccount" class="account" S href="register.php">Register</a>
							';
				} else {
					print " Logged In: ";
					print '<a id="myprofile" class="account" S href="myprofile.php">   ' . $_SESSION['user'] . '  </a>';
					print " | ";
					print '<a id="signOut" class="account" S href="signout.php">Log Out</a>';
				}
				?>
            </div>

        </nav>
        <!-- nav -->
        <?php
                               $reservations = query("select 
user_id,
flights.flightID,
flightNumber as 'Flight #',
startAirport as 'From',
endAirport as 'To',
departureTime as 'Departure Time',
arrivalTime as 'Arrival Time',
fare as 'Fare',
status as 'Status' from flights join 
customerFlights on flights.flightID = customerFlights.flightID
where bookingPage = 'SearchEngine';
;");
            
            print "<div class='table-responsive'>
				<table class='table'>
                <tr><th>All Flights</th></tr>
			<tr>
                <td>" . "Customer ID" . "</td>
				<td>" . "Flight #" . "</td>
				<td>" . "From" . "</td>
				<td>" . "To" . "</td>
				<td>" . "Departure Time" . "</td>
				<td>" . "Arrival Time" . "</td>
                <td>" . "Fare" . "</td>
				<td>" . "Status" . "</td>
                <tr>";


			while ($row = mysqli_fetch_assoc($reservations)) {
                $cusID = $row['user_id'];
                $flightID = $row['flightID'];
				$flightNumber = $row['Flight #'];
				$startAirport = $row['From'];
				$endAirport = $row['To'];
				$departureTime = $row['Departure Time'];
				$arrivalTime = $row['Arrival Time'];
                $fare = $row['Fare'];
				$status = $row['Status'];
				print
					"<tr>
                    <td>" . $cusID . "</td>
					<td>" . $flightNumber . "</td>
					<td>" . $startAirport . "</td>
					<td>" . $endAirport . "</td>
					<td>" . $departureTime . "</td>
					<td>" . $arrivalTime . "</td>
                    <td>" . $fare . "</td>
					<td>" . $status . "</td>
						<tr>";
			}
			print "</table> </div>";  
            ?>



        <!-- Footer -->
        <footer class="page-footer font-small indigo">
            <div class="footer text-center py-3">JetRed
            </div>
        </footer>
        <!-- Footer -->



    </div>
</body>

</html>