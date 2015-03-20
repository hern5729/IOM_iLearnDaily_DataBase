<?php

/*
 * To change this template use Tools | Templates.
 */

 function getConnection()
 {
 	// Creating Database Connection
	$host = "localhost";
	$dbname = "ild";
	$username = "ilearnOne";
	$password = "auznzSh6WFPG5nz9";
	$dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	//
	$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	
	return $dbConn;
 }
 


?>