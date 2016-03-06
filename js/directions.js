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
	if(document.getElementById("startloc").value == "")
		return false;
	else if(document.getElementById("endloc").value == "")
		return false;
	else
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