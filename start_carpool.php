<?php include("_header.php");?>

<script src="http://web.engr.oregonstate.edu/~atkinsor/js/directions.js"></script>
<link rel="stylesheet" type="text/css" href="css/browsestyle.css">
<h1>Start a new carpool</h1>

 <div>
      <input id="start" class="controls" type="text"
        placeholder="Enter start">
      <input id="end" class="controls" type="text"
        placeholder="Enter destination">
      <input type="submit" id="submit" value="Get Directions">  
    </div>

<form method="post" action='start_carpool_recieve.php' class="inform">
    <div id="map" style="margin:10px; height: 50%; width:50%;"></div>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBec-tg3yBpOcZzd4ino_TbWGXh4PcaC54&libraries=places&sign_in=true&callback=initMap"
        async defer></script>
<ul>
<li><label>Carpool Creator ID:</label> <input class="controls" type="number" name="carpool_creator" oninput="validity.valid||(value='');" min=0 required>
<li><label>Departure date:</label> <input class="controls" type="text" name="leave_date" placeholder="YYYY-MM-DD" required>
<p id="test1" hidden></p>
<p id="test2" hidden></p>
<br>
<input type=submit>
</ul>
</form>

<?php include("_footer.php");?>
