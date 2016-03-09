var map;
var marker;
var destinationMarker;

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 44.00, lng: -120.5},
    zoom: 6
  });
  var destination = document.getElementById('pac-input');
  var destinationAutocomplete = new google.maps.places.Autocomplete(destination);
  destinationAutocomplete.bindTo('bounds', map);
  var destinationInfowindow = new google.maps.InfoWindow();
  destinationMarker = new google.maps.Marker({
    map: map
  });
  destinationMarker.addListener('click', function() {
    destinationInfowindow.open(map, destinationMarker);
  });
  destinationAutocomplete.addListener('place_changed', function() {
    destinationInfowindow.close();
    var place = destinationAutocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }
    // Set the position of the marker using the place ID and location.
    destinationMarker.setPlace({
      placeId: place.place_id,
      location: place.geometry.location
    });
    destinationMarker.setVisible(true);
    destinationInfowindow.setContent('<div><strong>' + place.formatted_address + '</strong>');
    destinationInfowindow.open(map, destinationMarker);
	
	
	
	$.ajax({
	type: 'POST',
	url: 'get_location_data.php',
	//data: variables to be sent
	success: function(json){
		var list = document.getElementById("info");
		try{
		var obj = JSON.parse(json);
		}catch(e){
			console.log(e);
			console.log(json);
		}
		var destLat = destinationMarker.place.location.lat();
		var destLon = destinationMarker.place.location.lng();
		
		while(list.firstChild){
			list.removeChild(list.firstChild);
		}
		
		var latlng = new google.maps.LatLng(destLat, destLon);
		destinationMarker.setPosition(latlng);
		
		
		var array = $.map(obj, function(value, index){
			return [value];
		});
		
		array.sort(function(a,b){
			var loca = a[2].split(",");
			var locb = b[2].split(",");
			
			var distA = getDist(destLat, destLon, parseFloat(loca[0]), parseFloat(loca[1]));
			var distB = getDist(destLat, destLon, parseFloat(locb[0]), parseFloat(locb[1]));
			return distA - distB;
		});
		
		var geocoder = new google.maps.Geocoder;
		for(i = 0; i < array.length; i++){
			var locations = array[i][2].split(",");
			var radio = makeRadioButton('dots', locations, array[i][0], locations, geocoder);
			list.appendChild(radio);
			var linebreak = document.createElement("br");
			list.appendChild(linebreak);
		}
	},
	error: function(idk, status, error){
		console.log(idk);
		console.log("Status: " + status);
		console.log("Error: " + error);
	}
  });
  });
  marker = new google.maps.Marker({map : map});
}


function makeRadioButton(name, value, text, endloc, geocoder) {

    var label = document.createElement("label");
    var radio = document.createElement("input");
    radio.type = "radio";
    radio.name = name;
    radio.value = value;
	radio.id = "buttons";
	radio.onclick = function() {movePointer(endloc)};

    label.appendChild(radio);
	var text = document.createTextNode("");
	label.appendChild(text);
	var addr = getName(geocoder, value, text);
    
    return label;
}

function getName(geocoder, latlng, text){
	var ll = {lat: parseFloat(latlng[0]), lng: parseFloat(latlng[1])};
	var address;
	geocoder.geocode({'location': ll}, function(results, status){
		if(status == google.maps.GeocoderStatus.OK){
			text.nodeValue = results[1].formatted_address;
		} else {
			text.nodeValue = "No address found.";
		}
	});
}

function movePointer(endloc){
	var lat = parseFloat(endloc[0]);
	var lon = parseFloat(endloc[1]);
	var latlng = new google.maps.LatLng(lat, lon);
	//marker = new google.maps.Marker({map: map, position: latlng});
	marker.setPosition(latlng);
	
	var markers= [marker, destinationMarker];
	var bounds = new google.maps.LatLngBounds();
	for(var i = 0; i < markers.length; i++){
		bounds.extend(markers[i].getPosition());
	}
	
	map.fitBounds(bounds);
}

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

function geo(placeID){
	var geocoder = new google.maps.Geocoder();
	var location;
	geocoder.geocode({location: placeID}, function(results, status){
	if (status == google.maps.GeocoderStatus.OK) {
		location = results[0].geometry.location;
    } else {
		alert("Error occurred: " + status);
    }
	});
	return location;
}