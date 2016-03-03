<?php
include("db_init.php");

		echo "Started";
		$min = -180;
		$max = 180;
		
	for($i = 0; $i < 1000; $i++){	
		$uid = generateRandomString(7);
		$sloc = mt_rand($min*10, $max*10)/10;
		$eloc = mt_rand($min*10, $max*10)/10;
		
		$stmt = $mysqli->prepare("INSERT INTO posts (userid, startlocation, endlocation) VALUES(?, ?, ?)");
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

echo "Ended";