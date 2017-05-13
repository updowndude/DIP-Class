<?php
// Copyright 2017 DipFestival, LLC

/*====== DOCUMENT I\O INFO ======
*VARIABLES REQUIRED:
*name: found
*origin: look-up form
*purpose: boolean value indicating if looked-up user is registered in database
*datatype: boolean
*POSIBLE FORM ITEMS SENT:
*{ Form: 1st form in code }
*name: action
*value: upgradePerson
*intended datatype: string
*{ Form: 2nd form in code }
*name: action
*value: registerPerson
*intended datatype: string
*/
?>
<?php if(!isset($_SESSION)){ session_start(); } ?>
<!--
	====== DOCUMENT I\O INFO ======
	VARIABLES REQUIRED:
	name: found
	origin: look-up form
	purpose: boolean value indicating if looked-up user is registered in database
	datatype: boolean
    POSTED FORM ITEMS USED BY CONTROLLER.php:
	{ Form: 1st form in code }
	name: action
	value: upgradePerson
	intended datatype: string
	{ Form: 2nd form in code }
	name: action
	value: registerPerson
	intended datatype: string
-->
<?php
	require '../model/db.php';

	///////////////////////////
	/// Debugging Variable ///
	/////////////////////////
	/**/ $debug = false; /**/
	///////////////////////

	/* PHP VARIABLES
	============================================================= */
	//*** Variables For Displaying Ticket Type Options ***
	$isNoTicketOptionsAvailable = true;

	//*** Variables From MySQL Querys ***
	//$ticketOfVisitorPrice;
	//$ticketOfVisitorName;

	$ticketsOfVisitorQuery;
	if(count($_SESSION['sqlValues']) == 0) {
		//$ticketOfVisitorPrice = null;
		//$ticketOfVisitorName = null;
	} else {
		//TODO: adjust code to show all tickets of Visitor
		$ticketsOfVisitorQuery = handSQL('
			SELECT
                Merchandise.MerchID,
				Merchandise.Price,
				Merchandise.MerchName,
				Merchandise.Description,
                TicketAssignment.TicketID,
                Quantity.QuantityAvailable
			FROM
				TicketAssignment
				INNER JOIN Merchandise ON TicketAssignment.MerchID = Merchandise.MerchID
                INNER JOIN Quantity on Merchandise.QuantityID = Quantity.QuantityID
			WHERE
				TicketAssignment.VisitorID = :visitorID'
		, [':visitorID']
		, [$_SESSION['sqlValues'][0]['VisitorID']]
		, 1
		);

		//Recently commented out
		//$ticketOfVisitorPrice = $ticketsOfVisitorQuery['Price'];
		//$ticketOfVisitorName = $ticketsOfVisitorQuery['MerchName'];
	}

	$ticketTypesQuery = handSQL('
    SELECT
        Merchandise.MerchID,
		Merchandise.MerchName,
		Merchandise.Price,
        Quantity.QuantityAvailable,
		Merchandise.Description
	FROM
		Merchandise
		INNER JOIN Quantity on Merchandise.QuantityID = Quantity.QuantityID
		INNER JOIN MerchandiseCategory on Merchandise.MerchCatID = MerchandiseCategory.MerchCatID
	WHERE
		MerchandiseCategory.MerchCatID = 7 OR -- Day Admission Tickets
        MerchandiseCategory.MerchCatID = 9 OR -- Day Parking Tickets
        MerchandiseCategory.MerchCatID = 11 -- Day Camping Tickets
        '
		, [] ///* Function Default Value */
		, [] ///* Function Default Value */
		, 1 /* Fetch All Rows */
		);

/*NOTE:
* Filters out tickets that the visitor owns
*/
function filterOutVisitorTickets($tickets)
{
	global $ticketsOfVisitorQuery;
	/*SUMMARY:
	 *Represents if the ticket from the $tickets
	 *should be added to the returned array $returnedResults.
	 */
	$isToBeAdded = false;
	/*SUMMARY:
	 *Array that this function returns.
	 */
	$returnedResults = array();

    //only filter out visitor tickets if visitor has tickets
    if($ticketsOfVisitorQuery != null)
    {
        foreach /* thing in */ ($tickets as $ticket)
        {
            foreach /* ticket in */ ($ticketsOfVisitorQuery as $ownedTicket)
            {
                //if  $ticket is one of the visitor's tickets...
                if($ticket['MerchName'] == $ownedTicket['MerchName'])
                {
                    /* exclude ticket from returned rows */
                } 
                else
                {
                    //tell function $ticket will be added to the returned tickets
                    $isToBeAdded = true;
                    //and stop going through the visitors tickets
                    break;
                }
            }
            if($isToBeAdded)
            {
                array_push($returnedResults, $ticket);
            }
        }
    }
    else
    {
        //... well turned out visitor didn't have tickets
        $returnedResults = $tickets;
    }
	return $returnedResults;
}

/*SUMMARY:
 *Contains only camping tickets the visitor doesn't own
 */
$DayCampingTicketOptionsQuery = filterOutVisitorTickets(handSQL("
	SELECT
        Merchandise.MerchID,
		Merchandise.MerchName,
		Merchandise.Price,
		Merchandise.Description,
		Quantity.QuantityAvailable
	FROM
		Merchandise
		INNER JOIN Quantity on Merchandise.QuantityID = Quantity.QuantityID
		INNER JOIN MerchandiseCategory on Merchandise.MerchCatID = MerchandiseCategory.MerchCatID
	WHERE
		MerchandiseCategory.MerchCatID = 11 -- Day Camping Tickets
	",
	[],
	[],
	1
	));

