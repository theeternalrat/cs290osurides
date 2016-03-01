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

<h1>ADD REVIEW</h1>

<form method="post" action='add_review_recieve.php' class="inform">
<ul>
<li><label>ID:</label> <input type="number" name="id" oninput="validity.valid||(value='');" min=0 required>
<li><label>Driver or Passenger:</label>
<select name="Spot">
 <option value="DRIVER">Driver</option>
 <option value="PASSENGER">Passenger</option>
</select>
<li><label>Score (0 to 5):</label> <input type="number" name="user_score" oninput="validity.valid||(value='');" min=0 max=5 required>
<li><label>Recommend?:</label> <input type="checkbox" name="recommend">Yes
<li><label>Comments:<br></label> <textarea name="description" rows="4" cols="50" onKeyDown="charLimit(this.form.description, this.form.countdown, 1000);"
	onKeyUp="charLimit(this.form.description, this.form.countdown, 1000);" placeholder="Describe your experience with this person."></textarea>
<br><input readonly type="text" name="countdown" value="1000"> characters left
<li><input type=submit>
</ul>
</form>


<?php include("_footer.php");?>
