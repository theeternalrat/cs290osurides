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

if (isset($_POST["recommend"])) {
	$recommend = "1";//$_POST["recommend"]
} else {
	$recommend = "0";
}

if (isset($_POST["description"])) {
	$description = $_POST["description"];
} else {
	$description = "N/A";
}

//TODO LIMIT PASSENGER ADMISSION TO TOTAL NUMBER OF CARPOOL SPOTS
$all_fields_set = isset($_POST["ride_id"]) && isset($_POST["uid"]) ? true : false;

if ($all_fields_set) {

	$ride_id			  = $_POST["ride_id"];
	$uid            = $_POST["uid"];
	$description    = $_POST["description"];

	if ($stmt = $mysqli->prepare("insert into carpool_applications (ride_id_fk, applicant_uid_fk, decision_status, description) values(?,?,'PENDING',?)")) {
		$stmt->bind_param("iis", $ride_id, $uid, $description);
		$stmt->execute();
		$stmt->close();
		echo '<p>Created...';

//TODOFUTURE MOVE ALL SQL TO DAO's
		if($ride_id){
			if($passenger_stmt = $mysqli->prepare("INSERT into passengers values (?,?)")){
				$passenger_stmt->bind_param("ii",$ride_id, $uid);
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
}
?>

<?php
mysqli_close($mysqli);
include("_footer.php");
?>
