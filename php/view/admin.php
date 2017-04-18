<?php
// copyright 2017 DipFestival, LLC
/**
 * Created by PhpStorm.
 * User: correywinke
 * Date: 3/14/17
 * Time: 2:56 PM
 */
require '../model/db.php';
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
<body id="adimPage" class="body-style-light">
<div class="container">
    <h1><abbr title="Administrator">Admin</abbr></h1>
    <div class="panel panel-danger">
        <div class="panel-heading"><a data-toggle="collapse" href="#pAVG">Arrivals vs. Expected Guests</a></div>
        <div id="pAVG" class="panel-body panel-collapse collapse">
            <canvas id="pAVGC"></canvas>
        </div>
    </div>
    <div class="panel panel-danger">
        <div class="panel-heading"><a data-toggle="collapse" href="#pCamping">VIP parking, RV camping, General Camping actual vs. expected</a></div>
        <div id="pCamping" class="panel-body panel-collapse collapse">
            <canvas id="pCampingC"></canvas>
        </div>
    </div>
    <div class="panel panel-danger">
        <div class="panel-heading"><a data-toggle="collapse" href="#pUAR">Upgrade activity and revenue</a></div>
        <div id="pUAR" class="panel-body panel-collapse collapse">
            <canvas id="pUARC"></canvas>
        </div>
    </div>
    <div class="panel panel-danger">
        <div class="panel-heading"><a data-toggle="collapse" href="#pNGG">Number of guests on the grounds</a></div>
        <div id="pNGG" class="panel-body panel-collapse collapse">
            <canvas id="pNGGC"></canvas>
        </div>
    </div>
    <a class="btn btn-info btn-raised" id="btnLogout" href="logout">Logout</a
</div>
<script type="text/javascript">
    // get the Javascript
    // C = canvas
    // J = JSON
    // W = Week
    let pNGGCJW = <?php
    echo json_encode(handSQL("SELECT \"Attendance\" AS Attendance, COUNT(*) as numberOfGuest FROM TicketAssignment",[],[],0)) ?>;
    let pNGGCJMO = <?php
        echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 55 OR MerchID = 62 OR MerchID = 69 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51)",[],[],0)) ?>;
    let pNGGCJTU = <?php
        echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 56 OR MerchID = 63 OR MerchID = 70 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51)",[],[],0)) ?>;
    let pNGGCJWE = <?php
        echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 57 OR MerchID = 64 OR MerchID = 71 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51) ",[],[],0)) ?>;
    let pNGGCJTH = <?php
        echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 58 OR MerchID = 65 OR MerchID = 72 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51) ",[],[],0)) ?>;
    let pNGGCJFR = <?php
        echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 59 OR MerchID = 66 OR MerchID = 73 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51)",[],[],0)) ?>;
    let pNGGCJSA = <?php
        echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 60 OR MerchID = 67 OR MerchID = 74 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51)",[],[],0)) ?>;
    let pNGGCJSU = <?php
        echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 61 OR MerchID = 68 OR MerchID = 75 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51)",[],[],0)) ?>;
    <?php echo file_get_contents("../../dist/my-com.js") ?>;
</script>
</body>
</html>
