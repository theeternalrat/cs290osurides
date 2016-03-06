<?php
include("db_init.php");
	$sqls = "SELECT carpool_id, carpool_creator, startlocation, endlocation FROM rides WHERE leave_date > CURDATE() LIMIT 1000";
	if($results = $mysqli->prepare($sqls)){
		$results->execute();
		
		$results->bind_result($id, $uid, $sloc, $eloc);
		$locations = array();
		while($results->fetch()){
			$locations[$id] = array($uid, $sloc, $eloc);
		}				
		$results->close();
	}
	
	echo json_encode($locations);
$mysqli->close();
