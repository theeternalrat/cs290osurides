<?php
include("db_init.php");
	$sqls = "SELECT carpool_id, carpool_creator, startlocation, endlocation, description, start, end FROM rides WHERE (open_to_passengers = 1 AND leave_date > CURDATE()) LIMIT 1000";
	if($results = $mysqli->prepare($sqls)){
		$results->execute();
		
		$results->bind_result($id, $uid, $sloc, $eloc, $desc, $start, $end);
		$locations = array();
		while($results->fetch()){
			$locations[$id] = array($uid, $sloc, $eloc, $desc, $start, $end);
		}				
		$results->close();
		echo json_encode($locations);
	} else {
		echo "Ran into an error: " .$mysqli->error;
	}
	
	
$mysqli->close();
