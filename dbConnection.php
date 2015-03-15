<?php

/*
 * To change this template use Tools | Templates.
 */

 function getConnection()
 {
 	// Creating Database Connection
	$host = "localhost";
	$dbname = "ild";
	$username = "root";
	$password = "Monsebaby27";
	$dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	//
	$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	
	return $dbConn;
 }
 


?>