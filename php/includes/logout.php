<?php

	ini_set('display_errors',0);
	include 'includes/functions.php';
	include 'includes/session_hijacking.php';
	//before_every_protected_page();
	request_is_same_domain();

	//check if cookie was sent from user's browser for the session
	if(isset($_COOKIE[session_name()])){
		//empty cookie
		setcookie(session_name(),'',time()-86400,'/');
	}

	//clear all session variables
	session_unset();

	//destroy the session
	session_destroy();

	

	include 'includes/header.php';
?>


<div class="alert alert-success">
	<p class="lead text-center">You have successfully logged out.</p>
</div>