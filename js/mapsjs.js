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
			var loca = a[3].split(",");
			var locb = b[3].split(",");
			
			var distA = getDist(destLat, destLon, parseFloat(loca[0]), parseFloat(loca[1]));
			var distB = getDist(destLat, destLon, parseFloat(locb[0]), parseFloat(locb[1]));
			return distA - distB;
		});
		
		var geocoder = new google.maps.Geocoder;
		for(i = 0; i < array.length; i++){
			var locations = array[i][3].split(",");
			var radio = makeRadioButton('dots', locations, array[i][8], locations, geocoder, array[i][1], array[i][4]);
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


function makeRadioButton(name, value, cid, endloc, geocoder, userName, date) {

    var label = document.createElement("label");
    var radio = document.createElement("input");
    radio.type = "radio";
    radio.name = name;
    radio.value = value;
	radio.id = "buttons";
	radio.onclick = function() {movePointer(cid, endloc)};

    label.appendChild(radio);
	var text = document.createTextNode("");
	label.appendChild(text);
	var addr = getName(geocoder, value, text, userName, date);
    
    return label;
}

function getName(geocoder, latlng, text, userName, date){
	var ll = {lat: parseFloat(latlng[0]), lng: parseFloat(latlng[1])};
	var address; 
	geocoder.geocode({'location': ll}, function(results, status){
		dateArr = date.split(' ');
		if(status == google.maps.GeocoderStatus.OK){
			text.nodeValue = userName + ", " + dateArr[0] + ", " + results[1].formatted_address;
		} else {
			text.nodeValue = userName + ", " + dateArr[0] + ", No address found.";
		}
	});
}

function movePointer(id, endloc){
	console.log(id);
	$.ajax({
		type: 'get',
		data: {'carpool_id': id},
		url: 'get_carpool_data.php',
		success: function(data){
			var dataDiv = document.getElementById('dataDiv');
			
			while(dataDiv.firstChild)
				dataDiv.removeChild(dataDiv.firstChild);
			
			var list = document.createElement('ul');
			dataDiv.appendChild(list);
			var json = JSON.parse(data);
			console.log(json);
			//name
			var nameLabel = document.createElement("li");
			var link = document.createElement("a");
			var nameTextDriver = document.createTextNode(json["creator_onid"]);
			var nameText = document.createTextNode("Driver: ");
			nameLabel.appendChild(nameText);
			link.title = json["creator_onid"];
			link.appendChild(nameTextDriver);
			link.href="user.php?q=" + json["carpool_creator"]; 
			nameLabel.appendChild(link);
			list.appendChild(nameLabel);
			//start date
			var startLabel = document.createElement("li");
			var startText = document.createTextNode("Leave Date: " + json["leave_date"].split(' ')[0]);
			startLabel.appendChild(startText);
			list.appendChild(startLabel);
			//description
			var descripLabel = document.createElement('li');
			var descripText = document.createTextNode("Description: " + json["description"]);
			descripLabel.appendChild(descripText);
			list.appendChild(descripLabel);
			//start loc
			var startlocLabel = document.createElement('li');
			var startLocText = document.createTextNode("Start Location: " + json["start"]);
			startlocLabel.appendChild(startLocText);
			list.appendChild(startlocLabel);
			//end loc
			var endLabel = document.createElement('li');
			var endText = document.createTextNode("End Location: " + json["end"]);
			endLabel.appendChild(endText);
			list.appendChild(endLabel);
			//Link to listing
			var listingLabel = document.createElement("li");
			var listinglink = document.createElement("a");
			var listingText = document.createTextNode("View Listing");
			listingLabel.appendChild(listingText);
			listinglink.title = "View Listing";
			listinglink.href = "listing.php?id="+json["carpool_id"];
			listinglink.appendChild(listingText);
			listingLabel.appendChild(listinglink);
			list.appendChild(listingLabel);
		}	
	});
	
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