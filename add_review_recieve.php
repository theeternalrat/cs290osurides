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

$all_fields_set = isset($_POST["id"]) && isset($_POST["Spot"]) && isset($_POST["user_score"]) && isset($_POST["description"]) ? true : false;

if ($all_fields_set) {

	$id						= $_POST["id"];
	$driver_enum  = $_POST["Spot"];
	$score        = $_POST["user_score"];
	$description  = $_POST["description"];

	if ($stmt = $mysqli->prepare("insert into reviews (pk_id, driver_enum, score, recommend, description) values(?,?,?,?,?)")) {
		$stmt->bind_param("isiis", $id, $driver_enum, $score, $recommend, $description);
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
