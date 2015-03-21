<?php

require "dbConnection.php";

if($_SERVER["REQUEST_METHOD"] == "POST" )
{
   if (isset($_POST['username']) && isset($_POST['password']))
	{
		$studentOtterID = $_POST['username'];
	    $studentpassword = $_POST['password'];
		$dbconn = getConnection();

		$sql = "select exists(select otterId from ild_students where otterId = '$studentOtterID') as exiists";
		$output = $dbconn->query($sql);
		$result = $output->fetch();
		if($result['exiists'] == 0)
		{
			$sql = "insert into ild_students (otterId) values ('$studentOtterID');";
			$statement = $dbconn->query($sql);
		}
		  passthru("python generateAssignments.py 1 2>&1".$studentOtterID." ".$studentpassword);
		  $sql = "select DISTINCT classes.className,assign.assignmentName, STR_TO_DATE(assign.dueDate,'%d %M %Y') as date
					from ild_assignment assign 
					inner join ild_classes classes on classes.classId=assign.classId 		
					inner join ild_assignment_grade sa on assign.assignmentId=sa.assignmentId		
					inner join ild_students students on sa.studentId = students.studentId		
                    where students.otterId = '$studentOtterID' 
					AND 
                    STR_TO_DATE(assign.dueDate,'%d %M %Y') BETWEEN SYSDATE() AND ADDDATE(SYSDATE(), INTERVAL 7 DAY)
					ORDER BY className";
			$x = $dbconn->query($sql);
			$items = $x -> fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json');

            echo json_encode($items,JSON_FORCE_OBJECT);

    }
}



?>
