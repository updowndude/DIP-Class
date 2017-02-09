<?php

	/*//atspace live connection
	$server="pdb11.atspace.me";
	$username="2054557_contacts";
	$password="databasepassword01";
	$db="2054557_contacts";*/

	//localhost connection
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