<?php session_start();

//if session is already exist, can't do this
if(!isset($_SESSION["lon_arr"])){ 

	// find near theater by searching Database
	require('findDB_nearlocation.php');

	// save near theater info to session
	$_SESSION["lon_arr"] = $lon; 
	$_SESSION["lat_arr"] = $lat;
	$_SESSION["name_arr"] = $name;
	$_SESSION["pagenum_arr"] = $pagenum;
	$_SESSION["distance_arr"] = $distance;

}

$json_src = file_get_contents('../json/srcData.json');
$json_percent = file_get_contents('../json/percentData.json');
$json_title = file_get_contents('../json/titleData.json');

?>

<?php 

	require("../html/main_layout.html");

?>

<script type="text/javascript">

window.onload = function(){
	var src = <?php echo $json_src?>;
	var percent = <?php echo $json_percent?>;
	var title = <?php echo $json_title?>;

	var src1 = JSON.stringify(src);
	var src_data = JSON.parse(src1);

	var percent1 = JSON.stringify(percent);
	var percent_data = JSON.parse(percent1);

	var title1 = JSON.stringify(title);
	var title_data = JSON.parse(title1);

	var fig1 = "<figure><a href=\"http://www.cgv.co.kr/movies/?ft=0\"  style=\"font-weight:bold\" class=\"thumb\"><img src=\"" + src_data[0] + "\" alt=\"Alt text\" /><br>1. " + title_data[0] + "<br><br>" + percent_data[0] + "<br></a></figure>";
	var fig2 = "<figure><a href=\"http://www.cgv.co.kr/movies/?ft=0\"  style=\"font-weight:bold\" class=\"thumb\"><img src=\"" + src_data[1] + "\" alt=\"Alt text\" /><br>2. " + title_data[1] + "<br><br>" + percent_data[1] + "<br></a></figure>";
	var fig3 = "<figure class=\"last\"><a href=\"http://www.cgv.co.kr/movies/?ft=0\"  style=\"font-weight:bold\" class=\"thumb\"><img src=\"" + src_data[2] + "\" alt=\"Alt text\" /><br>3. " + title_data[2] + "<br><br>" + percent_data[2] + "<br></a></figure>";
	var fig4 = "<figure><a href=\"http://www.cgv.co.kr/movies/?ft=0\"  style=\"font-weight:bold\" class=\"thumb\"><img src=\"" + src_data[3] + "\" alt=\"Alt text\" /><br>4. " + title_data[3] + "<br><br>" + percent_data[3] + "<br></a></figure>";
	var fig5 = "<figure><a href=\"http://www.cgv.co.kr/movies/?ft=0\"  style=\"font-weight:bold\" class=\"thumb\"><img src=\"" + src_data[4] + "\" alt=\"Alt text\" /><br>5. " + title_data[4] + "<br><br>" + percent_data[4] + "<br></a></figure>";
	var fig6 = "<figure class=\"last\"><a href=\"http://www.cgv.co.kr/movies/?ft=0\"  style=\"font-weight:bold\" class=\"thumb\"><img src=\"" + src_data[5] + "\" alt=\"Alt text\" /><br>6. " + title_data[5] + "<br><br>" + percent_data[5] + "<br></a></figure>";
	
	document.getElementById('chart').innerHTML += fig1;
	document.getElementById('chart').innerHTML += fig2;
	document.getElementById('chart').innerHTML += fig3;
	document.getElementById('chart').innerHTML += fig4;
	document.getElementById('chart').innerHTML += fig5;
	document.getElementById('chart').innerHTML += fig6;
}
	
</script>