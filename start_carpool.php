<?php include("_header.php");?>
<html>
<head>
<style>
#errors {color: #FF0000;}
</style>

<script type="text/javascript">
//Lets user know how many chars they have left
function charLimit(field, count, max) {
	if(field.value.length > max) {
		field.value = field.value.substring(0, max);
	}
	else {
		count.value = max - field.value.length;
	}
}
function checkDate() {
	var date = /^(\d{2})\/(\d{2})\/(\d{4})$/;
	//check if they entered the right format
	if(!date.test(document.myForm.leave_date.value)) {
		document.getElementById("errors").innerHTML=" *Date must be in MM/DD/YYYY format. Enter 0s as necessary.";
		return false;
	}
	//bounds checking
	else {
		str = document.myForm.leave_date.value;
		month = str[0] + str[1];
		day = str[3] + str[4];
		year = str[6] + str[7] + str[8] + str[9];
		today = new Date();
		upper = today.getFullYear() + 4;
		console.log(upper);
		if (year < today.getFullYear() || year > upper) {
			document.getElementById("errors").innerHTML=" *Year must be between " + today.getFullYear() + " and " + upper + ".";
			return false;
		}
		if (month < 1 || month > 12) {
				document.getElementById("errors").innerHTML=" *Month must be between 01 and 12.";
				return false;
			}
		if (day < 1 || day > 31) {
				document.getElementById("errors").innerHTML=" *Day must be between 01 and 31.";
				return false;
			}
		else if (year == today.getFullYear()) {
			if (month < today.getMonth() + 1) {
				document.getElementById("errors").innerHTML=" *That month has already passed.";
				return false;
			}
			else if (month == today.getMonth() + 1) {
				if (day < today.getDate()) {
					document.getElementById("errors").innerHTML=" *That day has already passed.";
					return false;
				}
			}
		}
	} 
	return true;
} 
</script>
</head>
<body>
<h1>Start a new carpool</h1>

<form method="post" action='start_carpool_recieve.php' class="inform" name='myForm' onsubmit='return checkDate();'>
<ul>
<li><label>Carpool Creator ID:</label> <input type="number" name="carpool_creator" oninput="validity.valid||(value='');" min=0 required>
<li><label>Leave date:</label> <input type="text" name="leave_date" placeholder="MM-DD-YYYY" required>
<span id="errors">
</span>
<li><label>Origin Latitude:</label> <input type="number" name="from_lat" required>
<li><label>Origin Longitude:</label> <input type="number" name="from_long" required>
<li><label>Destination Latitude:</label> <input type="number" name="destination_lat" required>
<li><label>Destination Longitude:</label> <input type="number" name="destination_long" required>
<li><label>Details:<br></label> <textarea name="details" rows="4" cols="50" onKeyDown="charLimit(this.form.details, this.form.countdown, 500);"
	onKeyUp="charLimit(this.form.details, this.form.countdown, 500);" placeholder="Other info you would like your passengers to know"></textarea>
<br><input readonly type="text" name="countdown" value="500"> characters left
<li><input type=submit>
</ul>
</form>
</body>
</html>
<?php include("_footer.php");?>