<?php
// copyright 2017 DipFestival, LLC
/**
 * Created by PhpStorm.
 * User: correywinke
 * Date: 3/23/17
 * Time: 9:47 PM
 */ ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <a data-toggle="collapse" href="#pComments">Comments</a>
    </div>
    <div id="pComments" class="panel-body panel-collapse collapse">
        <form action="php/controller/search.php" method="post" id="searchPerson">
            <div class="form-group">
                <input class="form-control" type="text" value="<?php
                if(isset( $_SESSION['Comments']) == true) {
                    echo  $_SESSION['Comments'];
                } ?>" placeholder="Comment" name="comment">
            </div>
            <button type="submit" class="btn btn-default">Update comment</button>
            <input type="hidden" type="text" id="action" name="action" value="commentsUpdate">
            <input class="form-control" type="hidden" value="<?php
            if(isset( $_SESSION['VisitorID']) == true) {
                echo  $_SESSION['VisitorID'];
            } ?>" placeholder="VisitorID" name="VisitorID">
            <?php
            // require('../controller/defense.php');
            // for secutry
            echo makeToken();
            ?>
        </form>
    </div>
</div>
