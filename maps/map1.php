<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions Map</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }

	  .controls {
        background-color: #fff;
        border-radius: 2px;
        border: 1px solid transparent;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        box-sizing: border-box;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        height: 29px;
        margin-left: 17px;
        margin-top: 10px;
        outline: none;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      .controls:focus {
        border-color: #4d90fe;
      }

    </style>
  </head>
  <body>
    <div>
      <input id="start" class="controls" type="text"
        placeholder="Enter start">
      <input id="end" class="controls" type="text"
        placeholder="Enter destination">
      <input type="submit" id="submit">  
    </div>
    <div id="map"></div>

    <script>
function initMap() {
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 7,
    center: {lat: 41.85, lng: -87.65}
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
}

  function geo() {
    var geocoder1 = new google.maps.Geocoder();
    var geocoder2 = new google.maps.Geocoder();

    geocoder1.geocode( { 'address': document.getElementById('start').value}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var latlng1 = results[0].geometry.location;
	    document.getElementById("test1").innerHTML = latlng1;
		alert(document.getElementById("test1").innerHTML);
      } else {
        alert("Error occurred: " + status);
      }
    });

	geocoder2.geocode( { 'address': document.getElementById('end').value}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var latlng2 = results[0].geometry.location;
	    document.getElementById("test2").innerHTML = latlng2;
		alert(document.getElementById("test2").innerHTML);
      } else {
        alert("Error occurred: " + status);
      }
    });

  }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBec-tg3yBpOcZzd4ino_TbWGXh4PcaC54&libraries=places&sign_in=true&callback=initMap"
        async defer></script>
  <p id="test1"></p>
  <p id="test2"></p>
  </body>
</html>