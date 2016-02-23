<?php
	include("_header.php");

	if (checkAuth(true) != "") {		
	include("db_init.php");
	
	$sqlq = "SELECT COUNT(*) FROM users WHERE onid_id=?";
	if($results = $mysqli->prepare($sqlq)){
		$ref = $_SESSION["onidid"];
		$results->bind_param("s", $ref);
		$results->execute();
		
		$results->bind_result($data);
		$results->fetch();
		$results->close();
	}

	if($data == 0){
		?>
		<script type="text/javascript">
			window.location.href = "http://web.engr.oregonstate.edu/~atkinsor/signup.php";
		</script>
<?php
	} else {
		if($results = $mysqli->prepare("SELECT * FROM users WHERE onid_id=?")){
			$results->bind_param("s", $_SESSION["onidid"]);
			$results->execute();
			$results->bind_result($id, $onid, $avatar, $name, $nickname, $bio, $email, $status, $seats, $raiting);
			$results->fetch();
			$results->close();
		}
	}
?>
	<script type="text/javascript">
	$(document).ready( function() {
		document.getElementById("settingspage").className += "active";
	});
	</script>
<html>
<body>

<h1>My Profile</h1>

<p>Average Rating: <?php echo $raiting; ?></p>

<?php /*

<script type="text/javascript">
function statusCheck() {
	if(document.getElementById('driverCheck').checked || document.getElementById('eitherCheck').checked) {
		document.getElementById('ifDriver').style.visibility = 'visible';
	}
	else 
		document.getElementById('ifDriver').style.visibility = 'hidden';
}
</script>	

<p>Make a post:</p>
<form action="settings.php" method="POST">
	Starting location: <input type="text" name="start">
	<br>
	Destination: <input type="text" name="end">
	<br>
	<!-- Note: maybe change status values to easy ints? -->
	I would like to be a: <br>
	<input type="radio" name="status" value="Driver" onclick="javascript:statusCheck();" id="driverCheck">Driver<br>
	<input type="radio" name="status" value="Passenger" onclick="javascript:statusCheck();" id="passCheck">Passenger<br>
	<input type="radio" name="status" value="Either" onclick="javascript:statusCheck();" id="eitherCheck">Either<br>
		<div id="ifDriver" style="visibility:hidden">
	Seats available: <select name="seats">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value=">=10">10+</option>
	</select>
	</div>
	<br>
	Comments: <textarea name="comments"></textarea><br>
	<br>
	<input type="submit" name="submit" value="Make post">
</form>

<?php 
	echo "Your post: "; 
	echo "<br><br>";
	echo $_POST["start"];
	echo "<br>";
	echo $_POST["end"];
	echo "<br>";
	echo $_POST["status"];
	echo "<br>";
	if ($_POST["status"] === "Driver" || $_POST["status"] === "Either") {
		echo $_POST["seats"];	
		echo "<br>";
	}
	echo $_POST["comments"];
	echo "<br><br>";
	*/
	
	$mysqli->close();
?>

<?php
	}	
	ini_set('display_errors', 'On');
	include("_footer.php");
?>

