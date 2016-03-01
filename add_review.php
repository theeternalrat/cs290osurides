<?php include("_header.php");?>

<h1>ADD REVIEW</h1>

<form method="post" action='add_review_recieve.php' class="inform">
<ul>
<li><label>ID:</label> <input type="number" name="id" oninput="validity.valid||(value='');" min=0 required>
<li><label>Driver or Passenger:</label>
<select name="Spot">
 <option value="DRIVER">Driver</option>
 <option value="PASSENGER">Passenger</option>
</select>
<li><label>Score:</label> <input type="number" name="user_score" required>
<li><label>Recommend?:</label> <input type="checkbox" name="recommend">
<li><label>Description:</label> <input type="text" name="description">
<li><input type=submit>
</ul>
</form>


<?php include("_footer.php");?>
