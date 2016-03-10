<?php
include("_header.php");

if(checkAuth(true) != ""){

include("db_init.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//TODOFUTURE MOVE ALL SQL TO DAO's
?>

<h1>Saving your decision...</h1>

<?php
print_r($_REQUEST);

if (isset($_POST["app_id"])) {
	$app_id = $_POST["app_id"];//$_POST["recommend"]
} else {
	echo 'ERROR: app_id field unset';
}

if (isset($_POST["decision_status"])) {
	$decision_status = $_POST["decision_status"];
} else {
	echo 'ERROR: decision_status field unset';
}

//TODO LIMIT PASSENGER ADMISSION TO TOTAL NUMBER OF CARPOOL SPOTS
$all_fields_set = isset($_POST["app_id"]) && isset($_POST["decision_status"]) ? true : false;

if ($all_fields_set) {
	if ($stmt = $mysqli->prepare("UPDATE carpool_applications SET `decision_status` = ? WHERE `app_id`= ?")) {
		$stmt->bind_param("si", $decision_status, $app_id);
		$stmt->execute();
		$stmt->close();
		echo '<p>Created...';
	} else {
		printf("Error: %s\n", $mysqli->error);
	}
}else {
	echo 'Fields are unset';
}
?>

<?php
mysqli_close($mysqli);

}
include("_footer.php");
?>
