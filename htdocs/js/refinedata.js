function refineData4Table(name, crawled){
	
	var outDataSet = new Array();
	var whole_length = crawled.length;
	
	for (var i = 0; i < whole_length; i++) {

		var arr_length = eval(crawled[i]["pagenumber"]).length;

		for (var j = 0; j < arr_length; j++) {
		var temp_row = new Array();

		var title = eval(crawled[i]["title"]);
		var movieinfo = eval(crawled[i]["movieinfo"]);
		var showing = eval(crawled[i]["showing"]);
		var grade = eval(crawled[i]["grade"]);
		var timetable1 = eval(crawled[i]["timetable1"]);

		temp_row.push(name[i]);
		temp_row.push(title[j]);
		temp_row.push(movieinfo[j]);
		temp_row.push(showing[j]);
		temp_row.push(grade[j]);
		temp_row.push(timetable1[j]);

		outDataSet.push(temp_row);
		};
	};

	return outDataSet;
}