from selenium import webdriver
from selenium.webdriver.support.ui import Select # for <SELECT> HTML form
import sys
import urllib.request
from bs4 import BeautifulSoup
import time
import courseData
import mysql.connector
from selenium.common.exceptions import NoSuchElementException

try:
    cnx = mysql.connector.connect(user='root',
                                  password='Monsebaby27',
                                  host='localhost',
                                  database='ild')
    gradeLink = "https://ilearn.csumb.edu/grade/report/user/index.php?id="

    assignmentLink = "https://ilearn.csumb.edu/mod/assign/index.php?id="

    driver = webdriver.PhantomJS('C:\phantomjs\phantomjs.exe')
    # On Windows, use: webdriver.PhantomJS('C:\phantomjs-1.9.7-windows\phantomjs.exe')

    # Service selection
    # Here I had to select my school among others 
    driver.get("https://sso.csumb.edu/cas/login?service=http%3A%2F%2Filearn.csumb.edu%2Flogin%2Findex.php%3FauthCAS%3DCAS")

##    file = open('login.txt', 'r')
    username = sys.argv[2];
    password = sys.argv[3];
    ##username = file.readline()
    username = username.strip();
    ##password = file.readline()
    password = password.strip()
    # Login page (https://cas.ensicaen.fr/cas/login?service=https%3A%2F%2Fshibboleth.ensicaen.fr%2Fidp%2FAuthn%2FRemoteUser)
    # Fill the login form and submit it

    driver.find_element_by_id('username').send_keys(username)
    driver.find_element_by_id('password').send_keys(password)
    driver.find_element_by_id('fm1').submit()

    # Now connected to the home page
    # Click on 3 links in order to reach the page I want to scrape

    # Select and print an interesting element by its ID
    page = driver.find_element_by_class_name('unlist')
    arr = page.text.split("\n")
    links = []
    courseId = []
    cursor = cnx.cursor()

    for title in arr:
        links.append(driver.find_element_by_link_text(title))
        query = ("select exists(select className from ild_classes where className = '"+title+"') as exiists")
        cursor.execute(query)
        result = cursor.fetchall()[0][0]
        if result == 0:
            ##courseId.append(links[len(links)-1].get_attribute("href")[(links[len(links)-1].get_attribute("href")).index("=") + 1:])
            add_course = ("INSERT INTO ild_classes (className) VALUES('"+title+"')")
            cursor.execute(add_course)
            
    for link in links:
        courseId.append(link.get_attribute("href")[(link.get_attribute("href")).index("=") + 1:])

        
    
    arrAssignments = []
    arrAName = []
    arrDueDate = []
    courseAssignmentDictionary = []
    studentidQuery = ("select studentId, otterId from ild_students where otterId='"+username+"';")
    cursor.execute(studentidQuery)
    userOtterId = cursor.fetchall()[0][0]

    for index in range(len(courseId)):
        driver.get(assignmentLink + courseId[index])
        try:   
            page = driver.find_element_by_tag_name('tbody')
        except NoSuchElementException:
            continue
        
        arrAssignments = page.text.split("\n")
        
        for each in arrAssignments:
            tempClass = courseData.CourseData()
            tempClass.set_courseName(arr[index])
            tempArr = each.split(",")
            if len(tempArr) > 1:
                tempClass.set_assignmentName(tempArr[0])
                tempClass.set_assignmentDueDate(tempArr[1])
                courseAssignmentDictionary.append(tempClass)

    userOtterId = str(userOtterId)
    
    for assignment in courseAssignmentDictionary:
        getCourseIdQuery = ("SELECT classId FROM ild_classes WHERE className = '"+assignment.get_courseName()+"' ")
        cursor.execute(getCourseIdQuery)
        courseId = cursor.fetchall()[0][0]
        courseId = str(courseId)
        #Check for duplicates
        tempstr = assignment.get_assignmentName.replace("'","''")
        query = ("select exists(select assignmentName from ild_assignment where assignmentName = '"+tempstr+"') as exiists")
        cursor.execute(query)
        result = cursor.fetchall()[0][0]
        if result == 0:
            addAssignment =("INSERT INTO ild_assignment (dueDate, assignmentName, classId) VALUES(%s, %s, %s)")
            addAssignmentData = (assignment.get_assignmentDueDate(),assignment.get_assignmentName(),courseId)
            cursor.execute(addAssignment, addAssignmentData)

        assignmentIdq = ("select assignmentId from ild_assignment where assignmentName = '"+tempstr+"';")
        cursor.execute(assignmentIdq)
        assignmentIds = cursor.fetchall[0][0]
        assignmentIds = str(assignmentId)

        addStudentAssignment = ("INSERT INTO ild_assignment_grade (studentId, assignmentId) VALUES('"+(userOtterId)+"','"+(assignmentIds)+"')")
        cursor.execute(addStudentAssignment)
     
    cnx.commit()
except mysql.connector.Error as err:
    if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
        print("Something is wrong with your user name or password")
    elif err.errno == errorcode.ER_BAD_DB_ERROR:
        print("Database does not exist")
    else:
        print(err)
else:
    cnx.close()
