<?php
include("_header.php");
include("db_init.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<h1>Saving your submission...</h1>

<?php
if (isset($_POST["recommend"])){
  $recommend         = $_POST["recommend"];

	$errorMsg = "";
	if ($recommend == "") {
		$errorMsg = "Please go back and enter all params.";
	}

	if ($errorMsg == "") {
		// ok, we can just insert the record
    //TODO bind id
		if ($stmt = $mysqli->prepare("insert into reviews (pk_id, recommend) values(1,?)")) {
			$stmt->bind_param("i", $recommend);
	    $stmt->execute();
			$stmt->close();
			echo '<p>Created...';
		} else {
	  		printf("Error: %s\n", $mysqli->error);
		}
	} else {
		echo "<h4 class='error'>".htmlspecialchars($errorMsg)."</h4>";
	}
}else{
  echo 'error';
}

?>

<?php
mysqli_close($mysqli);
include("_footer.php");
?>