/////////////////////////////////////////
// Written by ������_201221096_Ajou Univ.
// 
// �ۼ��� : 2016.06.09
// ���� ������ : 
/////////////////////////////////////////




1. ������Ʈ ��ǥ


	client�� ���� ��ġ�� ������� �ݰ� 7km �̳��� ��ȭ�� ������ �����ϴ� ���� ����



	���� ȯ��&���


	���� ȯ�� : WAMP stack (Windows + Apache + MySQL + PHP)

	���� ��� : Html5, JavaScript, PHP, R

	������Ƽ ���̺귯�� : Geolocation Google API, R script packages, Leaflet, DataTable






	��Ÿ : CGV ���� Ȩ�������� ��ȭ�� ������ scraping�Ͽ� ���� ������ refine�� ��, database ����

		���� ������Ʈ ���������� database�� ������� �����Ƿ�, �ش� database ������ server_work/Database.csv �� ����صξ���.



2. ���� ����


	[1] ��ġ�������, cookie & session

	geolocation�� �������� cookie�� �̿��Ͽ� Ŭ���̾�Ʈ�� ��ġ������ �޾ƿ�. ��ġ������ session�� ����.



	[2] session & DB �� �̿��� �Ÿ���� �˰���

	session�� ����� ���� �� �浵 ������ �̿��Ͽ� database�� �ִ� ��ȭ�� ������ ������� 7km �̳��� ��ȭ�� ������ ����ִ� data�� session���� ����. ���� �� �浵������ �̿��Ͽ� km ������ �Ÿ��� �����ϴ� �˰����� ���.



	[3] Home tab - web data scraping

	HOME ������ http://movie.daum.net/main/new �� ���ż����� scraping�� json �����Ϳ� �̹����� �о ������



	[4] Map tab - location visualizing by session & DB

	MAP ������ 7km �̳��� ��ȭ������ �����浵 ������ �̿��Ͽ� ������Ƽ ���̺귯���� Leaflet�� �̿��Ͽ� visualizing �Ͽ���.



	[5] Theater tab - data search & sort

	THEATER ������ ��ȭ�� ������ scraping �� json �����߿��� 7km �̳��� ��ȭ���� �������� �̿��Ͽ� search�� sort�� ������ table �������� ������.



	[6] Data scraping algorithm

	3���� 5������ ����ϴ� json data��, R script�� �̿��Ͽ� ��ȭ�� Ȩ�������� ������ scraping �� �� json file�� encoding�Ͽ� ������ directory ������ �����ϴ� �����̴�. ��ȭ�� ������ �ǽð����� �����ؾ� �ϱ� ������ json������ �����ٷ��� �̿��Ͽ� ������Ʈ �Ͽ��� ������, �� ������Ʈ������ ���� PC�� ������ �����Ͽ��� ������ R scheduler�� ����� ������ �� ���� ȯ���̾����Ƿ�, json file�� ������Ʈ �ϴ°��� �������� �����Ͽ���.



3. ���� ����


	[1]

	�ð� ����� CGV��ȭ�� �������� scraping�ϴ� logic���� ���������, ���Ŀ� Megabox�� Lottecinema ���� �������� scraping�ϴ� logic�� �߰��Ѵ�.

	[2]

	���� ������ �����ϰ� 24�ð� ���� ������ ������ ������ �����Ѵٸ�, �ǽð� json �����͸� ������Ʈ �ϱ����� R script�� �̿��� �ǽð� json �����͸� �̾Ƴ��� ���� ������ ȯ�� ������ �����ٷ��� ������ �� ���� ���̴�.