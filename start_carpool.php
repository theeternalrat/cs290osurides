<?php include("_header.php");?>
<html>
<head>
<style>
#errors {color: #FF0000;}
</style>

<script src="http://web.engr.oregonstate.edu/~atkinsor/js/directions.js"></script>
<link rel="stylesheet" type="text/css" href="css/browsestyle.css">
<h1>Start a new Carpool</h1>
<div class= "makecpool">
		<div>
		  <input id="start" class="controls" type="text" placeholder="Enter start">
		  <input id="end" class="controls" type="text" placeholder="Enter destination">
		  <input type="submit" id="submit" value="Get Directions" class="button">  
		</div>
		
		<form method="post" name="carpool" action='start_carpool_recieve.php' class="inform" onsubmit="return validateForm()">
			<div id="map" style="margin:10px; height: 50%; width:50%;" class="allignl"></div>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBec-tg3yBpOcZzd4ino_TbWGXh4PcaC54&libraries=places&sign_in=true&callback=initMap"
				async defer></script>
					
	<div class="allignr">			
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
		<li><input class="button" type=submit>
		</ul>
		Description:<br>
			<textarea rows="4" cols="50" placeholder="Enter a bit about your trip." name="descrip" onKeyDown="charLimit(this.form.bio, this.form.countdown, 1000);"
			onKeyUp="charLimit(this.form.bio, this.form.countdown, 1000);"></textarea><br>
		<input type="text" name="startlocation" id="startloc" hidden novalidate>
		<input type="text" name="endlocation" id="endloc" hidden novalidate>
		<input type="text" name="startlocationstring" id="startlocs" hidden novalidate>
		<input type="text" name="endlocationstring" id="endlocs" hidden novalidate>
		<input class="button" type=submit>
		</form>
	</div>	
</div>
<?php include("_footer.php");?>
