<?php
include("db_init.php");
	$sqls = "SELECT carpool_id, carpool_creator, creator_onid, startlocation, endlocation, leave_date, description, start, end FROM rides WHERE (open_to_passengers = 1 AND leave_date > CURDATE())";
	if($results = $mysqli->prepare($sqls)){
		$results->execute();
		
		$results->bind_result($id, $uid, $conid, $sloc, $eloc, $ldate, $desc, $start, $end);
		$locations = array();
		$i = 0;
		while($results->fetch()){
			$locations[$i] = array($uid, $conid, $sloc, $eloc, $ldate, $desc, $start, $end, $id);
			$i++;
		}				
		$results->close();
		echo json_encode($locations);
	} else {
		echo "Ran into an error: " .$mysqli->error;
	}
	
	
$mysqli->close();
