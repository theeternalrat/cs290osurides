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

if (isset($_POST["id"])) {
	$id = $_POST["id"];//$_POST["recommend"]
} else {
	echo 'ERROR! User id field is unset.';
}

// ok, we can just insert the record
//TODO test bind id
if ($stmt = $mysqli->prepare("insert into reviews (pk_id, recommend) values(?,?)")) {
	$stmt->bind_param("ii", $i, $recommend);
	$stmt->execute();
	$stmt->close();
	echo '<p>Created...';
} else {
	printf("Error: %s\n", $mysqli->error);
}
?>

<?php
mysqli_close($mysqli);
include("_footer.php");
?>
