<?php
/**
 * Created by PhpStorm.
 * User: edsan
 * Date: 3/15/15
 * Time: 6:30 AM
 */

require "dbConnection.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST['username']) && isset($_POST['password'])) 
	{
		$studentOtterID = $_POST['username'];
		$studentpassword = //$_POST['password'];

		$dbconn = getConnection();

		$sql = "select exists(select otterId from ild_students where otterId = '$studentOtterID') as exiists";
		$output = $dbconn->query($sql);
		$result = $output->fetch();
		if($result['exiists'] == 0)
		{
			//echo "Does Not exist";
			$sql = "insert into ild_students (otterId) values ('$studentOtterID');";
			$statement = $dbconn->query($sql);

			//$statement->execute();
		}
		//echo "Hello";
		//exec("python generateAssignments.py". $studentOtterID." ".$studentpassword);
		  //passthru("python generateAssignments.py 1 2>&1".$studentOtterID." ".$studentpassword);
		  $sql = "select classes.className,assign.assignmentName, STR_TO_DATE(assign.dueDate,'%d %M %Y') as date
					from ild_assignment assign 
					inner join ild_classes classes on classes.classId=assign.classId 		
					inner join ild_assignment_grade sa on assign.assignmentId=sa.assignmentId		
					inner join ild_students students on sa.studentId = students.studentId		
					where students.otterId = '$studentOtterID'
					limit 10";
			$x = $dbconn->query($sql);
			$items = $x -> fetchAll();
			
			$json=json_encode($items);
			echo $json;
			return $json;
		
    }
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
    //echo "Hello";

}


?>
