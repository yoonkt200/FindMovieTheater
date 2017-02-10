library(httr)
library(rvest)
library(stringr)
library(RSelenium)
library(maps)
library(ggmap)
library(mapproj)
library(selectr)

current_date=Sys.Date() # url parsing �� ����� ���糯¥
current_date=gsub("-", "", current_date)


location <- data.frame(stringsAsFactors=FALSE)

CgvLocation <- function(number){ # cgv data ũ�Ѹ�
  
  
  number <- gsub(" ","0",format(number, width = 4))
  
  url = paste("http://www.cgv.co.kr/theaters/?areacode=01&theaterCode=", number, "&date=",current_date, sep="")
  
  response=GET(url)
  
  htxt <- html(response)
  local <- html_nodes(htxt, 'strong.title')
  name <- html_nodes(htxt, 'h4.theater-tit')
  local <- html_text(local)
  name <- html_text(name)
  local <- gsub("��ġ/���� �ȳ�  >","",local)
  
  if(length(local)==0){
    return()
  }
  
  local <- substr(local,1,(gregexpr(substr(local, 1, 2),local)[[1]][2])-1) # cgv�������� �ּ��ߺ����� �ذ�����
  
  row <- cbind(local) # ��ġ���� ����
  row <- cbind(name,row) # ��ȭ�� �̸� ����
  row <- cbind(number,row) # ������ number ����
  
  return(row)
}

for(i in 1:500){ # 1~500 page(��� ��ȭ�� ������)�� ��ȭ�� �ּ����� ũ�Ѹ�
  location <- rbind(location, CgvLocation(i))
}


#location ������ ��� �ּ����� ��

names(location) <- c("location")

#location <- na.omit(location) # ��������(NA) ���� ����

sapply(location, class)
location$local <- as.character(location$local) # character Ÿ������ ��ȯ

gg = geocode(enc2utf8(location$local),source="google") # ����.�浵 ����
location = cbind(location, gg)


write.csv(location,"C:/Users/Yoon/Desktop/����/location.csv")
location = read.csv("C:/Users/Yoon/Desktop/����/location.csv", header=T)
View(location)
location$name = as.character(location$name)
location[1,1]
#final_locinfo = cbind(location, gg)