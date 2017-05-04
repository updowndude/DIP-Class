<?php
// check if the session has started
// copyright 2017 DipFestival, LLC
if(!isset($_SESSION)) {
    session_start();
}
?>
<html>
<head>
    <title>Main Gate</title>
    <meta charset="utf-8">
    <meta name="theme-color" content="#ff8080">
    <link rel="manifest" href="manifest.json">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="dist/myStyle.css" />
    <link rel="icon" type="image/x-icon" href="images/favicon.ico"/>
    <!-- Material Design fonts -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body id="whatBody">
<div class="container">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <a data-toggle="collapse" href="#pComments">Sorry</a>
        </div>
        <div id="pComments" class="panel-body in panel-collapse collapse">
            <h1>Sorry no hacking way into site</h1>
            <a href="logout" class="btn btn-raised btn-info"><span class="glyphicon glyphicon-home"></span></a>
        </div>
    </div>
</div>
<footer>
    <p>2017 DipFestival, LLC &copy;</p>
</footer>
<script type="text/javascript">
    // get the Javascript
    <?php echo file_get_contents("../../dist/my-com.js") ?>
</script>
</body>
</html>