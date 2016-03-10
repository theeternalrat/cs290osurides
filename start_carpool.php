<?php include("_header.php");?>
<style>
#errors {color: #FF0000;}
</style>
<link rel="stylesheet" type="text/css" href="css/browsestyle.css">
<script src="http://web.engr.oregonstate.edu/~atkinsor/js/directions.js">
</script>

<h1>Start a new carpool</h1>

 <div>
      <input id="start" class="controls" type="text" placeholder="Enter start">
      <input id="end" class="controls" type="text" placeholder="Enter destination">
      <input type="submit" id="submit" value="Get Directions">  
    </div>

<form method="post" name="carpool" action='start_carpool_recieve.php' class="inform" onsubmit="return validateForm();">
    <div id="map" style="margin:10px; height: 50%; width:50%;"></div>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBec-tg3yBpOcZzd4ino_TbWGXh4PcaC54&libraries=places&sign_in=true&callback=initMap"
        async defer></script>
<input type="number" name="carpool_creator" value='<?php echo $_SESSION['uid'];  ?>' hidden>
<label>Leave date:</label> <input type="text" name="leave_date" placeholder="YYYY-MM-DD" required><br>
<span id="errors">
</span>
<br>
Description:<br>
	<textarea rows="4" cols="50" placeholder="Enter a bit about your trip." name="descrip" onKeyDown="charLimit(this.form.bio, this.form.countdown, 1000);"
	onKeyUp="charLimit(this.form.bio, this.form.countdown, 1000);"></textarea><br>
<input type="text" name="startlocation" id="startloc" hidden novalidate>
<input type="text" name="endlocation" id="endloc" hidden novalidate>
<input type="text" name="startlocationstring" id="startlocs" hidden novalidate>
<input type="text" name="endlocationstring" id="endlocs" hidden novalidate>
<input type="text" name="creator_onid" id="creator_onid" hidden novalidate value='<?php echo $_SESSION['onidid'];?>'>
<input type=submit>
</form>

<?php include("_footer.php");?>
