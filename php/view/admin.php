<?php
// copyright 2017 DipFestival, LLC
if(!isset($_SESSION)) {
    session_start();
}
/**
 * Created by PhpStorm.
 * User: correywinke
 * Date: 3/14/17
 * Time: 2:56 PM
 */
require '../model/db.php';

if(isset($_SESSION['loggedInUser']) == true) {
    if ($_SESSION['loggedInUser'] != 'maingateadmin'){
        header('Location: what');
    }
} else {
    header('Location: what');
}
echo $_SESSION['loggedInUser'];
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
        <div class="panel-heading"><a data-toggle="collapse" href="#pUAR">Total revenue</a></div>
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
    <a class="btn btn-info btn-raised" id="btnLogout" href="logout">Logout</a>
</div>
<script type="text/javascript">
    // get the Javascript
    // C = canvas
    // J = JSON
    // W = Week
    // T = Toal
    let pNGGCJW = <?php echo json_encode(handSQL("SELECT \"Attendance\" AS Attendance, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE CheckedIn = TRUE",[],[],0)) ?>;
    let pNGGCJMO = <?php echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 55 OR MerchID = 62 OR MerchID = 69 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51) AND CheckedIn = TRUE",[],[],0)) ?>;
    let pNGGCJTU = <?php echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 56 OR MerchID = 63 OR MerchID = 70 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51) AND CheckedIn = TRUE",[],[],0)) ?>;
    let pNGGCJWE = <?php echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 57 OR MerchID = 64 OR MerchID = 71 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51) AND CheckedIn = TRUE",[],[],0)) ?>;
    let pNGGCJTH = <?php echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 58 OR MerchID = 65 OR MerchID = 72 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51) AND CheckedIn = TRUE",[],[],0)) ?>;
    let pNGGCJFR = <?php echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 59 OR MerchID = 66 OR MerchID = 73 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51) AND CheckedIn = TRUE",[],[],0)) ?>;
    let pNGGCJSA = <?php echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 60 OR MerchID = 67 OR MerchID = 74 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51) AND CheckedIn = TRUE",[],[],0)) ?>;
    let pNGGCJSU = <?php echo json_encode(handSQL("SELECT \"Monday\" AS Day, COUNT(*) as numberOfGuest FROM TicketAssignment WHERE (MerchID = 61 OR MerchID = 68 OR MerchID = 75 OR MerchID = 49 OR MerchID = 50 OR MerchID = 51) AND CheckedIn = TRUE",[],[],0)) ?>;
    let pAVGJW = <?php echo json_encode(handSQL("SELECT \"Total\" As Total, (SELECT COUNT(*) As Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR m.MerchCatID = 7) AND ((ta.MerchID BETWEEN 49 AND 51) OR (ta.MerchID BETWEEN 55 AND 75))) AS Expected, (SELECT COUNT(CheckedIn) As Arrived FROM TicketAssignment WHERE CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR m.MerchCatID = 7) AND ((ta.MerchID BETWEEN 49 AND 51) OR ta.MerchID BETWEEN 55 AND 75)) - (SELECT COUNT(*) FROM TicketAssignment WHERE CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID BETWEEN 49 AND 51 OR ta.MerchID BETWEEN 55 AND 75 GROUP BY Expected",[],[],0)) ?>;
    let pAVGJMO = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR m.MerchCatID = 7 AND (m.MerchID = 55 OR m.MerchID = 62 OR m.MerchID = 69)) AND ta.MerchID = 49 OR ta.MerchID = 55 OR ta.MerchID = 50 OR ta.MerchID = 62 OR ta.MerchID = 51 OR ta.MerchID = 69) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 55 OR MerchID = 50 OR MerchID = 62 OR MerchID = 51 OR MerchID = 69) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR (m.MerchCatID = 7 AND (m.MerchID = 55 OR m.MerchID = 62 OR m.MerchID = 69))) AND ta.MerchID = 49 OR ta.MerchID = 55 OR ta.MerchID = 50 OR ta.MerchID = 62 OR ta.MerchID = 51 OR ta.MerchID = 69) - (SELECT COUNT(*) FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 55 OR MerchID = 50 OR MerchID = 62 OR MerchID = 51 OR MerchID = 69) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 55 OR ta.MerchID = 50 GROUP BY Expected ",[],[],0)) ?>;
    let pAVGJTU = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR m.MerchCatID = 7 AND (m.MerchID = 56 OR m.MerchID = 63 OR m.MerchID = 70)) AND ta.MerchID = 49 OR ta.MerchID = 56 OR ta.MerchID = 50 OR ta.MerchID = 63 OR ta.MerchID = 51 OR ta.MerchID = 70) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 56 OR MerchID = 50 OR MerchID = 63 OR MerchID = 51 OR MerchID = 70) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR (m.MerchCatID = 7 AND (m.MerchID = 56 OR m.MerchID = 63 OR m.MerchID = 70))) AND ta.MerchID = 49 OR ta.MerchID = 56 OR ta.MerchID = 50 OR ta.MerchID = 63 OR ta.MerchID = 51 OR ta.MerchID = 70) - (SELECT COUNT(*) FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 56 OR MerchID = 50 OR MerchID = 63 OR MerchID = 51 OR MerchID = 70) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 56 OR ta.MerchID = 50 GROUP BY Expected ",[],[],0)) ?>;
    let pAVGJWE = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR m.MerchCatID = 7 AND (m.MerchID = 57 OR m.MerchID = 64 OR m.MerchID = 71)) AND ta.MerchID = 49 OR ta.MerchID = 57 OR ta.MerchID = 50 OR ta.MerchID = 64 OR ta.MerchID = 51 OR ta.MerchID = 71) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 57 OR MerchID = 50 OR MerchID = 64 OR MerchID = 51 OR MerchID = 70) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR (m.MerchCatID = 7 AND (m.MerchID = 57 OR m.MerchID = 64 OR m.MerchID = 71))) AND ta.MerchID = 49 OR ta.MerchID = 57 OR ta.MerchID = 50 OR ta.MerchID = 64 OR ta.MerchID = 51 OR ta.MerchID = 71) - (SELECT COUNT(*) FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 57 OR MerchID = 50 OR MerchID = 64 OR MerchID = 51 OR MerchID = 70) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 57 OR ta.MerchID = 50 GROUP BY Expected ",[],[],0)) ?>;
    let pAVGJTH = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR m.MerchCatID = 7 AND (m.MerchID = 58 OR m.MerchID = 65 OR m.MerchID = 71)) AND ta.MerchID = 49 OR ta.MerchID = 58 OR ta.MerchID = 50 OR ta.MerchID = 65 OR ta.MerchID = 51 OR ta.MerchID = 72) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 58 OR MerchID = 50 OR MerchID = 65 OR MerchID = 51 OR MerchID = 71) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR (m.MerchCatID = 7 AND (m.MerchID = 58 OR m.MerchID = 65 OR m.MerchID = 72))) AND ta.MerchID = 49 OR ta.MerchID = 58 OR ta.MerchID = 50 OR ta.MerchID = 65 OR ta.MerchID = 51 OR ta.MerchID = 72) - (SELECT COUNT(*) FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 58 OR MerchID = 50 OR MerchID = 65 OR MerchID = 51 OR MerchID = 71) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 58 OR ta.MerchID = 50 GROUP BY Expected ",[],[],0)) ?>;
    let pAVGJFR = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR m.MerchCatID = 7 AND (m.MerchID = 59 OR m.MerchID = 66 OR m.MerchID = 72)) AND ta.MerchID = 49 OR ta.MerchID = 59 OR ta.MerchID = 50 OR ta.MerchID = 66 OR ta.MerchID = 51 OR ta.MerchID = 73) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 59 OR MerchID = 50 OR MerchID = 66 OR MerchID = 51 OR MerchID = 72) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR (m.MerchCatID = 7 AND (m.MerchID = 59 OR m.MerchID = 66 OR m.MerchID = 73))) AND ta.MerchID = 49 OR ta.MerchID = 59 OR ta.MerchID = 50 OR ta.MerchID = 66 OR ta.MerchID = 51 OR ta.MerchID = 73) - (SELECT COUNT(*) FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 59 OR MerchID = 50 OR MerchID = 66 OR MerchID = 51 OR MerchID = 72) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 59 OR ta.MerchID = 50 GROUP BY Expected ",[],[],0)) ?>;
    let pAVGJSA = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR m.MerchCatID = 7 AND (m.MerchID = 60 OR m.MerchID = 67 OR m.MerchID = 73)) AND ta.MerchID = 49 OR ta.MerchID = 60 OR ta.MerchID = 50 OR ta.MerchID = 67 OR ta.MerchID = 51 OR ta.MerchID = 74) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 60 OR MerchID = 50 OR MerchID = 67 OR MerchID = 51 OR MerchID = 73) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR (m.MerchCatID = 7 AND (m.MerchID = 60 OR m.MerchID = 67 OR m.MerchID = 74))) AND ta.MerchID = 49 OR ta.MerchID = 60 OR ta.MerchID = 50 OR ta.MerchID = 67 OR ta.MerchID = 51 OR ta.MerchID = 74) - (SELECT COUNT(*) FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 60 OR MerchID = 50 OR MerchID = 67 OR MerchID = 51 OR MerchID = 73) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 60 OR ta.MerchID = 50 GROUP BY Expected ",[],[],0)) ?>;
    let pAVGJSU = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR m.MerchCatID = 7 AND (m.MerchID = 61 OR m.MerchID = 68 OR m.MerchID = 74)) AND ta.MerchID = 49 OR ta.MerchID = 61 OR ta.MerchID = 50 OR ta.MerchID = 68 OR ta.MerchID = 51 OR ta.MerchID = 75) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 61 OR MerchID = 50 OR MerchID = 68 OR MerchID = 51 OR MerchID = 74) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 8 OR (m.MerchCatID = 7 AND (m.MerchID = 61 OR m.MerchID = 68 OR m.MerchID = 75))) AND ta.MerchID = 49 OR ta.MerchID = 61 OR ta.MerchID = 50 OR ta.MerchID = 68 OR ta.MerchID = 51 OR ta.MerchID = 75) - (SELECT COUNT(*) FROM TicketAssignment WHERE (MerchID = 49 OR MerchID = 61 OR MerchID = 50 OR MerchID = 68 OR MerchID = 51 OR MerchID = 74) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 61 OR ta.MerchID = 50 GROUP BY Expected ",[],[],0)) ?>;
    let pCampingJMO = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 76 OR m.MerchID = 83 OR m.MerchID = 90)) AND ta.MerchID = 76 OR ta.MerchID = 83 OR ta.MerchID = 90 OR ta.MerchID BETWEEN 52 AND 54) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 76 OR MerchID = 83 OR MerchID = 90 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 76 OR m.MerchID = 83 OR m.MerchID = 90)) AND ta.MerchID = 76 OR ta.MerchID = 83 OR ta.MerchID = 90 OR ta.MerchID BETWEEN 52 AND 54) - (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 76 OR MerchID = 83 OR MerchID = 90 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 55 OR ta.MerchID = 50 GROUP BY Expected",[],[],0)) ?>;
    let pCampingJTU = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 77 OR m.MerchID = 84 OR m.MerchID = 91)) AND ta.MerchID = 77 OR ta.MerchID = 84 OR ta.MerchID = 91 OR ta.MerchID BETWEEN 52 AND 54) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 77 OR MerchID = 84 OR MerchID = 91 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 77 OR m.MerchID = 84 OR m.MerchID = 91)) AND ta.MerchID = 77 OR ta.MerchID = 84 OR ta.MerchID = 91 OR ta.MerchID BETWEEN 52 AND 54) - (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 77 OR MerchID = 84 OR MerchID = 91 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 56 OR ta.MerchID = 50 GROUP BY Expected",[],[],0)) ?>;
    let pCampingJWE = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 78 OR m.MerchID = 85 OR m.MerchID = 92)) AND ta.MerchID = 78 OR ta.MerchID = 85 OR ta.MerchID = 92 OR ta.MerchID BETWEEN 52 AND 54) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 78 OR MerchID = 85 OR MerchID = 92 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 78 OR m.MerchID = 85 OR m.MerchID = 92)) AND ta.MerchID = 78 OR ta.MerchID = 85 OR ta.MerchID = 92 OR ta.MerchID BETWEEN 52 AND 54) - (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 78 OR MerchID = 85 OR MerchID = 92 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 57 OR ta.MerchID = 50 GROUP BY Expected",[],[],0)) ?>;
    let pCampingJTH = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 79 OR m.MerchID = 86 OR m.MerchID = 93)) AND ta.MerchID = 79 OR ta.MerchID = 86 OR ta.MerchID = 93 OR ta.MerchID BETWEEN 52 AND 54) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 79 OR MerchID = 86 OR MerchID = 93 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 79 OR m.MerchID = 86 OR m.MerchID = 93)) AND ta.MerchID = 79 OR ta.MerchID = 86 OR ta.MerchID = 93 OR ta.MerchID BETWEEN 52 AND 54) - (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 79 OR MerchID = 86 OR MerchID = 93 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 58 OR ta.MerchID = 50 GROUP BY Expected",[],[],0)) ?>;
    let pCampingJFR = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 80 OR m.MerchID = 87 OR m.MerchID = 94)) AND ta.MerchID = 80 OR ta.MerchID = 87 OR ta.MerchID = 94 OR ta.MerchID BETWEEN 52 AND 54) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 80 OR MerchID = 87 OR MerchID = 94 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 80 OR m.MerchID = 87 OR m.MerchID = 94)) AND ta.MerchID = 80 OR ta.MerchID = 87 OR ta.MerchID = 94 OR ta.MerchID BETWEEN 52 AND 54) - (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 80 OR MerchID = 87 OR MerchID = 94 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 59 OR ta.MerchID = 50 GROUP BY Expected",[],[],0)) ?>;
    let pCampingJSA = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 81 OR m.MerchID = 88 OR m.MerchID = 95)) AND ta.MerchID = 81 OR ta.MerchID = 88 OR ta.MerchID = 95 OR ta.MerchID BETWEEN 52 AND 54) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 81 OR MerchID = 88 OR MerchID = 95 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 81 OR m.MerchID = 88 OR m.MerchID = 95)) AND ta.MerchID = 81 OR ta.MerchID = 88 OR ta.MerchID = 95 OR ta.MerchID BETWEEN 52 AND 54) - (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 81 OR MerchID = 88 OR MerchID = 95 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 60 OR ta.MerchID = 50 GROUP BY Expected",[],[],0)) ?>;
    let pCampingJSU = <?php echo json_encode(handSQL("SELECT \"Monday\" As Day, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 82 OR m.MerchID = 89 OR m.MerchID = 96)) AND ta.MerchID = 82 OR ta.MerchID = 89 OR ta.MerchID = 96 OR ta.MerchID BETWEEN 52 AND 54) AS Expected, (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 82 OR MerchID = 89 OR MerchID = 96 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) AS Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9 AND (m.MerchID = 82 OR m.MerchID = 89 OR m.MerchID = 96)) AND ta.MerchID = 82 OR ta.MerchID = 89 OR ta.MerchID = 96 OR ta.MerchID BETWEEN 52 AND 54) - (SELECT COUNT(*) AS Arrived FROM TicketAssignment WHERE (MerchID = 82 OR MerchID = 89 OR MerchID = 96 OR MerchID BETWEEN 52 AND 54) AND CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID = 49 OR ta.MerchID = 61 OR ta.MerchID = 50 GROUP BY Expected",[],[],0)) ?>;
    let pCampingJW = <?php echo json_encode(handSQL("SELECT \"Total\" As Total, (SELECT COUNT(*) As Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9) AND ((ta.MerchID BETWEEN 52 AND 54) OR (ta.MerchID BETWEEN 76 AND 96))) AS Expected,(SELECT COUNT(CheckedIn) As Arrived FROM TicketAssignment WHERE CheckedIn = TRUE) AS Arrived, (SELECT COUNT(*) As Expected FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE (m.MerchCatID = 10 OR m.MerchCatID = 9) AND ((ta.MerchID BETWEEN 52 AND 54) OR (ta.MerchID BETWEEN 76 AND 96))) - (SELECT COUNT(CheckedIn) As Arrived FROM TicketAssignment WHERE CheckedIn = TRUE) AS NoShows FROM TicketAssignment ta INNER JOIN Merchandise m ON ta.MerchID = m.MerchID WHERE ta.MerchID BETWEEN 52 AND 54 OR ta.MerchID BETWEEN 76 AND 96 GROUP BY Expected",[],[],0)) ?>;
    let pUARJW = <?php echo json_encode(handSQL("SELECT MerchName, Price, (SELECT Count(*) FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased BETWEEN \"2017-06-01\" AND \"2017-06-08\" AND ta.IsValid = TRUE) * Price AS WeeklyTotal, \"6-01 to 6-08\" AS Week FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased BETWEEN \"2017-06-01\" AND \"2017-06-08\" AND ta.IsValid = TRUE GROUP BY m.MerchName",[],[],0)) ?>;
    let pUARJMO = <?php echo json_encode(handSQL("SELECT MerchName, Price, (SELECT Count(*) FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-01\" AND ta.IsValid = TRUE) * Price AS DailyTotal, DatePurchased FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-01\" AND ta.IsValid = TRUE GROUP BY m.MerchName",[],[],0)) ?>;
    let pUARJTU = <?php echo json_encode(handSQL("SELECT MerchName, Price, (SELECT Count(*) FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-01\" AND ta.IsValid = TRUE) * Price AS DailyTotal, DatePurchased FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-02\" AND ta.IsValid = TRUE GROUP BY m.MerchName",[],[],0)) ?>;
    let pUARJWE = <?php echo json_encode(handSQL("SELECT MerchName, Price, (SELECT Count(*) FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-01\" AND ta.IsValid = TRUE) * Price AS DailyTotal, DatePurchased FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-03\" AND ta.IsValid = TRUE GROUP BY m.MerchName",[],[],0)) ?>;
    let pUARJTH = <?php echo json_encode(handSQL("SELECT MerchName, Price, (SELECT Count(*) FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-01\" AND ta.IsValid = TRUE) * Price AS DailyTotal, DatePurchased FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-04\" AND ta.IsValid = TRUE GROUP BY m.MerchName",[],[],0)) ?>;
    let pUARJFR = <?php echo json_encode(handSQL("SELECT MerchName, Price, (SELECT Count(*) FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-01\" AND ta.IsValid = TRUE) * Price AS DailyTotal, DatePurchased FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-05\" AND ta.IsValid = TRUE GROUP BY m.MerchName",[],[],0)) ?>;
    let pUARJSA = <?php echo json_encode(handSQL("SELECT MerchName, Price, (SELECT Count(*) FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-01\" AND ta.IsValid = TRUE) * Price AS DailyTotal, DatePurchased FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-06\" AND ta.IsValid = TRUE GROUP BY m.MerchName",[],[],0)) ?>;
    let pUARJSU = <?php echo json_encode(handSQL("SELECT MerchName, Price, (SELECT Count(*) FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-01\" AND ta.IsValid = TRUE) * Price AS DailyTotal, DatePurchased FROM Merchandise m INNER JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE m.MerchName = \"Ticket Adult_Week\" AND ta.DatePurchased = \"2017-06-07\" AND ta.IsValid = TRUE GROUP BY m.MerchName",[],[],0)) ?>;
    let pUARJT = <?php echo json_encode(handSQL("SELECT * FROM (SELECT MerchName, Quantity, Price, SUM(TotalSales) AS \"TotalSales\" FROM (SELECT \"Service Charge\" AS MerchName, Count(ServiceCharge) AS Quantity, ServiceCharge AS Price, (COUNT(ServiceCharge) * ServiceCharge) AS TotalSales FROM UpdateActivity ua INNER JOIN TicketAssignment ta ON ua.NewTicketID = ta.TicketID INNER JOIN Merchandise m ON ta.MerchID = m.MerchID UNION SELECT MerchName, Quantity, Price, SUM(Quantity * Price) AS TotalSales FROM Merchandise m INNER JOIN order_items oi ON m.MerchID = oi.Product_ID INNER JOIN orders o ON oi.order_id = o.id LEFT JOIN TicketAssignment ta ON m.MerchID = ta.MerchID WHERE ((m.MerchID BETWEEN 1 AND 48) OR (m.MerchID BETWEEN 49 AND 117 AND ta.IsValid = TRUE)) GROUP BY MerchName) t GROUP BY MerchName WITH ROLLUP) t WHERE MerchName is NULL",[],[],0)) ?>;

    <?php echo file_get_contents("../../dist/my-com.js") ?>;
</script>
</body>
</html>
