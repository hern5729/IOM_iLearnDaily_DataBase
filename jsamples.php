<?php



	//Include - keeps processing everything else
	require '../includes/hackathon/dbConnection.php'; //interrupts the process 
	$dbConn = getConnection();
	///////////////////////////////////////////////////////////////////////
	
	//GETS ALL CLASSES
	function getClass()
	{
		$dbConn= getConnection();
		$sql = "SELECT * FROM `ild_classes` ";
		$stmt = $dbConn->prepare($sql); 
		$stmt->execute(); 
		return $stmt ->fetchAll();
	}
	
	//$classes = getClass();
	
	/////////////////////////////////////////////////////////////////////////////
	
	//GETS ALL STUDENTS
	function getStudents()
	{
		$dbConn= getConnection();
		$sql = "SELECT * FROM `ild_students`";
		$stmt = $dbConn->prepare($sql); 
		$stmt->execute(); 
		return $stmt ->fetchAll();
	}
	
//	$students = getStudents();
	
	
	//////////////////////////////////////////////////////////////////////////////
	
	//LOOKS FOR OTTERID AND STORES THE STUDENT ID
	
	
	function findStudent()
	{
		$dbConn= getConnection();
		$sql = "SELECT * FROM `ild_students`";
		$stmt = $dbConn->prepare($sql); 
		$stmt->execute(); 
		return $stmt ->fetchAll();
		
	}
	$studentID;
//	
	function printStudenInfo($json)  //------------------------------------------------------------------------
	{
		//$studentsArray = array();
		foreach($stundentFound  as $find)
		{
			if($find['otterId'] == $studentOtterId)
			{
				$studentID = $find['studentId'];
				echo "Student Name: ";
				echo $find['studentFirstName'] . " ".$find['studentLastname'];
				echo "<br>"."Student ID: ";
				echo $studentID;
				echo "<br> "."otter ID: " ;
				echo $find['otterId'] . "<br>";
				break;
			}
		}
	}
	//PRINTS OUT ALL THE CLASSES THAT THE STUDENT IS ENROLLED IN
	
	$classID;
	function getClassesStudents()
	{
		$dbConn= getConnection();
		$sql = "SELECT * FROM ild_classes_students  `";
		$stmt = $dbConn->prepare($sql); 
		$stmt->execute(); 
		return $stmt ->fetchAll();	
	}

	function getAssignments()
	{
		$dbConn= getConnection();
		$sql = "SELECT * FROM ild_assignment`";
		$stmt = $dbConn->prepare($sql); 
		$stmt->execute(); 
		return $stmt ->fetchAll();	
	}
	
	//$assignmentsHolder = getAssignments();
	
	function getAssignmentsGrades()
			{
				$dbConn= getConnection();
				$sql = "SELECT * FROM `ild_assignment_grade` ";
				$stmt = $dbConn->prepare($sql); 
				$stmt->execute(); 
				return $stmt ->fetchAll();	
			}
		
		
	
	function returnStudentID()
	{
		
			$stundentFound  = findStudent();
		$studentOtterId = "hern5729";
		
		$classes = getClass();
		$students = getStudents();
		
		$assignmentsHolder = getAssignments();
		foreach($stundentFound  as $find)
		{
			if($find['otterId'] == $studentOtterId)
			{
				$studentID = $find['studentId'];
				return $studentID;
			}
		}
	}
	
	
	
	////////////////////////////////////////////////////////////
	
	

	
	function printDuePageAndGradesPage() //----------------------------------------------------------------------------------------
	{
		$stundentFound  = findStudent();
		$studentOtterId = "hern5729";
		
		$classes = getClass();
		$students = getStudents();
		$assignmentsHolder = getAssignments();
		$assignmentsGradeHolder = getAssignmentsGrades();
		$classesStudentsHolder = getClassesStudents();
		$studentID = returnStudentID();
		$classesArray = array();
		$assignmentsArray = array();
		//$assignmentsNamesArray = array();
		$dueDatesArrray = array();
		$overallGradeArray = array();
		
		$assignmentsGradesArray = array();
		foreach($classesStudentsHolder as $classStudent)
		{
			 if($classStudent['studentId'] == $studentID)
			{
				$classIDFound = $classStudent['classId'];	
				
				//Prints Assignment Name 
				foreach($assignmentsHolder as $assignments)
				{
					if($classIDFound == $assignments['classId'])
					{
						echo "<br>"."ASSIGNMENTS DUE PAGE!";
						$assignmentFound = $assignments['assignmentId'];
						echo "<br>". "Due date: ";
						echo $assignments['dueDate'] . "<br>";
						$dueDatesArray[] = $assignments['dueDate'];					
					}
					
				}
				
				//Prints Class Info
				foreach ($classes as $class)
				{
					
					if($classIDFound == $class['classId'])
					{
						echo "Class name: ";
						echo $class['className'] ;
						$classesArray[] = $class['className'];
						//echo $class['classInstructor'] . "  ". $class['classSection'] . "<br>";
						
					}
				}
				
				//Prints Assignment Name 
				foreach($assignmentsHolder as $assignments)
				{
					if($classIDFound == $assignments['classId'])
					{
						$assignmentFound = $assignments['assignmentId'];
						echo "<br>" . "Assignment Name: ";
						echo $assignments['assignmentName'] . "<br>";
						$assignmentsArray[] = $assignments['assignmentName'];
					}
					
				}
				
				
				//Prints Class Info
				foreach ($classes as $class)
				{
					
					if($classIDFound == $class['classId'])
					{
						echo "<br>"."ASSIGNMENTS GRADE PAGE!";					
						echo "<br>"."Class name: ";
						echo $class['className'] ;
						$classesArray[] = $class['className'];
						//echo $class['classInstructor'] . "  ". $class['classSection'] . "<br>";
						
					}
				}
							
				echo " <br>". "Overall Grade: ";
				echo $classStudent['overallGrade'] . "<br> ";	
				$overallGradeArray[] = $classStudent['overallGrade'];
				echo "Last Graded: ";
				//Prints Assignment Name 
				foreach($assignmentsHolder as $assignments)
				{
					if($classIDFound == $assignments['classId'])
					{
						$assignmentFound = $assignments['assignmentId'];
						
						echo "<br>" . "Assignment Name: ";
						echo $assignments['assignmentName'] . "<br>";
						$assignmentsArray[] = $assignments['assignmentName'];
					}
					
				}
				
				foreach($assignmentsGradeHolder as $assigmentGrade)
				{
					if($assignmentFound == $assigmentGrade['assignmentid'])
					{
						echo "Percentage: ";
						echo $assigmentGrade['assignmentgrade'] . "</br>";
						$assignmentsGradesArray[] = $assigmentGrade['assignmentgrade'];
				}
				
			}					
		}
	}

	//print_r($classesArray);
	//print_r($assignmentsGradesArray);
	//print_r($assignmentsArray);
	//print_r($dueDatesArray);
	//print_r($overallGradeArray);
	
	$json = array(
		"classes" => $classesArray,
		"assignmentGrade" => $assignmentsGradesArray,
		"assignments" => $assignmentsArray,
		"dueDates"=>$dueDatesArrray,
		"overallGrade" => $overallGradeArray
	);
	return json_encode($json);


}
	
	////////////////////////////////////////////////////
	


if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$json = printDuePageAndGradesPage();
	
	
	
	
}

?>
