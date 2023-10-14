<?php

// include credentails file here

include "credentials.php";

// Database connection
$connection = new mysqli('localhost', $user, $pw, $db);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " .$connection->connect_error);
}


//select all records from the table
$AllRecords = $connection->prepare("select* from scp_subjects");

if(!$AllRecords){
    die("Connection failed: ".$connection->error);
}
$AllRecords->execute();
$results = $AllRecords->get_result();

?>
