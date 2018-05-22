## Find movie theater
- web appication project in ajou university.
- real time web crawling using Rscript, web applicatoin using PHP + SQL

## Using
- WAMP stack (Windows + Apache + MySQL + PHP)
- Language : Html5, JavaScript, PHP, Rscript
- third-party library : Geolocation Google API, R script packages, Leaflet, DataTable

## Project Goal
google api Geolocation을 이용하여 페이지 접속자의 위치를 받아온 뒤, 7km 이내에 있는 CGV 영화관의 각종 정보를 보여줍니다. 잔여 좌석, 개봉 영화, 상영 등급 등 해당 영화관에서 제공하는 모든 정보를 보여주며, 각 정보는 페이지 내에서 커스터마이징하여 정렬할 수 있고 검색 가능합니다. 현재 위치와 근처의 영화관 정보를 Leaflet 맵으로 보여주는 기능과, CGV 에서 제공하는 무비 차트 정보도 제공하고 있습니다.

영화관의 정보와 무비 차트 정보는, 서버에서 R 스크립트로 크롤링된 Json Data를 클라이언트 측에서 볼 수 있는 구조로 설계된 것입니다. 다만, 데이터 크롤링을 스케줄러로 관리하는 기능은 넣지 않았기 때문에 Json Data 생성은 관리자 수동적 입니다.

## Getting Started  ( for developers )

#### 1. Install node.js

Install WAMP stack (Windows + Apache + MySQL + PHP)

	$ just run localhost

## Demo Video

https://www.youtube.com/watch?v=TgoH--bpIOM&feature=youtu.be

## Images
![homepage](https://github.com/yoonkt200/examples-php-webservice/blob/master/images/1.PNG)
![homepage](https://github.com/yoonkt200/examples-php-webservice/blob/master/images/2.PNG)
![homepage](https://github.com/yoonkt200/examples-php-webservice/blob/master/images/3.PNG)
![homepage](https://github.com/yoonkt200/examples-php-webservice/blob/master/images/4.PNG)