/*SUMMARY
 *Contains only parking tickets the visitor doesn't own
 */
$DayParkingTicketOptionsQuery = filterOutVisitorTickets(handSQL("
	SELECT
        Merchandise.MerchID,
		Merchandise.MerchName,
		Merchandise.Price,
		Merchandise.Description,
		Quantity.QuantityAvailable
	FROM
		Merchandise
		INNER JOIN Quantity on Merchandise.QuantityID = Quantity.QuantityID
		INNER JOIN MerchandiseCategory on Merchandise.MerchCatID = MerchandiseCategory.MerchCatID
	WHERE
		MerchandiseCategory.MerchCatID = 9 -- Day Parking Tickets
	",
	[],
	[],
	1
	));

/*SUMMARY:
 *Contains only admission tickets the visitor doesn't own
 */
$DayAdmissionTicketOptionsQuery = filterOutVisitorTickets(handSQL("
	SELECT
        Merchandise.MerchID,
		Merchandise.MerchName,
		Merchandise.Price,
		Merchandise.Description,
		Quantity.QuantityAvailable
	FROM
		Merchandise
		INNER JOIN Quantity on Merchandise.QuantityID = Quantity.QuantityID
		INNER JOIN MerchandiseCategory on Merchandise.MerchCatID = MerchandiseCategory.MerchCatID
	WHERE
		MerchandiseCategory.MerchCatID = 7 -- Day Admission Tickets
	",
	[],
	[],
	1
	));

	$found = false;
	if($_SESSION['found'] == false) {
		$found = false;
	} else {
		$found = true;
	}

	/* PHP FUNCTIONS
	============================================================= */
    /*SUMMARY:
     *Returns the merchId of
     *all upgrades of the entered id.
     */
    /*RETURNS:
     *(array) - array of all posiable upgrades for entered
     *ticket id
     */
    function findUpgrades($id){
    //49 --> Can't update
    if($id == 55
    || $id == 56
    || $id == 57
    || $id == 58
    || $id == 59
    || $id == 60
    || $id == 61) { return [49]; }
    //50 --> Can't update
    if($id == 62
    || $id == 63
    || $id == 64
    || $id == 65
    || $id == 66
    || $id == 67
    || $id == 68) { return [50]; }
    //51 --> Can't update
    if($id == 69
    || $id == 70
    || $id == 71
    || $id == 72
    || $id == 73
    || $id == 74) { return [51]; }
    if($id == 52){ return [53,54]; }
    if($id == 76){ return [52, 53, 54, 83, 90]; }
    if($id == 77){ return [52, 53, 54, 84, 91]; }
    if($id == 78){ return [52, 53, 54, 85, 92]; }
    if($id == 79){ return [52, 53, 54, 86, 93]; }
    if($id == 80){ return [52, 53, 54, 87, 94]; }
    if($id == 81){ return [52, 53, 54, 88, 95]; }
    if($id == 82){ return [52, 53, 54, 89, 96]; }
    if($id == 53){ return [54]; }
    if($id == 83){ return [53, 54, 90]; }
    if($id == 84){ return [53, 54, 91]; }
    if($id == 85){ return [53, 54, 92]; }
    if($id == 86){ return [53, 54, 93]; }
    if($id == 87){ return [53, 54, 94]; }
    if($id == 88){ return [53, 54, 95]; }
    if($id == 89){ return [53, 54, 96]; }
    //54 --> Can't update
    if($id == 90
    || $id == 91
    || $id == 92
    || $id == 93
    || $id == 94
    || $id == 95
    || $id == 96){ return [54]; }
    //97 --> Can't update
    //98 --> Can't update
    //99 --> Can't update
    //100 --> Can't update
    //101 --> Can't update
    //102 --> Can't update
    //103 --> Can't update
    //104 --> Can't update
    //105 --> Can't update
    //106 --> Can't update
    //107 --> Can't update
    //108 --> Can't update
    //109 --> Can't update
    //110 --> Can't update
    //111 --> Can't update
    //112 --> Can't update
    //113 --> Can't update
    //114 --> Can't update
    //115 --> Can't update
    //116 --> Can't update
    //117 --> Can't update
    }

    /*SUMMARY:
     *Returns boolean value indicating
     *if the second ticket id is a valid upgrade
     *for the first ticket id.
     */
    /*PARAMETERS:
     * $id - any ticket id
     *
     * $idInQuestion - id of ticket that may or may not be
     *                 be a valid upgrade for $id
     */
    /*RETURNS:
     * (Bool) - represents if a ticket is the upgrade of another ticket
     */
    function isUpgradeOf($id, $idInQuestion)
    {
      $allUpgradesOfTicket = findUpgrades($id);
      if(in_array($idInQuestion, $allUpgradesOfTicket))
      {
         return true;
      }
      else
      {
         return false;
      }
    }

    /*SUMMARY:
     *Returns array with no repeats that contains all valid
     *upgrades for tickets in a query.
     */
    /*RETURNS:
     * (array) - array of ticket ids
     */
    function returnAllValidUpgradeIds($ticketsQuery)
    {
      $validUpgrades = array();
      foreach /*thing in*/ ($ticketsQuery as $ticket){
        $upgrades = findUpgrades($ticket['MerchID']);
        if(sizeof($upgrades) !== 0){

          //just make sure that valid upgrades are NOT repeated
          foreach /*thing in*/ ($upgrades as $upgrade){
            if(!in_array($upgrade, $validUpgrades)){
              array_push($validUpgrades, $upgrade);
            }
          }
        }
      }

      //return array with no repeates
      return $validUpgrades;
    }

	/*SUMMARY:
	*Checks if a type of ticket is owned by the visitor.
	*/
	/*RETURNS:
	*bool
	*/
	function isTicketOfVisitor($ticket)
	{
		global $ticketsOfVisitorQuery;
		$visitorTickets = $ticketsOfVisitorQuery;
		if(!is_array($visitorTickets)){ return false; }
		foreach /* thing in */ ($visitorTickets as $visitorTicket)
		{
			if($ticket['MerchName'] == $visitorTicket['MerchName'])
			{ return true; }
		}
		return false;
	}

	/*SUMMARY:
	*Echos the element with id "panel-no-ticket-options"
	*, but only if the visitor has no ticket options
	* (for upgrading or registration) to select.
	*/
	function echoSubPanelNoTicketOptions()
	{echo '
			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3>Opps...</h3>
							<p>No ticket options available</p>
						</div>
					</div>
				</div>
			</div>
			';
	}

	/*SUMMARY:
	*Echos the dynamicaly created element with id "panel-visitor-tickets".
	*/
	function echoVisitorTicketsButtonGroup()
	{
		global $ticketsOfVisitorQuery;
		global $isNoTicketOptionsAvailable;
		global $debug;
        global $found;
        
        $thingToEcho = "
		<div class='btn-group-vertical' data-toggle='buttons'>
		";

		if(!is_array($ticketsOfVisitorQuery)){ return; }
		if($debug){
		echo '<div style="background:black;color:lightgreen;font-family:consolas;padding:12px;">';
		echo '-----------------------------------<br>';
		echo '--- All tickets retrieved ---------<br>';
		echo '-----------------------------------<br>';}
        
        $counter = 0;
		foreach /*thing in*/ ($ticketsOfVisitorQuery as $visitorTicket){
            $counter++;
            $htmlButtonId = "".$counter;
            
            $visitorTicketID = $visitorTicket['MerchID']; if($debug){echo 'visitorTicketID: '.$visitorTicketID.'<br>';}
			$visitorTicketName = $visitorTicket['MerchName']; if($debug){echo '$visitorTicketName: '.$visitorTicketName.' <br>';}
			$visitorTicketPrice = $visitorTicket['Price']; if($debug){echo '$visitorTicketPrice: '.$visitorTicketPrice.' <br>';}
			$visitorTicketDescription = $visitorTicket['Description']; if($debug){echo '$visitorTicketDescription: '.$visitorTicketDescription.' <br>';}
			if($debug){echo '--------------------------------------------<br>';}

			//contains "disabled" bootstrap css class, but only under a certain condition
			$disabledText = '';
			//if ticket type's name contains "week" 
			//(??? implement ???) AND ticket is not visitor's ticket type, then disable option
			if(strpos(strtoupper($visitorTicketName), 'WEEK') !== false){
				$disabledText = 'disabled';
			}
			else
			{
				$isNoTicketOptionsAvailable = false;
			}

			$thingToEcho .= "
				<label class='btn btn-info disabled'
                    ".($found?"onlick='gotoElement(\"upgrade-options-{$visitorTicketID}\")'":"").">
					<div>
						Visitor Ticket: {$visitorTicketName} <br>
						Price: {$visitorTicketPrice}<br>
						-------- Description --------<br>
						{$visitorTicketDescription}
					</div>
				</label>
			";
		}

			//DEBUGGING END
			if($debug){echo '</div>';}

		$thingToEcho .= "
		</div>
		";

		echo $thingToEcho;
	}

	/*SUMMARY:
	*Should echo the dynamicaly created elements with id "panel-ticket-upgrades-id#!num#".
	*/
	/*REMARKS:
	 *Button group will not be echoed if there are no
	 *ticket options for the visitor to select.
	 */
    /*RELEVENT HTML ID's AND NAMES
     *selected-upgrade-for-visitor-ticket-{$ticketTypeID}
     *  - Name of radio button group containing selected upgrade option.
     *
     *upgrade-options-{$ticketTypeID}
     *  - ID of element wraped around the radio button group.
     *  should only be used as a target to scroll to.
     */
    function echoTicketUpgradesButtonGroup()
    {
        global $ticketTypesQuery;
        global $ticketsOfVisitorQuery;
        global $DayAdmissionTicketOptionsQuery;
        global $DayParkingTicketOptionsQuery;
        global $DayCampingTicketOptionsQuery;
        global $ticketOfVisitorName;
        global $debug;
        global $isNoTicketOptionsAvailable;
        global $found;
        $thingToEcho = "";
        
        //*** Upgrades Button Group ***
        //*****************************
        $counter = 0;
        //get visitor tickets to upgrade
        foreach /*thing in*/ ($ticketsOfVisitorQuery as $ticketType){
            $ticketTypeID = $ticketType['MerchID'];
            $ticketAssignmentID = $ticketType['TicketID'];
            $ticketTypeName = $ticketType['MerchName'];          
            $ticketTypePrice = $ticketType['Price'];             
            $ticketTypeDescription = $ticketType['Description'];     
            $ticketTypeAvailable = $ticketType['QuantityAvailable']; 
            
            //*** Debugging Message (shown only when $debug is true) ***  
            if($debug){echo '$ticketTypeID: '.$ticketTypeID.' <br>';}
            if($debug){echo '$ticketTypeName: '.$ticketTypeName.' <br>';}
            if($debug){echo '$ticketTypePrice: '.$ticketTypePrice.' <br>';}
            if($debug){echo '$ticketTypeDescription: '.$ticketTypeDescription.' <br>';}
            if($debug){echo '$ticketTypeAvailable: '.$ticketTypeAvailable.' <br>';}
            if($debug){echo '--------------------------------------------<br>';}

            //*** Non-Debuging Stuff ***
            //if at least 1 ticket type was a selectable option
            //, then don't show "there are no ticket types" panel message
            if($ticketTypeAvailable > 0 && !isTicketOfVisitor($ticketType)){
                $isNoTicketOptionsAvailable = false;
            }
            
            //*** Begin Building $upgradesQuery ***
            $upgradesQueryStr = '
                SELECT
                    Merchandise.MerchID,
                    Merchandise.MerchName,
                    Merchandise.Price,
                    Quantity.QuantityAvailable,
                    Merchandise.Description
                FROM
                    Merchandise
                    INNER JOIN Quantity on Merchandise.QuantityID = Quantity.QuantityID
                    INNER JOIN MerchandiseCategory on Merchandise.MerchCatID = MerchandiseCategory.MerchCatID
                ';

                //*** Get Valid Ticket Upgrades ***
                $upgradeOptionsIdOnly = findUpgrades($ticketTypeID);
                        
                if(sizeof($upgradeOptionsIdOnly) > 0){
                    $upgradesQueryStr .= "WHERE
                    (MerchandiseCategory.MerchCatID = 7 OR
                    MerchandiseCategory.MerchCatID = 8 OR
                    MerchandiseCategory.MerchCatID = 9 OR
                    MerchandiseCategory.MerchCatID = 10 OR
                    MerchandiseCategory.MerchCatID = 11
                    ) AND (";
                    //*** Finish Building Query ***
                    foreach /*thing in*/($upgradeOptionsIdOnly as $key => $upgradeID){
                        //if end of $upgradeOptionsIdOnly...
                        if($key != sizeof($upgradeOptionsIdOnly) - 1)
                        {
                            $upgradesQueryStr .= "
                             Merchandise.MerchID = {$upgradeID} OR
                            ";
                        }
                        //else if last element in $upgradeOptionsIdOnly...
                        else
                        {
                            $upgradesQueryStr .= "
                             Merchandise.MerchID = {$upgradeID})
                            ";
                        }
                    }
                }
                else
                {
                    //cancels query
                    $upgradesQueryStr .= "WHERE FALSE";
                }
            
                //*** Execute Query ***
                $upgradesQuery = handSQL(
                $upgradesQueryStr
                , [] ///* Function Default Value */
                , [] ///* Function Default Value */
                , 1 /* Fetch All Rows */
                );
            
            if(/* contains upgrade options */ sizeof($upgradesQuery) > 0){
                $thingToEcho .= "
                    <br>
                    <h4>Upgrades For: {$ticketTypeName}</h4>
                    <div id='upgrade-options-{$ticketTypeID}' class='btn-group-vertical' 
                    data-toggle='buttons'>
                    ";
                foreach /*thing in*/($upgradesQuery as $upgrade){
                    $counter++;
                    $htmlButtonId = "btn-upgrade-".$counter;
            
                    $ticketTypeUpgradeID = $upgrade['MerchID'];
                    $ticketTypeUpgradeName = $upgrade['MerchName'];
                    $ticketTypeUpgradePrice = $upgrade['Price'];
                    $ticketTypeUpgradeDescription = $upgrade['Description'];
                    $ticketTypeUpgradeAvailable = $upgrade['QuantityAvailable'];
                    
                    $isButtonDisabled = false;
                    if ($ticketTypeUpgradeAvailable == 0)
                    { $isButtonDisabled = true; }

                    $ticketOptionDisabledText = $isButtonDisabled?'disabled':'';
                    $thingToEcho .= "
                        <label class='btn btn-default {$ticketOptionDisabledText}'
                            onclick='enableButton(\"register-and-upgrade-button\");gotoElement(\"panel-visitor-tickets\")'>
                            <input type='radio'
                                id='{$htmlButtonId}'
                                name='selected-upgrade-for-visitor-ticket-{$ticketAssignmentID}'
                                value='{$ticketTypeUpgradeID}'						
                            >
                            <div class='ticket-option-width'>
                                <strong>{$ticketTypeUpgradeName}</strong><br>
                                Ticket Price: \${$ticketTypeUpgradePrice}<br>
                                Tickets Remaining: {$ticketTypeUpgradeAvailable}<br>
                                -------- Description --------<br>
                                {$ticketTypeUpgradeDescription}
                            </div>
                            <script>
                                new ticketOption
                                    (document.getElementById('{$htmlButtonId}')
                                    ,{$ticketTypeID}
                                    ,'{$ticketTypeName}'
                                    ,{$ticketTypePrice}
                                    ,'{$ticketTypeDescription}'
                                    );
                            </script>
                        </label>
                    ";
                }
            }                
        }
        $thingToEcho .= "</div>";

        //DEBUGGING PANEL END
        if($debug){echo '</div>';}

        $thingToEcho .= "
        </div><br><br>
        ";       
        
		if($isNoTicketOptionsAvailable){ /* do nothing */ } else { echo $thingToEcho; }
    }

	/*SUMMARY:
	*Should echo the dynamicaly created element with id "panel-ticket-options".
	*/
	/*REMARKS:
	 *Button group will not be echoed if there are no
	 *ticket options for the visitor to select.
	 */
	function echoTicketOptionsButtonGroup()
	{
        global $ticketTypesQuery;
        global $DayAdmissionTicketOptionsQuery;
        global $DayParkingTicketOptionsQuery;
        global $DayCampingTicketOptionsQuery;
        global $ticketOfVisitorName;
        global $debug;
        global $isNoTicketOptionsAvailable;
        global $found;
        $thingToEcho = "";
        
        //***
        //*** Day Admission Tickets Button Group ***
        //***
        //***
        
        //*** Begin Button Group ***
        //**************************
        $thingToEcho = "
        <h4>Day Admission Tickets</h4>
        <div class='btn-group-vertical' data-toggle='buttons'>
        ";

        //*** Add Button For Each Day Admission Ticket Type ***
        //*****************************************************
        $counter = 0;
        foreach /*thing in*/ ($DayAdmissionTicketOptionsQuery as $ticketType){
            $counter++;
            $htmlButtonId = "btn-admission-".$counter;
            
            $ticketTypeID = $ticketType['MerchID'];              
            $ticketTypeName = $ticketType['MerchName'];          
            $ticketTypePrice = $ticketType['Price'];             
            $ticketTypeDescription = $ticketType['Description'];     
            $ticketTypeAvailable = $ticketType['QuantityAvailable']; 

            //*** Debugging Message (shown only when $debug is true) ***  
            if($debug){echo '$ticketTypeID: '.$ticketTypeID.' <br>';}
            if($debug){echo '$ticketTypeName: '.$ticketTypeName.' <br>';}
            if($debug){echo '$ticketTypePrice: '.$ticketTypePrice.' <br>';}
            if($debug){echo '$ticketTypeDescription: '.$ticketTypeDescription.' <br>';}
            if($debug){echo '$ticketTypeAvailable: '.$ticketTypeAvailable.' <br>';}
            if($debug){echo '--------------------------------------------<br>';}

            //*** Non-Debuging Stuff ***
            //if at least 1 ticket type was a selectable option
            //, then don't show "there are no ticket types" panel message
            if($ticketTypeAvailable > 0 && !isTicketOfVisitor($ticketType)){
                $isNoTicketOptionsAvailable = false;
            }

            //if visitor is found in mysql database (??? not in condition ???),
            //OR ticket type is not visitors ticket type,
            //AND ticket type is and upgrade for the visitor's ticket (by costing more)
            //, then...
            if(/* visitor is not found */ !$found
            || (!isTicketOfVisitor($ticketType)
            && /* javascript & PHP: selectedVisitorTicketPrice > $ticketTypePrice*/ 
                true
               /*$ticketOfVisitorPrice < $ticketTypePrice*/))
            {
                $isButtonDisabled = false;
                //if ticket type amount > 0, then don't disable button
                if($ticketTypeAvailable > 0) { $isButtonDisabled = false; }
                //else ticket type amount == 0, then disable button
                else if ($ticketTypeAvailable == 0){ $isButtonDisabled = true; }
                $ticketOptionDisabledText = $isButtonDisabled?'disabled':'';
                $thingToEcho .= "
                    <label class='btn btn-default {$ticketOptionDisabledText}'
                        onclick='enableButton(\"register-and-upgrade-button\")'>
                        <input type='checkbox'
                            id='{$htmlButtonId}'
                            name='selected-day-admission-ticket-option[]'
                            value='{$ticketTypeID}'						
                        >
                        <div class='ticket-option-width'>
                            <strong>{$ticketTypeName}</strong><br>
                            Ticket Price: \${$ticketTypePrice}<br>
                            Tickets Remaining: {$ticketTypeAvailable}<br>
                            -------- Description --------<br>
                            {$ticketTypeDescription}
                        </div>
                        <script>
                            new ticketOption
                                (document.getElementById('{$htmlButtonId}')
                                ,{$ticketTypeID}
                                ,'{$ticketTypeName}'
                                ,{$ticketTypePrice}
                                ,'{$ticketTypeDescription}'
                                );
                        </script>
                    </label>
                ";
            }
        }

        //DEBUGGING PANEL END
        if($debug){echo '</div>';}

        $thingToEcho .= "
        </div>
        ";

        //***
        //*** Day Parking Tickets Button Group ***
        //***
        //***
        
        //*** Begin Button Group ***
        //**************************
        $thingToEcho .= "
        <h4>Day Parking Tickets</h4>
        <div class='btn-group-vertical' data-toggle='buttons'>
        ";

        //*** Add Button For Each Day Parking Ticket Type ***
        //***************************************************
        $counter = 0;
        foreach /*thing in*/ ($DayParkingTicketOptionsQuery as $ticketType){
            $counter++;
            $htmlButtonId = "btn-parking-".$counter;
            
            $ticketTypeID = $ticketType['MerchID'];              
            $ticketTypeName = $ticketType['MerchName'];          
            $ticketTypePrice = $ticketType['Price'];             
            $ticketTypeDescription = $ticketType['Description'];     
            $ticketTypeAvailable = $ticketType['QuantityAvailable']; 

            //*** Debugging Message (shown only when $debug is true) ***  
            if($debug){echo '$ticketTypeID: '.$ticketTypeID.' <br>';}
            if($debug){echo '$ticketTypeName: '.$ticketTypeName.' <br>';}
            if($debug){echo '$ticketTypePrice: '.$ticketTypePrice.' <br>';}
            if($debug){echo '$ticketTypeDescription: '.$ticketTypeDescription.' <br>';}
            if($debug){echo '$ticketTypeAvailable: '.$ticketTypeAvailable.' <br>';}
            if($debug){echo '--------------------------------------------<br>';}

            //*** Non-Debuging Stuff ***
            //if at least 1 ticket type was a selectable option
            //, then don't show "there are no ticket types" panel message
            if($ticketTypeAvailable > 0 && !isTicketOfVisitor($ticketType)){
                $isNoTicketOptionsAvailable = false;
            }

            //if visitor is found in mysql database (??? not in condition ???),
            //OR ticket type is not visitors ticket type,
            //AND ticket type is and upgrade for the visitor's ticket (by costing more)
            //, then...
            if(/* visitor is not found */ !$found
            || (!isTicketOfVisitor($ticketType)
            && /* javascript & PHP: selectedVisitorTicketPrice > $ticketTypePrice*/ 
                true
               /*$ticketOfVisitorPrice < $ticketTypePrice*/))
            {
                $isButtonDisabled = false;
                //if ticket type amount > 0, then don't disable button
                if($ticketTypeAvailable > 0) { $isButtonDisabled = false; }
                //else ticket type amount == 0, then disable button
                else if ($ticketTypeAvailable == 0){ $isButtonDisabled = true; }
                $ticketOptionDisabledText = $isButtonDisabled?'disabled':'';
                $thingToEcho .= "
                    <label class='btn btn-default {$ticketOptionDisabledText}'>
                        <input type='checkbox'
                            id='{$htmlButtonId}'
                            name='selected-day-parking-ticket-option[]'
                            value='{$ticketTypeID}'						
                        >
                        <div class='ticket-option-width'>
                            <strong>{$ticketTypeName}</strong><br>
                            Ticket Price: \${$ticketTypePrice}<br>
                            Tickets Remaining: {$ticketTypeAvailable}<br>
                            -------- Description --------<br>
                            {$ticketTypeDescription}
                        </div>
                        <script>
                            new ticketOption
                                (document.getElementById('{$htmlButtonId}')
                                ,{$ticketTypeID}
                                ,'{$ticketTypeName}'
                                ,{$ticketTypePrice}
                                ,'{$ticketTypeDescription}'
                                );
                        </script>
                    </label>
                ";
            }
        }

        //DEBUGGING PANEL END
        if($debug){echo '</div>';}

        $thingToEcho .= "
        </div>
        ";

        //***
        //*** Day Camping Tickets Button Group ***
        //***
        //***
        
        //*** Begin Button Group ***
        //**************************
        $thingToEcho .= "
        <h4>Day Camping Tickets</h4>
        <div class='btn-group-vertical' data-toggle='buttons'>
        ";

        //*** Add Button For Each Day Camping Ticket Type ***
        //***************************************************
        $counter = 0;
        foreach /*thing in*/ ($DayCampingTicketOptionsQuery as $ticketType){
            $counter++;
            $htmlButtonId = "btn-camping-".$counter;
            
            $ticketTypeID = $ticketType['MerchID'];              
            $ticketTypeName = $ticketType['MerchName'];          
            $ticketTypePrice = $ticketType['Price'];             
            $ticketTypeDescription = $ticketType['Description'];     
            $ticketTypeAvailable = $ticketType['QuantityAvailable']; 

            //*** Debugging Message (shown only when $debug is true) ***  
            if($debug){echo '$ticketTypeID: '.$ticketTypeID.' <br>';}
            if($debug){echo '$ticketTypeName: '.$ticketTypeName.' <br>';}
            if($debug){echo '$ticketTypePrice: '.$ticketTypePrice.' <br>';}
            if($debug){echo '$ticketTypeDescription: '.$ticketTypeDescription.' <br>';}
            if($debug){echo '$ticketTypeAvailable: '.$ticketTypeAvailable.' <br>';}
            if($debug){echo '--------------------------------------------<br>';}

            //*** Non-Debuging Stuff ***
            //if at least 1 ticket type was a selectable option
            //, then don't show "there are no ticket types" panel message
            if($ticketTypeAvailable > 0 && !isTicketOfVisitor($ticketType)){
                $isNoTicketOptionsAvailable = false;
            }

            //if visitor is found in mysql database (??? not in condition ???),
            //OR ticket type is not visitors ticket type,
            //AND ticket type is and upgrade for the visitor's ticket (by costing more)
            //, then...
            if(/* visitor is not found */ !$found
            || (!isTicketOfVisitor($ticketType)
            && /* javascript & PHP: selectedVisitorTicketPrice > $ticketTypePrice*/ 
                true
               /*$ticketOfVisitorPrice < $ticketTypePrice*/))
            {
                $isButtonDisabled = false;
                //if ticket type amount > 0, then don't disable button
                if($ticketTypeAvailable > 0) { $isButtonDisabled = false; }
                //else ticket type amount == 0, then disable button
                else if ($ticketTypeAvailable == 0){ $isButtonDisabled = true; }
                $ticketOptionDisabledText = $isButtonDisabled?'disabled':'';
                $thingToEcho .= "
                    <label class='btn btn-default {$ticketOptionDisabledText}'>
                        <input type='checkbox'
                            id='{$htmlButtonId}'
                            name='selected-day-camping-ticket-option[]'
                            value='{$ticketTypeID}'						
                        >
                        <div class='ticket-option-width'>
                            <strong>{$ticketTypeName}</strong><br>
                            Ticket Price: \${$ticketTypePrice}<br>
                            Tickets Remaining: {$ticketTypeAvailable}<br>
                            -------- Description --------<br>
                            {$ticketTypeDescription}
                        </div>
                        <script>
                            new ticketOption
                                (document.getElementById('{$htmlButtonId}')
                                ,{$ticketTypeID}
                                ,'{$ticketTypeName}'
                                ,{$ticketTypePrice}
                                ,'{$ticketTypeDescription}'
                                );
                        </script>
                    </label>
                ";
            }
        }

        //DEBUGGING PANEL END
        if($debug){echo '</div>';}

        $thingToEcho .= "
        </div>
        ";
        
		if($isNoTicketOptionsAvailable){ /* do nothing */ } else { echo $thingToEcho; }
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Handle Visitor</title>

		<!-- Bootstrap Related Meta Data
		========================================== -->
		<meta charset="utf-8">
		<meta name="theme-color" content="#ff8080">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Custom Styling
		========================================== -->
		<style>
		.page-vert-space {
		height: /*-- VALUE --*/5px;
		}
		.page-bottom-padding {
		height: /*-- VALUE --*/0;
		}
		.page-top-padding {
		height: /*-- VALUE --*/35px;
		}
        .ticket-option-width{
        width:385px;
        }
		</style>

		<!-- Links
		========================================== -->
		<link rel="manifest" href="manifest.json">
		<link rel="icon", type="image/x-icon", href="images/favicon.ico">
		<!--<link rel="stylesheet" href="dist/myStyle.css">-->
		    <link rel="stylesheet" type="text/css" href="dist/myStyle.css" />
		<!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <!-- Javascript Constructors And Object Storage -->
        <script>
            //*** Storage For Self Storing Objects ***
            //****************************************
            allTicketOptions = new Array();

            //*** Constructors (add to normal javascript) ***
            //***********************************************
            function ticketOption(htmlElement, id, name, price, description)
            {
                this.htmlElement = htmlElement;
                this.id = id;
                this.name = name;
                this.price = (price.constructor.name=='String'?parseFloat(price):price);
                this.description = description;

                //add eventlistener for option being checked
                htmlElement.parentElement.addEventListener('click', function(){ /* uncheck radio button */ });
                //push this into collection of ticketTypes for access elsewhere
                allTicketOptions.push(this);
            }
        </script>
    </head>
	<body style="background:#252525;">
		<!-- Main HTML
		===================================================== -->
		<div class="container">
			<form id="main-form" action="php/view/controller.php" method="post">
			<div class="page-top-padding"><!-- Leave Empty --></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-default" id="panel-visitor-info">
						<div class="panel-body bg-info">
							<h2>Visitor <?php echo (/* visitor not */ !$found?'Not':''); ?> Registered In Database</h2>
							<?php echo '<label>First Name: '.$_SESSION['FName'].'</label><br>'; ?>
							<?php echo '<label>Last Name: '.$_SESSION['LName'].'</label><br>'; ?>
							<?php echo '<label>Email: '.$_SESSION['Email'].'</label><br>'; ?>
							<?php echo '<label>Some ID: '.$_SESSION['VisitorID'].'</label><br>'; ?>
							<?php echo '<label>Comments:</label><br>'; ?>
							<?php echo '<p>'.$_SESSION['Comments'].'</p>'; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-default" id="panel-options">
						<div class="panel-body">
							<h2>
								<?php if(/* visitor is */$found) : ?>
									Upgrade Visitor
								<?php else /* visitor not found */: ?>
									Complete Visitor Registration
								<?php endif; ?>
							</h2>
							<?php if($found): ?>
							<div class="panel panel-default" id="panel-visitor-tickets">
								<div class="panel-body">
									<h3>Select Visitor Ticket To Upgrade (If any can)</h3>
									<?php echoVisitorTicketsButtonGroup(); ?>
								</div>
							</div>
							<?php endif; ?>
							<div class="panel panel-default" id="panel-ticket-options">
								<div class="panel-body">
									<h3>Select Ticket Option</h3>
									<!-- Echo ticket options only if at least 1 exists -->
									<?php if(/* visitor is */ !$found): ?>
									<?php echoTicketOptionsButtonGroup(); ?>
					   				<?php elseif((!$isNoTicketOptionsAvailable && /* visitor is */$found)): ?>
									<?php echoTicketUpgradesButtonGroup(); ?>
									<?php endif; ?>
									<?php if($isNoTicketOptionsAvailable /* VALUE SOURCE: echoTicketOptionsButtonGroup() */) : ?>
									<div class="panel panel-danger" id="panel-no-ticket-options">
										<div class="panel-body bg-danger">
											<h3>Opps...</h3>
											<p>No ticket options available</p>
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="panel-footer">
							<!--- Button: Go Back --->
							<!--
							NOTE:
							The "Go Back" button is equivalent to pressing the
							web browser's back button. Although both buttons
							do the same thing, the "Go Back" button is
							a mental fail-safe against feature uncertainy
							(questioning what button to press next).
							Without the "Go Back" button it is possible
							that the flow of registration could be disrupted.

							Since findperson.php reloads available form data, the back button
							should take the volunteer back to the entered form data as expected.
							-->
							<a href="lookup.php" class="btn btn-default">
								<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Go Back
							</a>
					
							<!-- *** On Click Show Confirmation Box Modal *** -->
							<button id="register-and-upgrade-button"
							class="btn btn-primary disabled"
							data-target="#confirmation-box"
							data-toggle="modal"
							onclick="updateConfirmationBoxMsg()"
                            				disabled>
							<?php if(/* visitor is */ $found): ?>
							Upgrade
							<?php else: ?>
							Register
							<?php endif; ?>
							</button>
							
							<?php if(/* visitor is */ $found) : ?>
							<input name="action" type="hidden" value="upgradePerson">
							<?php else: ?>
							<input name="action" type="hidden" value="registerPerson">
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="page-bottom-padding"><!-- Leave Empty --></div>
			</form>
		</div>

		<!-- Webpage Footer: Copyright
		===================================================== -->
		<footer>
			<p>2017 DipFestival, LLC &copy;</p>
		</footer>

		<!-- Confirmation Box
		===================================================== -->
		<div id="confirmation-box" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Confirmation Box</h4>
					</div>
					<div class="modal-body">
						<p id="confirmation-box-text">
						<!--
						Auto-generated via javascript
						-->
						</p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-default"
						data-dismiss="modal">
						No
						</button>
					<input type="submit"
					class="btn btn-default"
					value="Yes"
					form="main-form"
					>
					<input type="hidden"
					name="action"
					value=<?php echo '"'.(/* visitor is */$found?'upgradePerson':'registerPerson').'"' ?>
					>
					</div>
				</div>
			</div>
		</div>

		<!-- Main Javascript
		===================================================== -->
		<script type="text/javascript">
            //*** Global Variables ***
            //************************
            var found = <?php echo $found!=true?'false':'true'?>;
            
            //*** Direct HTML Interaction Functions ***
            //*****************************************
            /*SUMMARY:
             *Enables buttons disabled through
             *Bootstrap CSS classes, and does a
             *real enabalization on the HTML element
             *in question
             */
			function enableButton(htmlElementID)
			{
				var htmlElement = document.getElementById(htmlElementID);
				htmlElement.classList.remove("disabled");
				htmlElement.disabled = false;
			}

            /*SUMMARY:
             *Provides the Bootstrap confirmation modal
             *with information on the tickets that are about
             *to be bought and the total cost of all those
             *tickets
             */
			function updateConfirmationBoxMsg()
			{
               var msgBoxElement = document.getElementById('confirmation-box-text');
                
                console.log(msgBoxElement);
               msgBoxElement.innerHTML
                   = "<strong>Message</strong><br>"
                   + "Are you sure you want to "
                        + (found?"upgrade":"purchase")
                        + " these tickets (no refunds)?<br><br>"
				   + "<strong>You’ve seleced the tickets: </strong><br>"
                   + "``````````````````````````````````````````````<br>";
                console.log("made it 2");
                var totalCost = 0;
                console.log(":::these exist in element array:::");
                console.log(getCheckedRadioAndCheckboxs());
				for (selectedTicket of getCheckedRadioAndCheckboxs())
				{
                    console.log("in a loop");
                    totalCost += selectedTicket.price;
                    msgBoxElement.innerHTML
                        += "<strong>"+selectedTicket.name+"</strong><br>"
                        +  "Ticket Price: $"+selectedTicket.price+"<br>"
                        +  "-------- Description --------<br>"
                        +  selectedTicket.description+"<br>"
                        +  "<br>";
				}
                console.log("getting the total");
                msgBoxElement.innerHTML
                    += "====================================================<br>"
                    +  "   <strong><i>Total Cost: $"+totalCost.toFixed(2)+"<i><strong>";
			}
            
            /*SUMMARY:
             *Instantly scrolls to the element
             *identified by the parameter 'elementId'
             */
            function gotoElement(elementId)
            {
                var destination = document.getElementById(elementId);
                destination.scrollIntoView({block:"start", behavior:"instant"});
            }
            
            //*** Make Radio Buttons Uncheckable ***
            /*DEBUG NOTE:
             *Does not currently work
             */
            var allRadioButtons = document.querySelectorAll("input[type=radio]");
            for (var radioButton of allRadioButtons)
            {
                radioButton.parentElement.addEventListener("click",
                    function()
                    {   console.log(radioButton);
                        if(radioButton.checked)
                        {

                            radioButton.checked = false;
                            radioButton.parentElement.classList.remove("active");
                            radioButton.parentElement.classList.remove("focus");
                        }
                    });
            }
            
            //*** Ticket Option Object Related Code ***
            //*****************************************
            /*SUMMARY:
             *Gets all checked radio buttons and checkboxes from
             *array argument 'radioAndCheckboxs', and returns
             *all checked radio buttons and checkboxes
             *as an array of 'ticketType' objects
             */
            /*SEE:
             * (near HTML top)
             * array: allTicketOptions
             * constructor: ticketOption
             */
            /*RETURNS:
             *(ticketType[]) - array of 'ticketType' objects
             */
            function getCheckedRadioAndCheckboxs()
            {
                var returnedValue = new Array();
                var radioAndCheckboxs = allTicketOptions;

                //find all checked elements
                for (var ticketOption of radioAndCheckboxs)
                {
                    if(ticketOption.htmlElement.checked){ returnedValue.push(ticketOption); }
                }

                return returnedValue;
            }        
		</script>

		<script type="text/javascript">
			<?php echo file_get_contents("../../dist/my-com.js") ?>
		</script>
	</body>
</html>
