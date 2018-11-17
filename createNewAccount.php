<?php

require 'pmdbinfo.php';
$connection = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdatabase);

// If connection was not successful, handle the error
if($connection === false) {
    // Handle error - notify administrator, log to a file, show an error screen, etc.
	echo "connection error";
	echo mysqli_error($connection);	
}

$username=$_GET['username'];
$password = $_GET['password'];

	$query="insert into user (email, password) values ('$username', '$password') ";

	$result = mysqli_query($connection,$query);
	if($result === false) {
		// Handle failure - log the error, notify administrator, etc.
		echo "insert failed";
		echo mysqli_error($connection);
	} else {
		// We successfully inserted a row into the database
		header ('location: http://127.0.0.1/software enginering - Copy/SoftE.Login2.html');
	}




?>