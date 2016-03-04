<?php
include("db_init.php");

		echo "Started";
		$min = -180;
		$max = 180;
		
	for($i = 0; $i < 1000; $i++){	
		$uid = 22;
		$sloc = frand(-90, 90, 6). "," . frand($min, $max, 6);
		$eloc = frand(-90, 90, 6) . "," . frand($min, $max, 6);
		
		$stmt = $mysqli->prepare("INSERT INTO rides (carpool_creator, startlocation, endlocation) VALUES(?, ?, ?)");
		if(false===$stmt)
			echo "<br>prepare failed ". $mysqli->error;
		
		$rc = $stmt->bind_param("sss", $uid, $sloc, $eloc);
		if(false===$rc)
			echo "<br>bind_param failed ". $stmt->error;
		
		$rc = $stmt->execute();
		if(false===$rc)
			echo "<br>execute failed ". $stmt->error;
		
		$stmt->close();
		echo "Generated: ". $i;
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