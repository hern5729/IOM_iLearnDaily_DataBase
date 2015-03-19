<?php

/*
 * To change this template use Tools | Templates.
 */

 function getConnection()
 {
 	// Creating Database Connection
	$host = "http://24.130.77.20/";
	$dbname = "ild";
	$username = "root";
	$password = "Monsebaby27";
	$dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	//
	$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	
	return $dbConn;
 }
 


?>