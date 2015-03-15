from selenium import webdriver
from selenium.webdriver.support.ui import Select # for <SELECT> HTML form
import sys
import urllib.request
from bs4 import BeautifulSoup
import time
import courseData

gradeLink = "https://ilearn.csumb.edu/grade/report/user/index.php?id="

assignmentLink = "https://ilearn.csumb.edu/mod/assign/index.php?id="

driver = webdriver.PhantomJS('C:\phantomjs\phantomjs.exe')
# On Windows, use: webdriver.PhantomJS('C:\phantomjs-1.9.7-windows\phantomjs.exe')

# Service selection
# Here I had to select my school among others 
driver.get("https://sso.csumb.edu/cas/login?service=http%3A%2F%2Filearn.csumb.edu%2Flogin%2Findex.php%3FauthCAS%3DCAS")

file = open('login.txt', 'r')
username = file.readline()
password = file.readline()
# Login page (https://cas.ensicaen.fr/cas/login?service=https%3A%2F%2Fshibboleth.ensicaen.fr%2Fidp%2FAuthn%2FRemoteUser)
# Fill the login form and submit it
#username = ''#sys.argv[2]
#password = ''#sys.argv[3]
driver.find_element_by_id('username').send_keys(username)
driver.find_element_by_id('password').send_keys(password)
driver.find_element_by_id('fm1').submit()

# Now connected to the home page
# Click on 3 links in order to reach the page I want to scrape

# Select and print an interesting element by its ID
page = driver.find_element_by_class_name('unlist')
arr = page.text.split("\n")
#print (arr)
links = []
courseId = []
for title in arr:
    links.append(driver.find_element_by_link_text(title))

for link in links:
#    print (link.get_attribute("href"))
#    print (link.get_attribute("href")[(link.get_attribute("href")).index("=") + 1:])
    courseId.append(link.get_attribute("href")[(link.get_attribute("href")).index("=") + 1:])

#for i in courseId:
#    print (i)
    
##driver.get(gradeLink + courseId[0])
##print (gradeLink + courseId[0])
##page = driver.find_element_by_class_name('main')
##print(page.text)


arrAssignments = []
arrAName = []
arrDueDate = []
courseAssignmentDictionary = []

for index in range(len(courseId)):
    driver.get(assignmentLink + courseId[index])
##    tempClass = courseData.CourseData()
##    tempClass.set_courseName(arr[index])
    page = driver.find_element_by_tag_name('tbody')
    arrAssignments = page.text.split("\n")
    
    for each in arrAssignments:
        tempClass = courseData.CourseData()
        tempClass.set_courseName(arr[index])
        tempArr = each.split(",")
        datestr = time.strftime('%d')+" "+time.strftime('%m')
        if(len(tempArr) > 1):
##            arrAName.append(tempArr[0])
            tempClass.set_assignmentName(tempArr[0])
            tempClass.set_assignmentDueDate(tempArr[1])
            courseAssignmentDictionary.append(tempClass)
##            if(len(tempArr) == 1 ):
##                arrDueDate.append("No Due Date Set")
##                tempClass.set_assignmentDueDate("No Due Date Set")
##            else:
##                arrDueDate.append(tempArr[1])
##                tempClass.set_assignmentDueDate(tempArr[1])
        

##for i in range(len(arrAName)):
##    print ("\nAssignment: "+arrAName[i]+"\nDue date"+arrDueDate[i])

for assignment in courseAssignmentDictionary:
    print("Course Name: "+ assignment.get_courseName())
    print("Assignment Title: "+ assignment.get_assignmentName())
    print("Assignment Due: "+ assignment.get_assignmentDueDate())
    

##arrayGrade = page.text.split("\n")
##for i in arrayGrade:
##    print ("line" + i)


########################################################  Getting grade code ##############################################





driver.get(gradeLink + "8733")
page = driver.find_element_by_class_name('td')






































