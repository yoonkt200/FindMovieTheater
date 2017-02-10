/////////////////////////////////////////
// Written by 윤기태_201221096_Ajou Univ.
// 
// 작성일 : 2016.06.09
// 최종 수정일 : 
/////////////////////////////////////////




1. 프로젝트 목표


	client의 현재 위치를 기반으로 반경 7km 이내의 영화관 정보를 제공하는 서비스 구현



	개발 환경&언어


	개발 환경 : WAMP stack (Windows + Apache + MySQL + PHP)

	개발 언어 : Html5, JavaScript, PHP, R

	서드파티 라이브러리 : Geolocation Google API, R script packages, Leaflet, DataTable






	기타 : CGV 공식 홈페이지의 영화관 정보를 scraping하여 각종 정보를 refine한 뒤, database 구축

		제출 프로젝트 폴더에서는 database가 적용되지 않으므로, 해당 database 내용은 server_work/Database.csv 에 명시해두었음.



2. 구현 내용


	[1] 위치기반정보, cookie & session

	geolocation과 브라우저의 cookie를 이용하여 클라이언트의 위치정보를 받아옴. 위치정보는 session에 저장.



	[2] session & DB 를 이용한 거리계산 알고리즘

	session에 저장된 위도 및 경도 정보를 이용하여 database에 있는 영화관 정보를 기반으로 7km 이내의 영화관 정보가 들어있는 data를 session으로 관리. 위도 및 경도정보를 이용하여 km 단위로 거리를 측정하는 알고리즘을 사용.



	[3] Home tab - web data scraping

	HOME 에서는 http://movie.daum.net/main/new 의 예매순위를 scraping한 json 데이터와 이미지를 읽어서 보여줌



	[4] Map tab - location visualizing by session & DB

	MAP 에서는 7km 이내의 영화관들의 위도경도 정보를 이용하여 서드파티 라이브러리인 Leaflet을 이용하여 visualizing 하였음.



	[5] Theater tab - data search & sort

	THEATER 에서는 영화관 정보를 scraping 한 json 파일중에서 7km 이내의 영화관의 정보만을 이용하여 search와 sort가 가능한 table 형식으로 보여줌.



	[6] Data scraping algorithm

	3번과 5번에서 사용하는 json data는, R script를 이용하여 영화관 홈페이지의 정보를 scraping 한 뒤 json file로 encoding하여 서버의 directory 폴더에 저장하는 파일이다. 영화관 정보를 실시간으로 제공해야 하기 때문에 json파일은 스케줄러를 이용하여 업데이트 하여야 하지만, 본 프로젝트에서는 개인 PC로 개발을 진행하였기 때문에 R scheduler를 제대로 가동할 수 없는 환경이었으므로, json file을 업데이트 하는것은 수동으로 진행하였다.



3. 개선 방향


	[1]

	시간 관계상 CGV영화관 페이지를 scraping하는 logic만을 만들었지만, 추후에 Megabox나 Lottecinema 등의 페이지를 scraping하는 logic을 추가한다.

	[2]

	만약 관리가 용이하고 24시간 서버 역할이 가능한 서버를 구축한다면, 실시간 json 데이터를 업데이트 하기위해 R script를 이용해 실시간 json 데이터를 뽑아내는 등의 데이터 환경 구축을 스케줄러로 관리할 수 있을 것이다.