<!--
To change this template use Tools | Templates.
-->
<?php
	//Include - keeps processing everything else
	require 'dbConnection.php'; //interrupts the process
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
	
	$classes = getClass();
	
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
	
	$students = getStudents();
	
	
	//////////////////////////////////////////////////////////////////////////////
	
	//LOOKS FOR OTTERID AND STORES THE STUDENT ID
	
	$studentOtterId = "hern5729";
	function findStudent()
	{
		$dbConn= getConnection();
		$sql = "SELECT * FROM `ild_students`";
		$stmt = $dbConn->prepare($sql); 
		$stmt->execute(); 
		return $stmt ->fetchAll();
		
	}
	$studentID;
	$stundentFound  = findStudent();
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
	
	
	
	////////////////////////////////////////////////////////////
	
	//PRINTS OUT ALL THE CLASSES THAT THE STUDENT IS ENROLLED IN
	
	$classID;
	function getClassesStudents()
	{
		$dbConn= getConnection();
		$sql = "SELECT * FROM ild_classes_students";
		$stmt = $dbConn->prepare($sql); 
		$stmt->execute(); 
		return $stmt ->fetchAll();	
	}

	function getAssignments()
	{
		$dbConn= getConnection();
		$sql = "SELECT * FROM ild_assignment";
		$stmt = $dbConn->prepare($sql); 
		$stmt->execute(); 
		return $stmt ->fetchAll();	
	}
	
	$assignmentsHolder = getAssignments();
	
	function getAssignmentsGrades()
			{
				$dbConn= getConnection();
				$sql = "SELECT * FROM ild_assignment_grade ";
				$stmt = $dbConn->prepare($sql); 
				$stmt->execute(); 
				return $stmt ->fetchAll();	
			}
		
	$assignmentsGradeHolder = getAssignmentsGrades();
	
	
	$classesStudentsHolder = getClassesStudents();
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
				}
				
			}
			
			//Prints Class Info
			foreach ($classes as $class)
			{
				
				if($classIDFound == $class['classId'])
				{
					echo "Class name: ";
					echo $class['className'] ;
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
					//echo $class['classInstructor'] . "  ". $class['classSection'] . "<br>";
					
				}
			}
			
		
			echo " <br>". "Overall Grade: ";
			echo $classStudent['overallGrade'] . "<br> ";	
		
			echo "Last Graded: ";
			//Prints Assignment Name 
			foreach($assignmentsHolder as $assignments)
			{
				if($classIDFound == $assignments['classId'])
				{
					$assignmentFound = $assignments['assignmentId'];
					
					echo "<br>" . "Assignment Name: ";
					echo $assignments['assignmentName'] . "<br>";
				}
				
			}
			
			foreach($assignmentsGradeHolder as $assigmentGrade)
			{
				if($assignmentFound == $assigmentGrade['assignmentid'])
				{
					echo "Percentage: ";
					echo $assigmentGrade['assignmentgrade'] . "</br>";
			}
		}
	}
}
	?>
