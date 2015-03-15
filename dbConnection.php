<?php

/**
 * Created by PhpStorm.
 * User: edsan
 * Date: 3/15/15
 * Time: 3:08 AM
 */

function getConnection(){
    $host = "localhost";
    $dbName = "ild";
    $username = "root";
    $pass = "j5A2z0Z8y";

    $dbConn = new PDO("mysql:host=$host;dbname=$dbName", $username, $pass);
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConn;
}


?>