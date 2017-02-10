library(XML)
library(rvest)
library(httr)
library(jsonlite)
library(RJSONIO)
library(reshape2)
library(dplyr)

current_date=Sys.Date() # url parsing 에 사용할 현재날짜
current_date=gsub("-", "", current_date)
theater_info <- data.frame(stringsAsFactors=FALSE) # 임시 데이터 프레임
originaldata <- data.frame(stringsAsFactors=FALSE) # 최종적으로 저장될 데이터 프레임


FindTimeAndHall <- function(hall, table){ ## mytable은 theater_info_area[index]임.
  
  temp_data <- data.frame(stringsAsFactors=FALSE) ## output data
  halltable1 = html_nodes(hall, 'li')
  
  halltable1 = html_text(halltable1)
  halltable1 = gsub("\r\n                                                        ","/", halltable1)
  halltable1 = gsub("\n|\t|\r","", halltable1)
  halltable1 = gsub(" ","",halltable1)
  halltable1 = gsub("총","",halltable1)
  halltable1 = paste(halltable1[1], halltable1[2], halltable1[3], sep="")
    
  timetable1 = html_text(html_nodes(table, 'a'))
  timetable1 = gsub("\n|\t|\r","", timetable1)
  timetable1 = gsub(" ","",timetable1)
    
  timetable1 = paste(timetable1, halltable1, sep=", 상영관: ")
  temp_data <- rbind(temp_data, cbind(timetable1))
  return(temp_data)
}


TheaterInfo <- function(page_number){
  
  original_page_number = page_number
  page_number <- gsub(" ","0",format(page_number, width = 4)) ## url 형식에 맞게 날짜, 페이지 번호등을 추가적으로 파싱.
  url = paste("http://www.cgv.co.kr/theaters/?areacode=01&theaterCode=", page_number, "&date=", current_date, sep="")
  
  doc = htmlTreeParse(url, useInternalNodes =T, encoding = "UTF-8")
  
  url <- paste0("http://www.cgv.co.kr",xmlGetAttr(doc[['/html/body/div[@id="cgvwrap"]/div[@id="contaniner"]/div[@id="contents"]/div[@class="wrap-theater"]/div[@class="cols-content"]/div[@class="col-detail"]/iframe']], "src"))
  ##### XML 라이브러리를 이용, iframe 태그에 접근
  ##### cgv 영화정보 태그만 iframe 형식으로 되어있기 때문
  
  response=GET(url)
  htxt <- html(response)
  
  ########################################################
  ##### movietitle과 같은 길이의 데이터들
  
  titlelocal <- html_nodes(htxt, 'div.col-times')
  
  info_movietitle <- html_text(html_nodes(titlelocal, 'strong')) ## 영화제목 리스트 크롤링
  info_movietitle = gsub("\r\n                                                ","", info_movietitle)
  
  infolocal <- html_nodes(htxt, 'div.info-movie')
  
  info_grade <- html_text(html_nodes(infolocal, 'span.ico-grade')) ## 상영등급 리스트 크롤링
  info_grade = gsub("\n|\t|\r","", info_grade)
  info_grade = gsub(" ","",info_grade)
  
  info_showing <- html_text(html_nodes(infolocal, 'span.round')) ## 상영중 리스트 크롤링
  info_showing = gsub("\n|\t|\r","", info_showing)
  info_showing = gsub(" ","",info_showing)
  info_showing = info_showing[which(info_showing!="예매중")] ## 예매중 태그는 D-day 위젯과 span이 중복되므로 제거해줌
  
  info_premovieinfo <- html_text(html_nodes(infolocal, 'i')) ## 장르,시간,개봉 리스트 크롤링
  info_premovieinfo = gsub("\n|\t|\r","", info_premovieinfo)
  info_premovieinfo = gsub(" ","",info_premovieinfo)
  info_movieinfo <- vector()
  
  i = 0
  while(i < length(info_premovieinfo)){ ## 장르+시간+개봉일자 를 하나의 element로 데이터 합침
    i = i + 1
    if((i%%3) == 1){
      info_movieinfo <- c(info_movieinfo, (paste(info_premovieinfo[i], "/", info_premovieinfo[i+1], "/", info_premovieinfo[i+2])))
    }
    else{}
  }
  info_movieinfo = gsub("<U+00A0>","",info_movieinfo)
  
  ########################################################
  ##### movietitle과 다른 길이의 데이터들 : div 안의 새로운 List
  
  area_list = html_nodes(htxt, 'div.col-times') ## div area마다 중첩되는 내용이 있으므로, 각 영역을 리스트로 분할.
  
  
  ########################################################
  ##### data 최종 병합
  outdata <- data.frame(stringsAsFactors=FALSE) ## TheaterInfo에서 return하는 dataframe
  
  theater_info_index = 0
  while(theater_info_index < length(info_movietitle)){
    theater_info_index = theater_info_index + 1
    temp_outdata <- data.frame(stringsAsFactors=FALSE)
    
    title = info_movietitle[theater_info_index]
    grade = info_grade[theater_info_index]
    showing = info_showing[theater_info_index]
    movieinfo = info_movieinfo[theater_info_index]
    pagenumber = original_page_number
    select_list = area_list[theater_info_index]
    select_typehall = html_nodes(select_list, 'div.type-hall')
    
    area_list_index = 0
    while(area_list_index < length(select_typehall)){
      area_list_index = area_list_index + 1
      
      select_infohall = html_nodes(select_typehall[area_list_index], 'div.info-hall')
      select_infotimetable = html_nodes(select_typehall[area_list_index], 'div.info-timetable')
      
      area_list_index2 = 0
      while(area_list_index2 < length(select_infotimetable)){
        area_list_index2 = area_list_index2 + 1
        
        temp_outdata = FindTimeAndHall(select_infohall,select_infotimetable[area_list_index2])
        temp_outdata = cbind(title, temp_outdata)
        temp_outdata = cbind(grade, temp_outdata)
        temp_outdata = cbind(showing, temp_outdata)
        temp_outdata = cbind(movieinfo, temp_outdata)
        temp_outdata = cbind(pagenumber, temp_outdata)
        outdata <- rbind(outdata, temp_outdata)
      }
    }
  }
  
  return(outdata)
}

ErrorTest <- function(index){
  testdata <- data.frame(stringsAsFactors=FALSE)
  temp_info = TheaterInfo(index)
  testdata <- rbind(testdata, temp_info)
}



for(i in 1:228){
  result <- try(ErrorTest(i))
  if(class(result) == "try-error"){
    next
  }
  else{
    theater_info = TheaterInfo(i)
    jsondata <- toJSON(theater_info)
    jsondata = gsub(": \\[",":'[", jsondata)
    jsondata = gsub("\\],","]',", jsondata)
    jsondata = gsub("\\] \n}","]' \n}", jsondata)
    route = paste("C:/Bitnami/wampstack-5.6.20-0/apache2/htdocs/json/data",i,".json")
    route = gsub(" ","", route)
    rty <- file(route,encoding="UTF-8")
    write(jsondata, rty)
  }
}

