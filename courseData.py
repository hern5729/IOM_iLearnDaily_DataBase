class CourseData( ):
    def __init__(self):
        self.assignmentName = ""
        self.assignmentDueDate = ""
        self.assignmentcourseName=""
        
    def get_assignmentName(self):
        return self.assignmentName

    def get_assignmentDueDate(self):
        return self.assignmentDueDate

    def get_courseName(self):
        return self.courseName

    def set_assignmentName(self, assignmentName):
        self.assignmentName = assignmentName
        
    def set_assignmentDueDate(self, assignmentDueDate):
        self.assignmentDueDate = assignmentDueDate
    def set_courseName(self, courseName):
        self.courseName = courseName
    
