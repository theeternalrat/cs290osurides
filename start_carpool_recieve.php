<?php
include("_header.php");
if(checkAuth(true) != ""){

include("db_init.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<h1>Saving your submission...</h1>

<?php

//TODO SET THIS AS SESSION[$uid] once thats implemented.
$uid = 1;

//print_r($_REQUEST);

if (isset($_POST["details"])) {
	$details = $_POST["details"];
} else {
	$details = "No description provided";
}

$all_fields_set = isset($_POST["carpool_creator"])  &&
                  isset($_POST["leave_date"])       &&
                  isset($_POST["startlocation"])    &&
                  isset($_POST["endlocation"]) 			? true : false;


if ($all_fields_set) {

  $carpool_creator  = $_POST["carpool_creator"];
  $leave_date       = $_POST["leave_date"];
  $startloc					= $_POST["startlocation"];
  $endloc						= $_POST["endlocation"];
  $details 					= $_POST["details"];


  echo $leave_date;

	if ($stmt = $mysqli->prepare("insert into rides (carpool_creator, leave_date, startlocation, endlocation, open_to_passengers, details) values(?,?,?,?,true,?)")) {
		$stmt->bind_param("issss", $carpool_creator, $leave_date, $startloc, $endloc, $details);
		$stmt->execute();
		$stmt->close();
		$carpool_id = mysql_insert_id();
		echo '<p>Created. Ride ID = '.$carpool_id;

//TODOFUTURE MOVE ALL SQL TO DAO's
		if($carpool_id){
			if($passenger_stmt = $mysqli->prepare("INSERT into passengers values (?,?)")){
				$passenger_stmt->bind_param("ii",$carpool_id, $carpool_creator);
				$passenger_stmt->execute();
				$passenger_stmt->close();
			}else{
				echo 'insert into passengers failed';
			}
		}else{
			echo 'mysql_insert_id() failed';
		}
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

}
include("_footer.php");
?>
