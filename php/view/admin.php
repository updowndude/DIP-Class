<?php
// copyright 2017 DipFestival, LLC
/**
 * Created by PhpStorm.
 * User: correywinke
 * Date: 3/14/17
 * Time: 2:56 PM
 */
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
</head>
<body id="adimPage">
<div class="container">
    <h1><abbr title="Administrator">Admin</abbr></h1>
    <div class="panel panel-default">
        <div class="panel-heading"><a data-toggle="collapse" href="#pAVG">Arrivals vs. Expected Guests</a></div>
        <div id="pAVG" class="panel-body panel-collapse collapse">

        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><a data-toggle="collapse" href="#pCamping">VIP parking, RV camping, General Camping actual vs. expected</a></div>
        <div id="pCamping" class="panel-body panel-collapse collapse">

        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><a data-toggle="collapse" href="#pUAR">Upgrade activity and revenue</a></div>
        <div id="pUAR" class="panel-body panel-collapse collapse">

        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><a data-toggle="collapse" href="#pNGG">Number of guests on the grounds</a></div>
        <div id="pNGG" class="panel-body panel-collapse collapse">

        </div>
    </div>
    <a class="btn btn-default" id="btnLogout" href="logout">Logout</a
</div>
<script type="text/javascript">
    // get the Javascript
    <?php echo file_get_contents("../../dist/my-com.js") ?>
</script>
</body>
</html>
