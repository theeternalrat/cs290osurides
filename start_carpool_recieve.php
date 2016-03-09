<?php
include("_header.php");
include("db_init.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<h1>Saving your submission...</h1>

<?php
//print_r($_REQUEST);

if (isset($_POST["details"])) {
	$details = $_POST["details"];
} else {
	$details = "No description provided";
}

$all_fields_set = isset($_POST["carpool_creator"])  &&
                  isset($_POST["leave_date"])       &&
                  isset($_POST["startlocation"])         &&
                  isset($_POST["endlocation"]) ? true : false;


if ($all_fields_set) {

  $carpool_creator  = $_POST["carpool_creator"];
  $leave_date       = $_POST["leave_date"];
  $startloc			= $_POST["startlocation"];
  $endloc			= $_POST["endlocation"];
  $descrip 			= $_POST["descrip"];
  $start 			= $_POST["startlocationstring"];
  $end 				= $_POST["endlocationstring"];
  

  echo $leave_date;

	if ($stmt = $mysqli->prepare("insert into rides (carpool_creator, leave_date, startlocation, endlocation, open_to_passengers, description, start, end) values(?,?,?,?,true,?,?,?)")) {
		$stmt->bind_param("issssss", $carpool_creator, $leave_date, $startloc, $endloc, $descrip, $start, $end);
		$stmt->execute();
		$stmt->close();
		echo '<p>Created...';
	} else { 
		printf("Error: %s\n", $mysqli->error);
	}

}else {
	echo 'Field is unset';
	echo "<br>" .$_POST["carpool_creator"];
	echo "<br>" .$_POST["leave_date"];
	echo "<br>" .$_POST["startlocation"];
	echo "<br>" .$_POST["endlocation"];
}
?>

<?php
mysqli_close($mysqli);
include("_footer.php");
?>
