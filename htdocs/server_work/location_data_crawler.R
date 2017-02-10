library(httr)
library(rvest)
library(stringr)
library(RSelenium)
library(maps)
library(ggmap)
library(mapproj)
library(selectr)

current_date=Sys.Date() # url parsing 에 사용할 현재날짜
current_date=gsub("-", "", current_date)


location <- data.frame(stringsAsFactors=FALSE)

CgvLocation <- function(number){ # cgv data 크롤링
  
  
  number <- gsub(" ","0",format(number, width = 4))
  
  url = paste("http://www.cgv.co.kr/theaters/?areacode=01&theaterCode=", number, "&date=",current_date, sep="")
  
  response=GET(url)
  
  htxt <- html(response)
  local <- html_nodes(htxt, 'strong.title')
  name <- html_nodes(htxt, 'h4.theater-tit')
  local <- html_text(local)
  name <- html_text(name)
  local <- gsub("위치/주차 안내  >","",local)
  
  if(length(local)==0){
    return()
  }
  
  local <- substr(local,1,(gregexpr(substr(local, 1, 2),local)[[1]][2])-1) # cgv페이지의 주소중복문제 해결해줌
  
  row <- cbind(local) # 위치정보 저장
  row <- cbind(name,row) # 영화관 이름 저장
  row <- cbind(number,row) # 페이지 number 저장
  
  return(row)
}

for(i in 1:500){ # 1~500 page(모든 영화관 페이지)의 영화관 주소정보 크롤링
  location <- rbind(location, CgvLocation(i))
}


#location 변수에 모든 주소정보 들어감

names(location) <- c("location")

#location <- na.omit(location) # 빈페이지(NA) 정보 제거

sapply(location, class)
location$local <- as.character(location$local) # character 타입으로 변환

gg = geocode(enc2utf8(location$local),source="google") # 위도.경도 정보
location = cbind(location, gg)


write.csv(location,"C:/Users/Yoon/Desktop/웹프/location.csv")
location = read.csv("C:/Users/Yoon/Desktop/웹프/location.csv", header=T)
View(location)
location$name = as.character(location$name)
location[1,1]
#final_locinfo = cbind(location, gg)