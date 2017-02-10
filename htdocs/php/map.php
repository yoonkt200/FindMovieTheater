<?php session_start();

	// this session data using for visualizing map
	$lon = $_SESSION["lon"];
	$lat = $_SESSION["lat"];
	$lon_arr = $_SESSION["lon_arr"];
	$lat_arr = $_SESSION["lat_arr"];
	$name_arr = $_SESSION["name_arr"];

?>

<?php

	require("../html/map_layout.html");

?>

<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
<script type="text/javascript">

// using library leaflet.js for visualizing near theater location

var lon = <?php echo json_encode($lon)?>;
var lat = <?php echo json_encode($lat)?>;
var lon_arr = <?php echo json_encode($lon_arr)?>;
var lat_arr = <?php echo json_encode($lat_arr)?>;
var name_arr = <?php echo json_encode($name_arr)?>;

/////////////// Black Map Style ////////////////

/*var layer = L.tileLayer('http://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png',{
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="https://cartodb.com/attributions">CartoDB</a>',
  maxZoom: 18
});

var mymap = L.map('mapid', {
  scrollWheelZoom: true,
  center: [lat, lon],
  zoom: 13
});

mymap.addLayer(layer);*/

/////////////// Black Map Style ////////////////


/////////////// Original Map Style ////////////////

var mymap = L.map('mapid').setView([lat, lon], 14);


L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpandmbXliNDBjZWd2M2x6bDk3c2ZtOTkifQ._QA7i5Mpkd_m30IGElHziw', {
	maxZoom: 18,
	attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
				'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="http://mapbox.com">Mapbox</a>',
	id: 'mapbox.streets'
}).addTo(mymap);


L.marker([lat, lon]).addTo(mymap)
	.bindPopup("<b>현재 위치입니다.</b><br />원하는 영화관을 찾아보세요!").openPopup();

for(i in name_arr){
	L.circle([lat_arr[i], lon_arr[i]], 100, {
			color: 'blue',
			fillColor: 'blue',
			fillOpacity: 0.7
	}).addTo(mymap).bindPopup(name_arr[i]);
}

/////////////// Original Map Style ////////////////

</script>