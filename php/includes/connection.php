<?php
	//localhost connection
	$server="localhost";
	$username="dips2017_mainGat";
	$password="root";
	$db="dips2017_Festival_DB";

	$conn=new mysqli($server,$username,$password,$db);

    if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit;
    }
?>