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

$all_fields_set = isset($_POST["carpool_creator"])  &&
                  isset($_POST["leave_date"])       &&
                  isset($_POST["from_lat"])         &&
                  isset($_POST["from_long"])        &&
                  isset($_POST["destination_lat"])  &&
                  isset($_POST["destination_long"]) ? true : false;


if ($all_fields_set) {

  $carpool_creator  = $_POST["carpool_creator"];
  $leave_date       = $_POST["leave_date"];
  $from_lat         = $_POST["from_lat"];
  $from_long        = $_POST["from_long"];
  $destination_lat  = $_POST["destination_lat"];
  $destination_long = $_POST["destination_long"];

  echo $leave_date;

	if ($stmt = $mysqli->prepare("insert into rides (carpool_creator, leave_date, from_lat, from_long, destination_lat, destination_long, open_to_passengers) values(?,?,?,?,?,?,true)")) {
		$stmt->bind_param("isdddd", $carpool_creator, $leave_date, $from_lat, $from_long, $destination_lat, $destination_long);
		$stmt->execute();
		$stmt->close();
		echo '<p>Created...';
	} else { 
		printf("Error: %s\n", $mysqli->error);
	}

}else {
	echo 'Field is unset';
}
?>

<?php
mysqli_close($mysqli);
include("_footer.php");
?>
