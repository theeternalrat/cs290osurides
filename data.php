<?php
include("db_init.php");

		echo "Started";
		$min = -180;
		$max = 180;
		
	for($i = 0; $i < 1000; $i++){	
		$uid = 22;
		$onid = 'atkinsor';
		$leave_date = '2016-05-05';
		$startloc = frand(-90, 90, 6). "," . frand($min, $max, 6);
		$endloc = frand(-90, 90, 6) . "," . frand($min, $max, 6);
		$descrip = "Im going to a place.";
		$start = "Street name here.";
		$end = "Street name here.";
		
		if ($stmt = $mysqli->prepare("insert into rides (carpool_creator, creator_onid, leave_date, startlocation, endlocation, open_to_passengers, description, start, end) values(?,?,?,?,?,true,?,?,?)")) {
		$rc = $stmt->bind_param("isssssss", $uid, $onid, $leave_date, $startloc, $endloc, $descrip, $start, $end);
		if($rc===false)
			echo "problem binding";
		$rc = $stmt->execute();
		if($rc===false)
			echo "problem executing".$stmt->error;
		$stmt->close();
		echo "Generated: ". $i;
		}
	}
	
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function frand($min, $max, $decimals = 0) {
  $scale = pow(10, $decimals);
  return mt_rand($min * $scale, $max * $scale) / $scale;
}

echo "Ended";