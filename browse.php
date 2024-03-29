<?php
include("_header.php");

if(checkAuth(true) != ""){

include("db_init.php");
include("set_session.php");
?>

<h1>Search for a Carpool</h1>
 
<link rel="stylesheet" type="text/css" href="css/browsestyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js"></script>
<script src="http://web.engr.oregonstate.edu/~atkinsor/js/mapsjs.js"></script>

<section>
	<div id="posts" class="browse_map">
		<input id="pac-input" class="controls" type="text" placeholder="Enter a destination.">
		
		<br>
		<div id="info">
		</div>
	</div>
	<div id="details" class="browse_map">
		<div id="map"></div>
		</script>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNrGItIuCmHf62lBSfz83By7enQQXWJTc&libraries=places&sign_in=true&callback=initMap"
				async defer>
		</script>
		<div id="dataDiv">
		
		</div>
	</div>
</section>


<script type="text/javascript">
	$(document).ready( function() {
		document.getElementById("browsepage").className += "active";
	});
</script>
<?php
}
include("_footer.php");
?>
