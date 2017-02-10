<?php session_start();

?>

<html>
<head>
    <meta charset="utf-8">
    <title>Finding Theater</title>
    <script src="js/jquery-1.12.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href='http://fonts.googleapis.com/earlyaccess/nanumgothic.css'>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<div class="container">
    <div class="aligned-container">
        <div class="banner">
            <p id="banner-title">Finding Movie Theater</p>
        </div>
        <div class="introduction">
            <p id="app-introduction">Finding Movie Theater는 현재 이 페이지 접속자의 위치를 기반으로, 7km 이내에 있는 모든 영화관의 정보를 알려주는 어플리케이션입니다. Finding Movie Theater를 통해 언제 어디서나 손쉽게 영화관의 정보를 얻을 수 있습니다. 근처 영화관의 지도를 보여주기도 하고, 상영시간 혹은 남은좌석등을 기준으로 정렬하여 원하는 정보를 얻을 수도 있습니다.</p>
        </div>
        <div class="button-area">
            <button class ="get-button" onclick = "permission()">1. Get Current Location</button>
            <button class ="start-button" onclick = "moveTomain()">2. Start Application</button>
        </div>
    </div>
</div>
</body>
</html>

<script type="text/javascript">

    var user_permission = false;

    function permission(){
        user_permission = confirm("현재 위치정보 제공에 동의하시겠습니까?");
        if(user_permission){
            setCookie('permission', 'right',1);
            setLocation();
        }
    }

    function setLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }


    function showPosition(position) {
        var user_latitude = position.coords.latitude;
        var user_longitude = position.coords.longitude;

        if(user_latitude == 0 && user_longitude == 0){
            alert("위치정보를 받는 데 실패하였습니다.")
        }
        else{
            alert("위치정보를 받는 데 성공하였습니다. Start Application으로 시작해주세요.");
            post('index.php', {lon: user_longitude, lat: user_latitude});
        }
    }


    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }

    function post(path, params, method) { // ajax to this page
        method = method || "post"; 

        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);

        for(var key in params) {
            if(params.hasOwnProperty(key)) {
             var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);
                form.appendChild(hiddenField);
            }
        }

        document.body.appendChild(form);
        form.submit();
}
    function moveTomain(){ // redirect page to main.php
        if(getCookie('permission')=='right'){
            setCookie('permission', '', -1);
            window.location.assign("php/main.php");
        }
    }


    function setCookie(cName, cValue, cDay){ // using cookie, get user agree
        var expire = new Date();
        expire.setDate(expire.getDate() + cDay);
        cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
        if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
        document.cookie = cookies;
    }
 

    function getCookie(cName) {
        cName = cName + '=';
        var cookieData = document.cookie;
        var start = cookieData.indexOf(cName);
        var cValue = '';
        if(start != -1){
            start += cName.length;
            var end = cookieData.indexOf(';', start);
            if(end == -1)end = cookieData.length;
            cValue = cookieData.substring(start, end);
        }
        return unescape(cValue);
    }

</script>

<?php

if(isset($_POST["lon"]) && isset($_POST["lat"])){ // if get ajax data, create user location session
    if (!empty($_POST["lon"]) && !empty($_POST["lat"])){
        $lon = $_POST["lon"];
        $lat = $_POST["lat"];

        $_SESSION["lon"] = $lon;
        $_SESSION["lat"] = $lat;

        exit();
        /*echo "Session variables are set.";*/
    }
}
?>