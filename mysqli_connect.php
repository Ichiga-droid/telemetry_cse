<?php # Script for connect to database - mysqli_connect.php
// This file contains the database access information. 
// This file also establishes a connection to MySQL 
// and selects the database.

$db_user = 'root';
$db_password = 'Motdepasse0!';
$db_host = '127.0.0.1';
  

// Set the database access information as constants:
DEFINE ('DB_USER', $db_user);
DEFINE ('DB_PASSWORD', $db_password);
DEFINE ('DB_HOST', $db_host);
DEFINE ('DB_NAME', 'telemetry');



// Make the connection:
$connection = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($connection, 'utf8');

?>
