<?php include("_header.php");?>


<h1>Start a new carpool</h1>

<form method="post" action='start_carpool_recieve.php' class="inform">
<ul>
<li><label>Carpool Creator ID:</label> <input type="number" name="carpool_creator" oninput="validity.valid||(value='');" min=0 required>
<li><label>Leave date:</label> <input type="text" name="leave_date" placeholder="YYYY-MM-DD" required>
<li><label>Origin Latitude:</label> <input type="number" name="from_lat" required>
<li><label>Origin Longitude:</label> <input type="number" name="from_long" required>
<li><label>Destination Latitude:</label> <input type="number" name="destination_lat" required>
<li><label>Destination Longitude:</label> <input type="number" name="destination_long" required>
<li><input type=submit>
</ul>
</form>

<?php include("_footer.php");?>
