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
	POSIBLE FORM ITEMS SENT:
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
/**/ $debug = true; /**/
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
				Merchandise.Price,
				Merchandise.MerchName,
				Merchandise.Description,
                TicketAssignment.TicketID
			FROM
				TicketAssignment
				INNER JOIN Merchandise ON TicketAssignment.MerchID = Merchandise.MerchID
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
//TODO refactor query name... to what???
$ticketTypesQuery = handSQL(/* OLD STUFF: '
		SELECT
			Merchandise.MerchID,
			Merchandise.MerchName,
			Merchandise.Price,
			Quantity.QuantityAvailable,
			Merchandise.Description
		FROM
			Merchandise
			INNER JOIN Quantity ON Merchandise.QuantityID = Quantity.QuantityID
            INNER JOIN MerchandiseCategory ON MerchandiseCategory.MerchCatID = Merchandise.MerchCatID
        WHERE
            MerchandiseCategory.MerchCatID BETWEEN 7 AND 11
        ORDER BY
            MerchandiseCategory.MerchCatID'*/'
            
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
//*** New Queries ***
//*******************
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
$CampingTicketOptionsQuery = filterOutVisitorTickets(handSql("
	SELECT
		Merchandise.MerchName,
		Merchandise.Price,
		Merchandise.Description,
		Quantity.QuantityAvailable
	FROM
		Merchandise
		INNER JOIN Quantity on Merchandise.QuantityID = Quantity.QuantityID
		INNER JOIN MerchandiseCategory on Merchandise.MerchCatID = MerchandiseCategory.MerchCatID
	WHERE
		MerchandiseCategory.MerchCatID = 7 -- Day Camping Tickets
	",
    [],
    [],
    1
));
/*SUMMARY
 *Contains only parking tickets the visitor doesn't own
 */
$ParkingTicketOptionsQuery = filterOutVisitorTickets(handSql("
	SELECT
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
$DayAdmissionTicketOptionsQuery = filterOutVisitorTickets(handSql("
	SELECT
		Merchandise.MerchName,
		Merchandise.Price,
		Merchandise.Description,
		Quantity.QuantityAvailable
	FROM
		Merchandise
		INNER JOIN Quantity on Merchandise.QuantityID = Quantity.QuantityID
		INNER JOIN MerchandiseCategory on Merchandise.MerchCatID = MerchandiseCategory.MerchCatID
	WHERE
		MerchandiseCategory.MerchCatID = 11 -- Day Admission Tickets
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
/*REMARKS:
*Please include the inlined javascript that created the
*custom HTML elements (i.e. <bs-row></bs-row> ).
*Otherwise, the echoed HTML will not render
*properly.
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
    $thingToEcho = "
		<div class='btn-group-vertical' data-toggle='buttons'>
		";
    global $ticketsOfVisitorQuery;
    global $isNoTicketOptionsAvailable;
    global $debug;
    if(!is_array($ticketsOfVisitorQuery)){ return; }
    if($debug){
        echo '<div style="background:black;color:lightgreen;font-family:consolas;padding:12px;">';
        echo '-----------------------------------<br>';
        echo '--- All tickets retrieved ---------<br>';
        echo '-----------------------------------<br>';}
    foreach /*thing in*/ ($ticketsOfVisitorQuery as $visitorTicket){
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
				<label class='btn btn-info {$disabledText}'>
                    <input
                        type='radio'
                        name='selected-visitor-ticket-option'
                        value='{$visitorTicket['TicketID']}'
                        >
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
*Should echo the dynamicaly created element with id "panel-ticket-options".
*/
/*REMARKS:
 *Button group will not be echoed if there are no
 *ticket options for the visitor to select.
 */
function echoTicketOptionsButtonGroup()
{
    global $ticketTypesQuery;
    global $ticketOfVisitorName;
    global $debug;
    global $isNoTicketOptionsAvailable;
    global $found;
    $thingToEcho = "";

    //*** Day Admission Tickets Button Group ***
    //******************************************
    $thingToEcho = "
        <h2>Day Admission Tickets</h2>
        <div class='btn-group-vertical' data-toggle='buttons'>
        ";
    foreach /*thing in*/ ($AdmissionTicketOptionsQuery as $ticketType){
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
                        <input type='check'
                            name='selected-day-admission-ticket-option[]'
                            value='{$ticketTypeID}'						
                        >
                        <div>
                            <strong>{$ticketTypeName}</strong><br>
                            Ticket Price: \${$ticketTypePrice}<br>
                            Tickets Remaining: {$ticketTypeAvailable}<br>
                            -------- Description --------<br>
                            {$ticketTypeDescription}
                        </div>
                    </label>
                ";
        }
    }
    //DEBUGGING PANEL END
    if($debug){echo '</div>';}
    $thingToEcho .= "
        </div>
        ";
    //*** Day Parking Tickets Button Group ***
    //****************************************
    $thingToEcho = "
        <h2>Day Parking Tickets</h2>
        <div class='btn-group-vertical' data-toggle='buttons'>
        ";
    foreach /*thing in*/ ($ParkingTicketOptionsQuery as $ticketType){
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
                        <input type='check'
                            name='selected-day-parking-ticket-option[]'
                            value='{$ticketTypeID}'						
                        >
                        <div>
                            <strong>{$ticketTypeName}</strong><br>
                            Ticket Price: \${$ticketTypePrice}<br>
                            Tickets Remaining: {$ticketTypeAvailable}<br>
                            -------- Description --------<br>
                            {$ticketTypeDescription}
                        </div>
                    </label>
                ";
        }
    }
    //DEBUGGING PANEL END
    if($debug){echo '</div>';}
    $thingToEcho .= "
        </div>
        ";
    //*** Day Camping Tickets Button Group ***
    //****************************************
    $thingToEcho = "
        <h2>Day Camping Tickets</h2>
        <div class='btn-group-vertical' data-toggle='buttons'>
        ";
    foreach /*thing in*/ ($CampingTicketOptionsQuery as $ticketType){
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
                        <input type='check'
                            name='selected-day-camping-ticket-option[]'
                            value='{$ticketTypeID}'						
                        >
                        <div>
                            <strong>{$ticketTypeName}</strong><br>
                            Ticket Price: \${$ticketTypePrice}<br>
                            Tickets Remaining: {$ticketTypeAvailable}<br>
                            -------- Description --------<br>
                            {$ticketTypeDescription}
                        </div>
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

    <?php /*
		<!-- Custom HTML Elements
		========================================== -->
		<script>
		//--- PANELS ---
		//--------------------------------------------
		//*** Panel Default: <bs-panel-default> ***
		//*****************************************
		var HTMLBsPanelDefaultProto = Object.create(HTMLDivElement.prototype);
		HTMLBsPanelDefaultProto.createdCallback
		= function()
		{
		var shadow = this.createShadowRoot();
		var elementInside = this.innerHTML;
		shadow.innerHTML = "<div class='panel panel-default'>" + elementInside + "</div>";
		}
		var HTMLBsPanelDefault = document.registerElement('bs-panel-default', {prototype: HTMLBsPanelDefaultProto});
		//*** Panel Danger: <bs-panel-danger> ***
		//***************************************
		var HTMLBsPanelDangerProto = Object.create(HTMLDivElement.prototype);
		HTMLBsPanelDangerProto.createdCallback
		= function()
		{
		var shadow = this.createShadowRoot();
		var elementInside = this.innerHTML;
		shadow.innerHTML = "<div class='panel panel-danger'>" + elementInside + "</div>";
		}
		var HTMLBsPanelDanger = document.registerElement("bs-panel-danger", {prototype: HTMLBsPanelDangerProto });
		//*** Panel Info: <bs-panel-info> ***
		//***********************************
		var HTMLBsPanelInfoProto = Object.create(HTMLDivElement.prototype);
		HTMLBsPanelInfoProto.createdCallback
		= function()
		{
		var shadow = this.createShadowRoot();
		var elementInside = this.innerHTML;
		shadow.innerHTML = "<div class='panel panel-info'>" + elementInside + "</div>";
		}
		var HTMLBsPanelInfo = document.registerElement('bs-panel-info', {prototype: HTMLBsPanelInfoProto});
		//*** Panel Success: <bs-panel-success> ***
		//*****************************************
		var HTMLBsPanelSuccessProto = Object.create(HTMLDivElement.prototype);
		HTMLBsPanelSuccessProto.createdCallback
		= function()
		{
		var shadow = this.createShadowRoot();
		var elementInside = this.innerHTML;
		shadow.innerHTML = "<div class='panel panel-success'>" + elementInside + "</div>";
		}
		var HTMLBsPanelSuccess = document.registerElement('bs-panel-success', {prototype: HTMLBsPanelSuccessProto});
		//*** Panel Warning: <bs-panel-warning> ***
		//*****************************************
		var HTMLBsPanelWarningProto = Object.create(HTMLDivElement.prototype);
		HTMLBsPanelWarningProto.createdCallback
		= function()
		{
		var shadow = this.createShadowRoot();
		var elementInside = this.innerHTML;
		shadow.innerHTML = "<div class='panel panel-warning'>" + elementInside + "</div>";
		}
		var HTMLBsPanelWarning = document.registerElement('bs-panel-warning', {prototype: HTMLBsPanelWarningProto});
		//*** Panel Primary: <bs-panel-primary> ***
		//*****************************************
		var HTMLBsPanelPrimaryProto = Object.create(HTMLDivElement.prototype);
		HTMLBsPanelPrimaryProto.createdCallback
		= function()
		{
		var shadow = this.createShadowRoot();
		var elementInside = this.innerHTML;
		shadow.innerHTML = "<div class='panel panel-primary'>" + elementInside + "</div>";
		}
		var HTMLBsPanelPrimary = document.registerElement('bs-panel-primary', {prototype: HTMLBsPanelPrimaryProto});
		//--- PANEL INTERNALS
		//-----------------------------------------
		//*** Panel-Heading: <bs-panel-heading> ***
		//*****************************************
		var HTMLBsPanelHeadingProto = Object.create(HTMLDivElement.prototype);
		HTMLBsPanelHeadingProto.createdCallback
		= function()
		{
		var shadow = this.createShadowRoot();
		var elementInside = this.innerHTML;
		shadow.innerHTML = "<div class='panel-heading'>" + elementInside + "</div>";
		}
		var HTMLBsPanelHeading = document.registerElement('bs-panel-heading', {prototype: HTMLBsPanelHeadingProto});
		//*** Panel-Body: <bs-panel-body> ***
		//***********************************
		var HTMLBsPanelBodyProto = Object.create(HTMLDivElement.prototype);
		HTMLBsPanelBodyProto.createdCallback
		= function()
		{
		var shadow = this.createShadowRoot();
		var elementInside = this.innerHTML;
		shadow.innerHTML = "<div class='panel-body'>" + elementInside + "</div>";
		}
		var HTMLBsPanelBody = document.registerElement('bs-panel-body', {prototype: HTMLBsPanelBodyProto});
		//*** Panel-Footer: <bs-panel-footer> ***
		//***************************************
		var HTMLBsPanelFooterProto = Object.create(HTMLDivElement.prototype);
		HTMLBsPanelFooterProto.createdCallback
		= function()
		{
		var shadow = this.createShadowRoot();
		var elementInside = this.innerHTML;
		shadow.innerHTML = "<div class='panel-footer'>" + elementInside + "</div>";
		}
		var HTMLBsPanelFooter = document.registerElement('bs-panel-footer', {prototype: HTMLBsPanelFooterProto});
		//--- OTHER BOOTSTRAP STUFF
		//-----------------------------------------
		//*** Container: <bs-container> ***
		//*********************************
		var HTMLBsContainerProto = Object.create(HTMLDivElement.prototype);
		HTMLBsContainerProto.createdCallback
		= function()
		{
		var shadow = this.createShadowRoot();
		var elementInside = this.innerHTML;
		shadow.innerHTML = "<div class='container'>" + elementInside + "</div>";
		}
		var HTMLBsContainer = document.registerElement('bs-container', {prototype: HTMLBsContainerProto});
		//*** Row <bs-row> ***
		//********************
		var HTMLBsRowProto = Object.create(HTMLDivElement.prototype);
		HTMLBsRowProto.createdCallback
		= function()
		{
		var shadow = this.createShadowRoot();
		var elementInside = this.innerHTML;
		shadow.innerHTML = "<div class='row'>" + elementInside + "</div>";
		}
		var HTMLBsRow = document.registerElement('bs-row', {prototype: HTMLBsRowProto});
		</script>
        */ ?>
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
                                <?php if((!$isNoTicketOptionsAvailable && /* visitor is */$found) || /* visitor is */ !$found): ?>
                                    <?php echoTicketOptionsButtonGroup(); ?>
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

<!-- Javascript
===================================================== -->
<script type="text/javascript">
    function enableButton(htmlElementID)
    {
        var htmlElement = document.getElementById(htmlElementID);
        htmlElement.classList.remove("disabled");
        htmlElement.disabled = false;
    }
    function updateConfirmationBoxMsg()
    {
        var htmlElements = document.getElementsByName('selected-ticket-type-option');
        var msgBoxElement = document.getElementById('confirmation-box-text');
        for (element of htmlElements)
        {
            if(element.checked)
            {
                msgBoxElement.innerHTML
                    = "Are you sure?<br>"
                    + "You’ve seleced the ticket type: <br>"
                    + element.parentElement.children[1].innerHTML;
            }
        }
    }
</script>

<script type="text/javascript">
    <?php echo file_get_contents("../../dist/my-com.js") ?>
</script>
</body>
</html>