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
    if (isset($_POST['username']) && isset($_POST['password'])) {
    $studentOtterID = $_POST['username'];
    $studentpassword = $_POST['password'];

    $dbconn = getConnection();

    $sql = "select exists(select otterId from ild_students where otterId = '$studentOtterID') as exiists";
    $output = $dbconn->query($sql);
    $result = $output->fetch();
    if($result['exiists'] == 0){
        //echo "Does Not exist";
        $sql = "insert into ild_students (otterId) values ('$studentOtterID');";
        $statement = $dbconn->query($sql);

        //$statement->execute();
    }
    //echo "Hello";
//    exec("python generateAssignments.py". $studentOtterID." ".$studentpassword);
      passthru("python generateAssignments.py 1 2>&1".$studentOtterID." ".$studentpassword);

    }
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
    //echo "Hello";

}


?>
