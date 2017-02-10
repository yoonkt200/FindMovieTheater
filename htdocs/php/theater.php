<?php session_start();

	header("Content-Type: text/html; charset=UTF-8");
	require('proxy_crawler.php'); // crawled Json data to $datafile_arr

?>

<?php 

	require("../html/theater_layout.html");

?>

<script type="text/javascript" src="../js/refinedata.js"></script>
<script type="text/javascript">


	var crawled_jsondata = <?php echo $datafile_arr?>;
	var theater_name_arr = <?php echo $theater_name_arr?>;
	
	var dataSet = refineData4Table(theater_name_arr, crawled_jsondata);

	$(document).ready(function(){
	    $('#example').DataTable({
	        data: dataSet,
	        columns:[
	            {title: "theater"},
	            {title: "title"},
	            {title: "info"},
	            {title: "show"},
	            {title: "grade"},
	            {title: "screen"}
	        ]
	    });
	});


</script>