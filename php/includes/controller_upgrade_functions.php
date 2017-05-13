<?php
    // copyright 2017 DipFestival, LLC

    require_once("../model/db.php");
    $IN_DEBUG_MODE = true;

    /*SUMMARY:
     *Takes in the original ticket ID (the ticket assignment id)
     *and the new ticket ID (the MerchID for ticket), and
     *performs all the MySQL mule work
     */
    /*SEE:
     * getAllUpgradeRequests()
     * runAllUpgradeRequests()
     *
     * this function and the other two work together to
     * perform all the actions required to upgrade a
     * persons ticket
     */
    /*PARAMETERS:
     * $originalTicketID (int) - The old ticket's TicketAssignment.TicketID
     *
     * $newTicketID (int) - Merchandise.MerchID of the ticket upgrade
     */
	function upgradeTicket($originalTicketID, $newTicketID)
    {
        //*** Variables ***
        //*****************
        $visitorID = filter_var($_SESSION['VisitorID']);
        
        //*** Send In "newTicketID", Get "newTicketPrice" ***
        //***************************************************
        $sql = "Select
                    Price
                From
                    Merchandise m inner join TicketAssignment ta on ta.MerchID=m.MerchID
                Where ta.TicketID = " . $newTicketID;
        
        if($IN_DEBUG_MODE) echo("<pre>".$sql."</pre>");
        $result = handSQL($sql, [], [], 0);

        if($IN_DEBUG_MODE) {
            if ($result /* contains something */) {
                // output data in row
                    echo "price: " . $result["price"];
            } else {
                echo "0 results";
            }
        }
        $newTicketPrice = $result["Price"];
        if($IN_DEBUG_MODE) echo($newTicketPrice);

        //*** Send In "originalTicketID", Get "originalTicketPrice" ***
        //*************************************************************
        $sql = "Select
                    Price
                From
                    Merchandise m inner join TicketAssignment ta on ta.MerchID=m.MerchID
                Where
                    ta.TicketID = " . $originalTicketID; 
        if($IN_DEBUG_MODE) echo("<pre>".$sql."</pre>");
        $result = handSQL($sql, [], [], 0);
        $originalTicketPrice = $result["Price"];
        if($IN_DEBUG_MODE) echo($originalTicketPrice);

        $date = date('Y-m-d H:i:s');

        //*** Get "UpgradeID" From Table "UpdateActivity" ***
        //***************************************************
        $sql = "Select
                    UpdateID
                From
                    UpdateActivity ua
                Where
                    ua.TicketID = " . $newTicketID; /* how is new ticket already in database? */
        if($IN_DEBUG_MODE) echo("<pre>".$sql."</pre>");
        $result = handSQL($sql, [], [], 0);
        $updateID = $result["UpdateID"];

        //*** MySQL Insert Statements ***
        //*******************************
        //if there is already a record in "UpdateActivity" for new ticket, just insert old ticket into "UpdateAssignment"
        if ($result /* contains something */) {
            //*** Insert Old Ticket Into "UpdateAssignment" ***
            $sql = "Insert Into UpdateAssignment (UpdateID, OriginalTicketID, OriginalTicketPrice) 
            VALUES (" . $updateID . ", " . $originalTicketID . ", " . $originalTicketPrice . ")"; 
            if($IN_DEBUG_MODE) echo("<pre>".$sql."</pre>");
            $result = handSQL($sql, [], [], 0);

            //If prev insert worked, invalidate ticket
            if($result /* contains something */)
            {
                $sql = "UPDATE TicketAssignment
                        SET IsValid = false
                        WHERE TicketID = " . $originalTicketID;
                if($IN_DEBUG_MODE) echo("<pre>".$sql."</pre>");
            }
        }
        //if there is no record yet, insert into both "UpdateActivity" and "UpdateAssignment"
        else {
            //*** Insert Into "UpdateActivity" ***
            $sql = "Insert Into UpdateActivity (VisitorID, NewTicketID, NewTicketPrice, ServiceCharge, DateUpdated) 
            VALUES (" . $visitorID . ", " . $newTicketID . ", " . $newTicketPrice . ", " . 20.00 . ", " . $date . ")"; 
            if($IN_DEBUG_MODE) echo("<pre>".$sql."</pre>");
            $result = handSQL($sql, [], [], 0);

            //if first MySQL insert statement was successful, insert stuff into "UpdateAssignment" 
            if($result /* contains something */)
            {	
                //*** Insert Into "UpdateAssignment" ***
                $sql = "Insert Into UpdateAssignment (UpdateID, OriginalTicketID, OriginalTicketPrice) 
                VALUES (" . $updateID . ", " . $originalTicketID . ", " . $originalTicketPrice . ")"; 
                $result = handSQL($sql, [], [], 0);

                //if second MySQL insert statement was successful, insert stuff into "TicketAssignment"
                if($result /* contains something */)
                {
                    //*** Insert Into "TicketAssignment" ***
                    $sql = "UPDATE TicketAssignment
                            SET IsValid = false
                            WHERE TicketID = " . $originalTicketID;
                    $result = handSQL($sql, [], [], 0);
                    if($IN_DEBUG_MODE) echo("Ticket Upgraded!");
                }
            }
            else
            {
                //*** Otherwise, Insert Failed ***
                echo("Failed to insert stuff into database (table: UpdateAssignment).");
            }
        }
    }

    /*SUMMARY:
     *Gets each value from each radio group where user did (element not null)
     *or did not (null) select option ticket
     */
    /*REMARKS:
     *Think of the key value pair of the returned array as a "visitor ticket being upgraded" (key)
     *"ticket type to upgrade to" (value) pair
     */
    /*RETURNS:
     *(array) - array of selected update values
     *          (key): user's assigned ticket being upgraded
     *          (value): MerchID of ticket upgrade
     *
     *values in key-value pair is NEVER null
     */
    function getAllUpgradeRequests()
    {
        //*** Variables ***
        //*****************
        $postedRadioGroups = array();
        //returned array
        $upgradeRequests = array();

        //*** Get Posted Radio Inputs ***
        //*******************************
        foreach /*thing in*/ ($_POST as $key => $postElement)
        {
            if(
            /*condition 1*/ preg_match("/selected-upgrade-for-visitor-ticket-<digit>+/", $key)
            /*condition 2*/ && $postElement != null)
            {
                array_push($postedRadioGroups, $postElement);
            }
        }

        //*** Create $upgradeRequests ("user ticket" - "upgrade merchID" Value Pairs) ***
        //*******************************************************************************
        foreach /*thing in*/ ($postedRadioGroups as $key => $radioGroupValue)
        {
            preg_match_all('/\d+/', $key, $numbers);
            $lastnum = end($numbers[0]);
            $upgradeRequests[$lastnum] = $radioGroupValue;
        }
        return $upgradeRequests;
    }

    /*SUMMARY:
     *Attemps to perform all ticket upgrade requests
     */
    /*SEE:
     * getUpgradeRequests()
     */
    function runAllUpgradeRequests()
    {
        $upgradeRequests = getAllUpgradeRequests();
        foreach /*thing in*/ ($upgradeRequests as $origTicketIDKey => $newTicketMerchIDValue)
        {
            upgradeTicket($origTicketIDKey, $newTicketMerchIDValue);
        }
    }
?>