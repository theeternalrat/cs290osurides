<!DOCTYPE html> <html>  <head> 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBec-tg3yBpOcZzd4ino_TbWGXh4PcaC54&sensor=false"></script>
    <script>
  function init() {
    var geocoder1 = new google.maps.Geocoder();
	var geocoder2 = new google.maps.Geocoder();

    geocoder1.geocode( { 'address': "Portland, OR"}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var latlng = results[0].geometry.location;
        var config = {
          zoom: 8,
          center: latlng,
        };
        map = new google.maps.Map(document.getElementById("mapdiv"), config);
        new google.maps.Marker({map: map, position: latlng});
      } else {
        alert("Error occurred: " + status);
      }
    });

	geocoder2.geocode( { 'address': "2501 SW Jefferson Way Corvallis, OR 97331"}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var latlng = results[0].geometry.location;
        var config = {
          zoom: 8,
          center: latlng,
        };
        new google.maps.Marker({map: map, position: latlng});
      } else {
        alert("Error occurred: " + status);
      }
    });

  }
</script></head>
<body onload="init()"> <div id="mapdiv" style="width: 500px; height: 500px;"></div></body></html>
