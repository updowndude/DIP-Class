<?php
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
    <link rel="manifest" href="../../manifest.json">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../dist/myStyle.css" />
    <link rel="icon" type="image/x-icon" href="../../images/favicon.ico"/>
</head>
<body id="adimPage">
<div class="container">
    <h1><abbr title="Administrator">Admin</abbr></h1>
    <div class="panel panel-default">
        <div class="panel-heading"><abbr title="Administrator">Admin</abbr></div>
        <div class="panel-body">

        </div>
    </div>
</div>
<script type="text/javascript">
    // get the Javascript
    <?php echo file_get_contents("../../dist/my-com.js") ?>
</script>
</body>
</html>
