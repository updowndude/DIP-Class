<?php
ini_set('display_errors',0);
require '../includes/functions.php';
require '../includes/session_hijacking.php';
//before_every_protected_page();
// request_is_same_domain();

//check if cookie was sent from user's browser for the session
if(isset($_COOKIE[session_name()])){
    //empty cookie
    setcookie(session_name(),'',time()-86400,'/');
}

//clear all session variables
session_unset();

//destroy the session
session_destroy();

header('Location: ../../home');
?>

