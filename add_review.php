<?php include("_header.php");?>

<h1>ADD REVIEW</h1>

<form method="post" action='add_review_recieve.php' class="inform">
<ul>
<li><label>ID:</label> <input type="number" name="id">
<li><label>Driver or Passenger:</label> <input type="text" name="driverorpassenger">
<li><label>Score:</label> <input type="number" name="user_score">
<li><label>Recommend?:</label> <input type="number" name="recommend">
<li><label>Description:</label> <input type="text" name="description">
<li><input type=submit>
</ul>
</form>


<?php include("_footer.php");?>
