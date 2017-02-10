<?php

$lon = array();
$lat = array();
$pagenum = array();
$name = array();
$distance = array();

/*get theater information by DB*/

$conn = mysqli_connect("localhost:3309", "root", "dbs1837711");
	/*if(mysqli_connect_errno($conn)){
	    echo "fail : ".mysqli_connect_error();
	}
	else{
	    echo "success";
	}*/
mysqli_select_db($conn, "movielocation");
$result = mysqli_query($conn, "SELECT * FROM location") or die(mysqli_error($conn));

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    if((double)calcDistance($row["lon"], $row["lat"]) < 7000){
    	array_push($lon, $row["lon"]);
    	array_push($lat, $row["lat"]);
	    array_push($pagenum, $row["pagenum"]);
	    array_push($name, $row["name"]);
	    array_push($distance, calcDistance($row["lon"], $row["lat"]));
	    /*echo "<br></br>";
		echo $row["name"];*/
    }
}
mysqli_close($conn);

/*get theater information by DB*/

/*calculate distance functions*/

function calcDistance($lon, $lat){
	$tlon = (double)$lon;
	$tlat = (double)$lat;
	$theta = (double)$_SESSION["lon"] - $tlon;
	$dist = (sin(_deg2rad((double)$_SESSION["lat"])) * sin(_deg2rad($tlat))) + (cos(_deg2rad((double)$_SESSION["lat"]))   
          * cos(_deg2rad($tlat)) * cos(_deg2rad($theta))); 
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$dist = $dist * 60 * 1.1515;
	$dist = $dist * 1.609344;
	$dist = $dist * 1000;

	return $dist;
}

function _deg2rad($deg) { 
	$radians = 0.0; 
	$radians = $deg * M_PI/180.0; 
	return($radians); 
} 

/*calculate distance functions*/

?>