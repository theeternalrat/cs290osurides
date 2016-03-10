<?php
require_once("db_init.php");


			$sql = "SELECT pk_id FROM `users` WHERE onid_id=?";
			if($stmt = $mysqli->prepare($sql)){
				$stmt->bind_param("s", $_SESSION["onidid"]);
				$stmt->execute();
				$stmt->bind_result($uid);
				$stmt->fetch();
				$stmt->close();
				
				$_SESSION["uid"] = $uid;
			}
