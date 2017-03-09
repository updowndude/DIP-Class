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
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta charset="utf-8">
        <title>Main Gate</title>
        <link rel="icon" href="">
        <link rel="icon", type="image/x-icon", href="../../images/favicon.ico">
        <!--customer styles-->
        <link rel="stylesheet" type="text/css" href="../../dist/myStyle.css" />
    </head>
    <body class="body-style-light">
    <div class="container">
        <!--begin container-->
        <div class="panel panel-default">
            <div class="panel-heading">Logout</div>
            <div class="panel-body">You have successfully logged out.</div>
        </div>
        <a href="../../home" class="btn btn-default">Home</a>
<?php
//footer
require '../includes/footer.php';
?>