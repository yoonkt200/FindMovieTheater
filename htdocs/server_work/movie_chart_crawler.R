library(XML)
library(rvest)
library(httr)
library(jsonlite)
library(RJSONIO)

outdata <- data.frame(stringsAsFactors=FALSE)

url = "http://www.cgv.co.kr/movies/?ft=0"  
response=GET(url)
htxt <- html(response)

contents <- html_nodes(htxt, 'div.box-contents')
contents2 <- html_nodes(contents, 'strong.title')
contents3 <- html_nodes(contents, 'strong.percent')
title <- html_text(contents2)
percent <- html_text(contents3)

img <- html_nodes(htxt, 'div.box-image')
img2 <- html_nodes(img, 'span.thumb-image')
img3 <- html_nodes(img2, 'img')
src <- html_attr(img3, 'src')

json1 <- toJSON(src)
json2 <- toJSON(percent)
json3 <- toJSON(title)

route1 = paste("C:/Bitnami/wampstack-5.6.20-0/apache2/htdocs/json/srcData.json")
route2 = paste("C:/Bitnami/wampstack-5.6.20-0/apache2/htdocs/json/percentData.json")
route3 = paste("C:/Bitnami/wampstack-5.6.20-0/apache2/htdocs/json/titleData.json")
rty1 <- file(route1,encoding="UTF-8")
rty2 <- file(route2,encoding="UTF-8")
rty3 <- file(route3,encoding="UTF-8")
write(json1, rty1)
write(json2, rty2)
write(json3, rty3)

