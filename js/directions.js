function initMap() {
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 14,
    center: {lat: 44.563665, lng:  -123.279806}
  });
  directionsDisplay.setMap(map);
  var startAutocomplete = new google.maps.places.Autocomplete(start);
  startAutocomplete.bindTo('bounds', map);
  var endAutocomplete = new google.maps.places.Autocomplete(end);
  endAutocomplete.bindTo('bounds', map);
  document.getElementById('submit').addEventListener('click', function() {
    calculateAndDisplayRoute(directionsService, directionsDisplay);
    geo();
  });
}
function calculateAndDisplayRoute(directionsService, directionsDisplay) {	
  directionsService.route({
    origin: document.getElementById('start').value,
    destination: document.getElementById('end').value,
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
  
  document.getElementById('startlocs').value = document.getElementById('start').value;
	document.getElementById('endlocs').value = document.getElementById('end').value;
}
  function geo() {
    var geocoder1 = new google.maps.Geocoder();
    var geocoder2 = new google.maps.Geocoder();
    geocoder1.geocode( { 'address': document.getElementById('start').value}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var latlng1 = results[0].geometry.location;
		var start = latlng1.lat() + "," + latlng1.lng();
	    document.getElementById("startloc").value = start;
      } else {
        alert("Error occurred: " + status);
      }
    });
	geocoder2.geocode( { 'address': document.getElementById('end').value}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var latlng2 = results[0].geometry.location;
		var dest = latlng2.lat() + "," + latlng2.lng()
	    document.getElementById("endloc").value = dest;
      } else {
        alert("Error occurred: " + status);
      }
    });
  }
  
 function validateForm(){
	 //check if they entered start/end loc
	if(document.getElementById("startloc").value == "") {
		alert("Please submit your starting and ending locations before continuing with the rest of the form.");
		return false;
 }
	else if(document.getElementById("endloc").value == "") {
		alert("Please submit your starting and ending locations before continuing with the rest of the form.");
		return false;
	}
	
	//check leave date
	var date = /^(\d{4})\-(\d{2})\-(\d{2})$/;
	//check if they entered the right format
	if(!date.test(document.carpool.leave_date.value)) {
		document.getElementById("errors").innerHTML=" *Date must be in YYYY-MM-DD format. Enter 0s as necessary.";
		return false;
	}
	//bounds checking
	else {
		str = document.carpool.leave_date.value;
		year = str[0] + str[1] + str[2] + str[3];
		month = str[5] + str[6];
		day = str[8] + str[9];
		today = new Date();
		upper = today.getFullYear() + 4;
		if (year < today.getFullYear() || year > upper) {
			document.getElementById("errors").innerHTML=" *Year must be between " + today.getFullYear() + " and " + upper + ".";
			return false;
		}
		if (month < 1 || month > 12) {
				document.getElementById("errors").innerHTML=" *Month must be between 01 and 12.";
				return false;
			}
		if (day < 1 || day > 31) {
				document.getElementById("errors").innerHTML=" *Day must be between 01 and 31.";
				return false;
			}
		else if (year == today.getFullYear()) {
			if (month < today.getMonth() + 1) {
				document.getElementById("errors").innerHTML=" *That month has already passed.";
				return false;
			}
			else if (month == today.getMonth() + 1) {
				if (day < today.getDate()) {
					document.getElementById("errors").innerHTML=" *That day has already passed.";
					return false;
				}
			}
		}
	} 
	return true;
} 

function charLimit(field, count, max) {
	if(field.value.length > max) {
		field.value = field.value.substring(0, max);
	}
	else {
		count.value = max - field.value.length;
	}
}