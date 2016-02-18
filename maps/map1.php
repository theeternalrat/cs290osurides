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
      <input id="pac-input1" class="controls" type="text"
        placeholder="Enter start">
	<input id="pac-input2" class="controls" type="text"
        placeholder="Enter destination">
    </select>
    </div>
    <div id="map"></div>

    <script>
function initMap() {
  var start = document.getElementById('pac-input1');
  var end = document.getElementById('pac-input2');
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

    startAutocomplete.addListener('place_changed', function() {
    var place = startAutocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

	calculateAndDisplayRoute(directionsService, directionsDisplay);

    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(10);
    }

	});

	endAutocomplete.addListener('place_changed', function() {
    var place = endAutocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

	calculateAndDisplayRoute(directionsService, directionsDisplay);

    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(10);
    }

	});

  document.getElementById('start').addEventListener('change', startAutocomplete);
  document.getElementById('end').addEventListener('change', endAutocomplete);
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
  directionsService.route({
    origin: document.getElementById('start'),
    destination: document.getElementById('end'),
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBec-tg3yBpOcZzd4ino_TbWGXh4PcaC54&libraries=places&sign_in=true&callback=initMap"
        async defer></script>
  </body>
</html>


//calculateAndDisplayRoute(directionsService, directionsDisplay);