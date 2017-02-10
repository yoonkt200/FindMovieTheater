<?php 

$pagenum_data_arr = $_SESSION["pagenum_arr"];
$theater_name_arr = $_SESSION["name_arr"];

$datafile_arr = "["; // output json data

foreach ($pagenum_data_arr as $value) { // paste json data
	$file_route = "../json/data" . $value . ".json";
	$file = file_get_contents($file_route);
	$datafile_arr .= $file . ",";
}

$datafile_arr = substr($datafile_arr, 0, -1);
$datafile_arr .= "]";

$theater_name_arr = json_encode($theater_name_arr); // theater name for javascript

?>