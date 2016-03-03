<?php
include("_header.php");
include("db_init.php");
echo "<h1>This is the browse page!</h1>";
?>

<link rel="stylesheet" type="text/css" href="css/browsestyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js"></script>

<section>
	<div id="posts">
		Search Bar Here
		<br>
		<ul id="info">
		</ul>
		<script>
			function locListender(){
				console.log(this.responseText);
			}
			
			$.ajax({
				type: 'POST',
				url: 'get_location_data.php',
				//data: variables to be sent
				success: function(json){
					var list = document.getElementById("info");
					/*
					for(i = 1; i <= 1000; i++){
						var entry = document.createElement('li');
						entry.appendChild(document.createTextNode(i + " -> " + json[i]));
						list.appendChild(entry);
					}
					*/
				}
			})
		</script>
	</div>
	<div id="details">Col2</div>
</section>


<script type="text/javascript">
	$(document).ready( function() {
		document.getElementById("browsepage").className += "active";
	});
	
	function getDist(lat1, lon1, lat2, lon2){
		var R = 6371; // Radius of the earth in km
		var dLat = deg2rad(lat2-lat1);  // deg2rad below
		var dLon = deg2rad(lon2-lon1); 
		var a = 
			Math.sin(dLat/2) * Math.sin(dLat/2) +
			Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
			Math.sin(dLon/2) * Math.sin(dLon/2); 
			
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
		var d = R * c; // Distance in km
		
		return d;
	}
	
	function deg2rad(deg) {
		return deg * (Math.PI/180)
	}
</script>
<?php
include("_footer.php");
?>