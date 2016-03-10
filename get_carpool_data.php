<?php 
include("db_init.php");
if(isset($_GET['carpool_id'])){
	$cid = $_GET['carpool_id'];
	$sql = "SELECT * FROM `rides` WHERE carpool_id=?";
	
	if($results = $mysqli->prepare($sql)){
		$results->bind_param("i", $cid);
		$results->execute();
		$res = $results->get_result();
		$arr = $res->fetch_assoc();
		$results->close();
		
		echo json_encode($arr);
	}
} else {
	echo false;
}




?>