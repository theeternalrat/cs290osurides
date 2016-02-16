<?php
	include("_header.php");

	if (checkAuth(true) != "") {
		echo "<div class=\"main\"><h1>This is the settings page! You've been authenticated.</h1></div>";
		//echo "<h1>Your ID is:".$_SESSION("onidid")."</h1>";
?>
	<script type="text/javascript">
	$(document).ready( function() {
		document.getElementById("settingspage").className += "active";
	});
	</script>
<html>
<body>

<h1>My Profile</h1>

<p>Average driver rating: </p>
<p>Average passenger rating: </p>

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
	<!-- Will hide this subform from passengers later -->
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
?>
</body>
</html>

<?php
	}	
	ini_set('display_errors', 'On');
	include("_footer.php");
?>

