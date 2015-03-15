from selenium import webdriver
from selenium.webdriver.support.ui import Select # for <SELECT> HTML form
import sys
import requests

driver = webdriver.PhantomJS('C:\phantomjs\phantomjs.exe')
# On Windows, use: webdriver.PhantomJS('C:\phantomjs-1.9.7-windows\phantomjs.exe')

# Service selection
# Here I had to select my school among others 
driver.get("https://sso.csumb.edu/cas/login?service=http%3A%2F%2Filearn.csumb.edu%2Flogin%2Findex.php%3FauthCAS%3DCAS")

# Login page (https://cas.ensicaen.fr/cas/login?service=https%3A%2F%2Fshibboleth.ensicaen.fr%2Fidp%2FAuthn%2FRemoteUser)
# Fill the login form and submit it
username = sys.argv[2]#"pesq8691"#sys.argv[2]
password = sys.argv[3]#"0254057W1s13u4kj"#sys.argv[3]
driver.find_element_by_id('username').send_keys(username)
driver.find_element_by_id('password').send_keys(password)
driver.find_element_by_id('fm1').submit()

# Now connected to the home page
# Click on 3 links in order to reach the page I want to scrape

# Select and print an interesting element by its ID
auth = "false"
try:
    page = driver.find_element_by_class_name('logininfo')
    #print (page.text)
    if("You are logged in as" in page.text):
        auth = "true"
except:
    auth = "false"
    
print (auth)    

