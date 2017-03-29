<?php
	//localhost connection
    // talks to the database
	$server="localhost";
	$username="root";
	$password="root";
    $db="Festival_DB";

    $conn=new mysqli($server,$username,$password,$db);

    if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit;
    }
?>