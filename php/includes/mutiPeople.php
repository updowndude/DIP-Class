<?php
// copyright 2017 DipFestival, LLC
/**
 * Created by PhpStorm.
 * User: correywinke
 * Date: 3/6/17
 * Time: 12:45 PM
 */
?>
<div class="panel panel-danger">
    <div class="panel-heading">
        <a data-toggle="collapse" href="#pChoosePerson">Choose Person</a>
    </div>
        <div id="pChoosePerson" class="panel-body panel-collapse collapse">
            <form action="../controller/search.php" method="post" id="searchPerson">
                <div class="form-group">
                    <select class="form-control" name="choosePerson">
                        <?php
                        // loops though the people in query
                            foreach ($_SESSION['sqlValuesForMutiPeople'] as $curPerson) {
                                // check current person to display the correct vallue
                                if($curPerson["VisitorID"] == $_SESSION['VisitorID']) {
                                    // current person
                                    echo "<option value=\"{$curPerson["VisitorID"]}\" selected=\"selected\">{$curPerson["FName"]} {$curPerson["LName"]} {$curPerson["Email"]} {$curPerson["PhoneNumber"]}</option>";
                                } else {
                                    // stander output
                                    echo "<option value=\"{$curPerson["VisitorID"]}\">{$curPerson["FName"]} {$curPerson["LName"]} {$curPerson["Email"]} {$curPerson["PhoneNumber"]}</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            <button type="submit" class="btn btn-default" id="findPerson">Choose person</button>
            <input type="hidden" type="text" id="action" name="action" value="choosePerson">
                <?php
                    // require('../controller/defense.php');
                    // for secutry
                    echo makeToken();
                ?>
            </form>
        </div>
</div>
