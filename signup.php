<html>
<style>
#errors {color:#FF0000;} <!-- makes bad-nickname error message red -->
</style>
</html>
<?php
include("_header.php");

if(checkAuth(true) != ""){
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

	if($data == 1){
		?>
		<script type="text/javascript">
			window.location.href = "http://web.engr.oregonstate.edu/~atkinsor/my_profile.php";
		</script>
		<?php
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

//Checks whether nickname is valid (only letters, nums, underscores ok)
function validate() {
	var bad = /^[\w ]+$/;
	if(!bad.test(document.myForm.nickname.value)) {
		document.getElementById("errors").innerHTML=" *Please use letters, numbers, and underscores only.";
		return false;
	}
}
</script>	
<h1>Signup!</h1>
<div class="signup">
	<h3 style="font-family: Arial, Helvetica, sans-serif;">You do not yet have an account. Please fill in the information below and click 'Continue'</h3>
	<p>User Information:</p>
	<form action="signup.php" method="POST" enctype="multipart/form-data" name="myForm" onsubmit="return validate();">
		Nickname: <input autofocus required type="text" name="nickname" maxlength="40">
		<span id="errors">
		</span>
		<br>I would like to be a: <br>
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
		Upload a profile picture: <br>
		<input type="file" name="fileToUpload" id="fileToUpload" onchange="previewFile()"><br>
		<img src="" height="200" alt="Image preview...">

	<script>
	function previewFile(){
       var preview = document.querySelector('img'); //selects the query named img
       var file    = document.querySelector('input[type=file]').files[0]; //sames as here
       var reader  = new FileReader();

       reader.onloadend = function () {
           preview.src = reader.result;
       }

       if (file) {
           reader.readAsDataURL(file); //reads the data as a URL
       } else {
           preview.src = "";
       }
	}
	previewFile();  //calls the function named previewFile()
	</script>
		<br>
		Bio:<br>
		<textarea rows="4" cols="50" placeholder="Enter a bit about yourself." name="bio" onKeyDown="charLimit(this.form.bio, this.form.countdown, 1000);"
		onKeyUp="charLimit(this.form.bio, this.form.countdown, 1000);"></textarea>
		<br>
		<input readonly type="text" name="countdown" value="1000"> characters left
		<br>
		<input type="checkbox" name="emailterms" value="eterms" required> I agree to let OSURides access my OSU provided information and use my OSU email for alerts.
		<br>
		<input class="buttonl" type="submit" name="continue" value="Continue">	
	</form>
</div>
<?php

	if(isset($_POST["continue"])){ //if form submitted okay,
		
		$rinfo = getAdvanced($_SESSION["onidid"]); //get their onid?
		
	$target_dir = "imgs/"; //get from this folder
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); //get that pic. temp place to store so we can check if legit 
	
	$uploadOk = 1; //assume upload is okay at first
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); //identify the file type of the pic 
	$final_dir = $target_dir.$rinfo["uid"].".".$imageFileType; //where it's going to go
	// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]); //get the size of the pic
		/*if($check !== false) { //yes, the picture provided DOES have a size; therefore it exists
			$uploadOk = 1;
		} else { //the picture doesn't have a size. 
			$uploadOk = 0;
		} */
	// Check if file already exists
	if (file_exists($final_dir)) { //IGNORE this; vestigial
		$uploadOk = 0;
	}
	// Check file size (if too big)
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if ($imageFileType != NULL) { //there is an image, it has a type, check the type
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
	}
	if($check !== false && $uploadOk != 0) { //yes, the picture provided DOES have a size; therefore it exists, and size/filetype both ok
			$avatar = $final_dir; //get what they gave you
			$uploadOk = 1;
	} 
	else { //the picture doesn't have a size. 
			$avatar = "imgs/cat.jpg"; //give them the cat
			$uploadOk = 1; //still set for upload
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "There was a problem uploading the avatar.";
	// if everything is ok, try to upload file
	} 
	else if ($avatar != "imgs/cat.jpg") { //uploadOk still passes, but avatar not the cat-- move their provided file
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $final_dir)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} 
		else {
			echo "Sorry, there was an error uploading your file.";
			$uploadOk = 0;
		}
	}
		
		if($uploadOk == 1){
		$status = 0;
		$seats = 0;
		if($_POST["status"] === "Driver" || $_POST["status"] === "Either"){
			$status = 1;
			$seats = $_POST["seats"];
		}
		
		//$avatar = $final_dir;
		$nickname = htmlspecialchars($_POST["nickname"]);
		$bio = htmlspecialchars($_POST["bio"]);
		$status = htmlspecialchars($_POST["status"]);
		$seats = htmlspecialchars($_POST["seats"]);
		
		$stmt = $mysqli->prepare("INSERT INTO users (onid_id, avatar_url_rel, name, nickname, bio, email, status, seats) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
		if(false===$stmt)
			echo "<br>prepare failed ". $mysqli->error;
		
		$rc = $stmt->bind_param("ssssssii", $rinfo["uid"], $avatar, $rinfo["cn"], $nickname, $bio, $rinfo["mail"], $status, $seats);
		if(false===$rc)
			echo "<br>bind_param failed ". $stmt->error;
		
		$rc = $stmt->execute();
		if(false===$rc)
			echo "<br>execute failed ". $stmt->error;
		
		$stmt->close();
		}
		
		$mysqli->close();
	}
}
	
include("_footer.php");
?>
