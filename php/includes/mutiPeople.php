<?php
/**
 * Created by PhpStorm.
 * User: correywinke
 * Date: 3/6/17
 * Time: 12:45 PM
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <a data-toggle="collapse" href="#pChoosePerson">Choose Person</a>
    </div>
        <div id="pChoosePerson" class="panel-body panel-collapse collapse">
            <form action="../controller/search.php" method="post" id="searchPerson">
                <div class="form-group">
                    <select class="form-control" name="choosePerson">
                        <?php
                            foreach ($_SESSION['sqlValuesForMutiPeople'] as $curPerson) {
                                if($curPerson["VisitorID"] == $_SESSION['VisitorID']) {
                                    echo "<option value=\"{$curPerson["VisitorID"]}\" selected=\"selected\">{$curPerson["FName"]} {$curPerson["LName"]}</option>";
                                } else {
                                    echo "<option value=\"{$curPerson["VisitorID"]}\">{$curPerson["FName"]} {$curPerson["LName"]}</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            <button type="submit" class="btn btn-default" id="findPerson">Choose person</button>
            <input type="hidden" type="text" id="action" name="action" value="choosePerson">
            </form>
        </div>
</div>
