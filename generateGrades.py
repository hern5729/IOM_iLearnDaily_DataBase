from selenium import webdriver
from selenium.webdriver.support.ui import Select # for <SELECT> HTML form
import sys
import urllib.request
from bs4 import BeautifulSoup
import time
import courseData

gradeLink = "https://ilearn.csumb.edu/grade/report/overview/index.php?id="
driver = webdriver.PhantomJS('C:\phantomjs\phantomjs.exe')
# On Windows, use: webdriver.PhantomJS('C:\phantomjs-1.9.7-windows\phantomjs.exe')

# Service selection
# Here I had to select my school among others 
driver.get("https://sso.csumb.edu/cas/login?service=http%3A%2F%2Filearn.csumb.edu%2Flogin%2Findex.php%3FauthCAS%3DCAS")

##file = open('login.txt', 'r')
##username = file.readline()
##password = file.readline()
# Login page (https://cas.ensicaen.fr/cas/login?service=https%3A%2F%2Fshibboleth.ensicaen.fr%2Fidp%2FAuthn%2FRemoteUser)
# Fill the login form and submit it
username = sys.argv[2]
password = sys.argv[3]
driver.find_element_by_id('username').send_keys(username)
driver.find_element_by_id('password').send_keys(password)
driver.find_element_by_id('fm1').submit()

#print (gradeLink + "8733")
driver.get(gradeLink + "8733")

page = driver.find_element_by_tag_name('table')


#print (page.text)
space = []
splitLine = page.text.split("\n")
for i in range(3,len(splitLine)):
    space.append(splitLine[i].split(" "))

#print(space)
for i in space:
    course = i[0]
    print("Class: " + course[:7] + " " + "Grade: " + i[1])



