function findNearLocation(userLon, userLat, lon, lat, pagenum, name){
	var session_data=[];

	for(var i in lon){

		var temp_dist = calcDistance(userLon, userLat, lon[i], lat[i]);
		if(temp_dist < 10000){
			console.log(name[i] + " is near theater.");
			var obj = {distance:temp_dist, lon:lon[i], 
				lat:lat[i], pagenum:pagenum[i], name:name[i]};
			session_data.push(obj);
		}
	}

	return session_data;
}


function calcDistance(cLon, cLat, lon, lat){
	var theta = cLon - lon;
	var dist = (Math.sin(deg2rad(cLat)) * Math.sin(deg2rad(lat))) + (Math.cos(deg2rad(cLat))   
          * Math.cos(deg2rad(lat)) * Math.cos(deg2rad(theta))); 
	dist = Math.acos(dist);
	dist = rad2deg(dist);

	dist = dist * 60 * 1.1515;
    dist = dist * 1.609344;
    dist = dist * 1000;

    return dist;
}


function deg2rad(deg){
	return (deg * Math.PI / 180);
}


function rad2deg(rad){
	return (rad * 180 / Math.PI);
}