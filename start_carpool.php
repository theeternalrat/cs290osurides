<?php include("_header.php");?>

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
</script>

<h1>Start a new carpool</h1>

<form method="post" action='start_carpool_recieve.php' class="inform">
<ul>
<li><label>Carpool Creator ID:</label> <input type="number" name="carpool_creator" oninput="validity.valid||(value='');" min=0 required>
<li><label>Leave date:</label> <input type="text" name="leave_date" placeholder="YYYY-MM-DD" required>
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

<?php include("_footer.php");?>
