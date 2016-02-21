<html>
<head>
<style>
.error {color:#FF0000;}
</style>
</head>
<body>

<?php
include("_header.php");

//error flags:
$nickErr = "";
//vars
$nickname = $bio = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$nickname = test_input($_POST["nickname"]);
	if (!preg_match("/^[A-Za-z0-9_-]+$/", $nickname)){
		$nickErr = "Only letters, numbers, underscores/dashes allowed";
	}
	if (empty($_POST["bio"])) {
		$bio = "";
	}
	else {
		$bio = test_input($_POST["bio"]);
	}
}

//strips preceding/trailing whitespace/slashes + does htmlspecialchars
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<script type="text/javascript">
//Hides seats dropdown if passenger 
function statusCheck() {
	if(document.getElementById('driverCheck').checked || document.getElementById('eitherCheck').checked) {
		document.getElementById('ifDriver').style.visibility = 'visible';
	}
	else 
		document.getElementById('ifDriver').style.visibility = 'hidden';
}

//Lets user know how many chars they have left
function charLimit(field, count, max) {
	if(field.value.length > max) {
		field.value = field.value.substring(0, max);
	}
	else {
		count.value = max - field.value.length;
	}
}
</script>	

<h1>Signup!</h1>
<h3>You do not yet have an account. Please fill in the information below and click 'Continue'</h3>
<p>User Information:</p>
<form action="signup.php" method="POST">
	Nickname: <input autofocus required type="text" name="nickname" value="<?php echo $nick;?>"><span class="error"><?php echo $nickErr;?></span>
	<br>
	I would like to be a: <br>
	<input type="radio" name="status" value="Driver" onclick="javascript:statusCheck();" id="driverCheck" required>Driver<br>
	<input type="radio" name="status" value="Passenger" onclick="javascript:statusCheck();" id="passCheck">Passenger<br>
	<input type="radio" name="status" value="Either" onclick="javascript:statusCheck();" id="eitherCheck">Either<br>
		<div id="ifDriver" style="visibility:hidden">
	Seats available (not including you): <select name="seats">
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
	Bio:<br>
	<textarea rows="4" cols="50" placeholder="Enter a bit about yourself." name="bio" onKeyDown="charLimit(this.form.bio, this.form.countdown, 1000);"
	onKeyUp="charLimit(this.form.bio, this.form.countdown, 1000);"><?php echo $bio;?></textarea>
	<br>
	<input readonly type="text" name="countdown" value="1000"> characters left
	<br>
	<input type="checkbox" name="emailterms" value="eterms" required> I agree to let OSURides access my OSU provided information and use my OSU email for alerts.
	<br>
	<input type="submit" name="continue" value="Continue">	
</form>

<?php
	$status = 0;
	$seats = 0;
	if($_POST["status"] === "Driver" || $_POST["status"] === "Either"){
		$status = 1;
		$seats = $_POST["seats"];
	}
	
	getAdvanced();
	
	include("db_init.php");
	$sql = "INSERT INTO users (onid_id, avatar_url_rel, name, nickname, bio, email, status, steats VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
	if($result = $mysqli->prepare($sql)){
		$results->bind_param("issssii", $onid, $avatar, $name, $nickname, $bio, $email, $status, $seats);
		$results->execute();
	}

include("_footer.php");
?>

</body>
</html>