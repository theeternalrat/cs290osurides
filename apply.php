<?php
include("_header.php");
include("db_init.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//TODO FINISH THIS CARPOOL APPLICATION APPLY POST FORM

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

$all_fields_set = isset($_POST["id"]) && isset($_POST["Spot"]) && isset($_POST["user_score"]) ? true : false;

if ($all_fields_set) {

	$ride_id			  = $_POST["id"];
	$uid            = $_POST["Spot"];
	$description    = $_POST["user_score"];

	if ($stmt = $mysqli->prepare("insert into carpool_applications (ride_id_fk, applicant_uid_fk, decision_status, description) values(?,?,PENDING,?)")) {
		$stmt->bind_param("iis", $ride_id, $uid, $description);
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
