<?php if(!isset($_SESSION)){ session_start(); } ?>
<!--
   // copyright 2017 DipFestival, LLC

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
//*** SQL Related PHP 0 ***
//************************
require '../model/db.php';

if(count($_SESSION['sqlValues']) == 0) {
    $ticketOfVisitorPrice = null;
    $ticketOfVisitorName = null;
} else {
    $ticketOfVisitorQuery
        = handSQL
    ('SELECT TicketTypes.Price, TicketTypes.Name
      FROM
          TicketAssignment INNER JOIN TicketTypes ON TicketAssignment.TicketTypeID = TicketTypes.TicketTypeID
      WHERE
          TicketAssignment.VisitorID = :visitorID'
        , [':visitorID']
        , [$_SESSION['sqlValues'][0]['VisitorID']]
        , 0
    );

    $ticketOfVisitorPrice = $ticketOfVisitorQuery['Price'];
    $ticketOfVisitorName = $ticketOfVisitorQuery['Name'];
}

$ticketTypesQuery
    = handSQL
    ('SELECT TicketTypes.TicketTypeID, TicketTypes.Name, TicketTypes.Price, Available.Total, TicketTypes.Description
         FROM TicketTypes INNER JOIN Available ON TicketTypes.AvailableID = Available.AvailableID'
    , [] ///* Function Default Value */
    , [] ///* Function Default Value */
    , 1 /* Fetch All Rows */
);

if($_SESSION['found'] == false) {
    $found = false;
} else {
    $found = true;
}

//*** Generate Ticket Type Option Information For Form ***
//*******************************************************
//*** Variables For Displaying Ticket Type Options ***
$isNoTicketTypeOptionsAvailable = true;
$visitorTicketInfo = "";
$ticketOptions = array();
$buttonsToEcho = "";

foreach /*thing in*/ ($ticketTypesQuery as $ticketType)
{
    //local variables
    $ticketTypeID = $ticketType[0];
    $ticketTypeName = $ticketType[1];
    $ticketTypePrice = $ticketType[2];
    $ticketTypeAvailable = $ticketType[3];
    $ticketTypeDescription = $ticketType[4];
    
    echo '<br><br><br>'.var_dump($ticketType).'<br><br><br>'.var_dump($ticketOfVisitorQuery).'<br><br><br>';

    //if ticket type's name contains "week" 
    //AND ticket is not visitor's ticket type, then don't show as option
    if((strpos(strtoupper($ticketTypeName), 'WEEK') !== false) && $ticketTypeName != $ticketOfVisitorName)
    {echo '<font class="blue-pill">thing</font><br> '; continue; echo 'something ';}
    echo '<font class="blue-pill">EOF</font> ';
    //entering this if statement means at least 1 ticket type was a selectable option, don't show "there are no ticket types" panel message
    if($ticketTypeAvailable > 0 && $ticketTypeName != $ticketOfVisitorName){
        echo '$ticketTypeName: '.$ticketTypeName;
    $isNoTicketTypeOptionsAvailable = false;
    }
    echo '<font class="orange-pill" color="orange">($OptionsAvailable: '.($isNoTicketTypeOptionsAvailable == false).') </font>';
    echo '<font class="blue-pill"> EOF#2</font><br>';

    //if visitor is found in mysql database,
    //AND ticket type is not visitors ticket type,
    //AND visitors ticket costs less than the ticket type that might be shown as an option then...
    if(/*visitor is not*/ !$found || ($ticketTypeName != $ticketOfVisitorName && $ticketOfVisitorPrice < $ticketTypePrice))
    {
        $isButtonDisabled = false;
        //if ticket type amount > 0, then don't disable button
        if($ticketTypeAvailable > 0) { $isButtonDisabled = false; }
        //else ticket type amount == 0, then disable button
        else if ($ticketTypeAvailable == 0){ $isButtonDisabled = true; }
        $ticketOptionDisabledText = $isButtonDisabled?'disabled':'';
        
        array_push($ticketOptions,"
           <label class='btn btn-default {$ticketOptionDisabledText}'>
               <input type='radio'
                             name='selected-ticket-type-option'
                             value='{$ticketTypeID}'
                             onclick='enableButton(\"register-and-upgrade-button\")'>
               <div>
                  {$ticketTypeName} \${$ticketTypePrice}<br>
                  Tickets Remaining: {$ticketTypeAvailable}<br>
                  -------- Description --------<br>
                  {$ticketTypeDescription}
               </div>
           </label>
           ");
    }
    //else if ticket type is visitors ticket type, then display visitors ticket type as nonclickable
   else if(/*visitor is*/ $found && $ticketTypeName == $ticketOfVisitorName)
   {
        $visitorTicketInfo
            = "<label class='btn btn-info disabled'>
                     <div>
                         Current Ticket: {$ticketTypeName} <br>
                         Price: {$ticketTypePrice}<br>
                         -------- Description --------<br>
                         {$ticketTypeDescription}
                     </div>
                 </label>
                ";
    }
}

//*** Build $buttonsToEcho ***
//***************************
if($visitorTicketInfo != null){ $buttonsToEcho .= $visitorTicketInfo; }
foreach /*thing in*/ ($ticketOptions as $ticketOption)
{
    $buttonsToEcho .= $ticketOption;
}

/*End NOTE:
  *Simply echo the variable $buttonsToEcho where you want the
  *buttons echoed + visitor ticket info 
  */
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Handle Visiter</title>
    <!-- Placeholder CSS Classes -->
    <!--
       Note:
       Will either be absorbed into a css document
       or eliminated completely.
       -->
    <!-- Bootstrap Related Meta Data -->
    <meta charset="utf-8">
    <meta name="theme-color" content="#ff8080">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="manifest.json">
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
    <link rel="icon", type="image/x-icon", href="images/favicon.ico">
    <link rel="stylesheet" href="dist/myStyle.css">
    <!-- TODO: get css myStyle.css to work correctly (panels don't show -->
    <!--<link rel="stylesheet" href="myStyle.css">-->
</head>
<body>
<div class="container">
    <!--- Top Padding --->
    <div class="page-top-padding">
    </div>
    <!--
       === PAGE MESSAGE ===
       -->
    <div class="row">
        <div class="col-xs-12">
            <!-
            === MESSAGE PANEL =============================
            ->
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if(/*visitor is*/ $found) :?>
                        <?php echo 'Visitor Is Registered' ?>
                    <?php else /*visitor not found*/ :?>
                        <?php echo 'Visitor Not Registered' ?>
                    <?php endif; ?>
                </div>
            </div>
            <!- Vertical Spacing ->
            <div class="page-vert-space">
            </div>
            <!-
            === FORM: REGISTRATION/ UPGRADE ==================
            ->
            <form action="php/view/controller.php" method="post">
                <!-
                *** Message Panel: Visitor Found? ***
                ************************************
                ->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php
                        //*** Choose Panel Title *** ?>
                        <?php if(/* visitor is */ $found) :?>
                            <?php echo 'Upgrade Visitor' ?>
                        <?php else /* visitor not found */:?>
                            <?php echo 'Complete Visitor Registration' ?>
                        <?php endif; ?>
                    </div>
                    <!- End Of Panel Heading ->
                    <div class="panel-body">
                        <?php
                        //*** Generate Vertical Button Group From MySQL Data *** ?>
                        <div class="btn-group btn-group-vertical" data-toggle="buttons">
                            <?php foreach /* thing in */ ($ticketTypeCountQuery AS $ticketType) :?>
                                <?php
                                $ticketTypeID = $ticketType[0];
                                $ticketTypeName = $ticketType[1];
                                $ticketTypePrice = $ticketType[2];
                                $ticketTypeAvailable = $ticketType[3];
                                $ticketTypeDescription = $ticketType[4];
                                ?>
                                <?php
                                /*Note:
                                 *If visitor is not found in MySQL database, then show
                                 *all ticket type options.
                                 *
                                 *If visitor is registered in MySQL database, then
                                 *show all valid ticket type upgrade options
                                 */?>
                                <?php if(/* visitor not */!$found || $ticketOfVisitorPrice < $ticketTypePrice): ?>
                                    <label class="btn
                              btn-default
                              <?php
                                    //if ticket type sold out, disable button
                                    if($ticketTypeAvailable == 0)
                                    { echo 'disabled'; }
                                    ?>">
                                        <input type="radio"
                                               name="selected-ticket-type-option"
                                               value=<?php echo '"'.$ticketTypeID.'"'?>
                                               onclick="enableButton('register-and-upgrade-button')">
                                        <!- radio button text ->
                                        <div>
                                            <?php echo $ticketTypeName.' ($'.$ticketTypePrice.')<br>Tickets Remaining: '.$ticketTypeAvailable.'<br>-------- Description --------<br>'.$ticketTypeDescription ?>
                                        </div>
                                    </label>
                                <?php endif; ?>
                                <?php
                                /*Note:
                                 *If visitor is registered in MySQL database,
                                 *then show visitor’s current ticket type
                                 */?>
                                <?php if(/* visitor is */ $found) :?>
                                    <?php
                                    /*Note:
                                     *If retrieved ticket type is the visitor’s ticket
                                     *type, then create unclickable option to show the
                                     *visitor’s current ticket type
                                     */?>
                                    <?php if($ticketOfVisitorPrice == $ticketTypePrice && $ticketOfVisitorName == $ticketTypeName): ?>
                                        <label class="btn btn-info disabled">
                                            <div>
                                                <?php echo 'Current Ticket: '.$ticketTypeName.'<br>Price: $'.$ticketTypePrice.'<br>-------- Description --------<br>'.$ticketTypeDescription ?>
                                            </div>
                                        </label>
                                        <?php
                                        /*Note:
                                         *The last else statement is commented out due to being
                                         *uneeded. It's kept as a commented out statement
                                         *to clarify how the program should work.
                                         */
                                        //else, don’t display invalid upgrade option (retrieved ticket type) ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <!- End Of Vertical Button Group ->
                    </div>
                    <!- End Of Panel Body ->
                    <div class="panel-footer">
                        <!<body>
<div class="container">
    <!--- Top Padding --->
    <div class="page-top-padding">
    </div>
    <!--
       === PAGE MESSAGE ===
       -->
    <div class="row">
        <div class="col-xs-12">
            <!--
            === MESSAGE PANEL =============================
            -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if(/*visitor is*/ $found) :?>
                        <?php echo 'Visitor Is Registered' ?>
                    <?php else /*visitor not found*/ :?>
                        <?php echo 'Visitor Not Registered' ?>
                    <?php endif; ?>
                </div>
            </div>
            <!- Vertical Spacing ->
            <div class="page-vert-space">
            </div>
            <!--
            === FORM: REGISTRATION/ UPGRADE ==================
            -->
            <form action="php/view/controller.php" method="post">
                <!--
                *** Message Panel: Visitor Found? ***
                ************************************
                -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php
                        //*** Choose Panel Title *** ?>
                        <?php if(/* visitor is */ $found) :?>
                            <?php echo 'Upgrade Visitor' ?>
                        <?php else /* visitor not found */:?>
                            <?php echo 'Complete Visitor Registration' ?>
                        <?php endif; ?>
                    </div>
                    <!-- End Of Panel Heading -->
                    <div class="panel-body">
                        <!-- ////////////////////////////////// -->
                        <!-- /// Auto Generated Error Panel /// -->
                        <div id="no-ticket-type-options-message"><!-- Auto Generated --></div>
                        <!-- /// Auto Generated Error Panel /// -->
                        <!-- ////////////////////////////////// -->
                        <?php
                        //*** Generate Vertical Button Group From MySQL Data *** ?>
                        <div class="btn-group btn-group-vertical" data-toggle="buttons">

                            <!--
                            --->
                            <?php echo $buttonsToEcho; ?>
                            <!--
                            --->
                            
                        </div>
                        <!-- End Of Vertical Button Group -->
                    </div>
                    <!-- End Of Panel Body -->
                    <div class="panel-footer">
                        <!-- Upgrade/ Registration Button -->
                        <?php
                        //*** Choose Button Text (Upgrade/ Register) *** ?>
                        <?php
                        $buttonText = "";
                        if(/* visitor is */ $found){ $buttonText = 'Upgrade'; }
                        else /* visitor not found */ { $buttonText = 'Register'; }
                        ?>
                        <!-- *** On Click Show Confirmation Box Modal *** -->
                        <button id="register-and-upgrade-button"
                                class="btn btn-primary disabled"
                                data-target="#confirmation-box"
                                data-toggle="modal"
                                onclick="updateConfirmationBoxMsg()"
                                disabled>
                            <?php
                            //*** Apply Choosen Button Text *** ?>
                            <?php echo $buttonText ?>
                        </button>
                    </div>
                    <!-- End Of Panel Footer -->
                </div>
                <!-- End Of Panel -->
                <!--
                *** Confirmation Box ***
                ***********************
                -->
                <div id="confirmation-box" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Confirmation Box</h4>
                            </div>
                            <div class="modal-body">
                                <p id="confirmation-box-text">
                                    <!--
                                    Auto-generated
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
                                       value="Yes">
                                <input type="hidden"
                                       name="action"
                                       value=<?php echo '"'.(/* visitor is */$found?'upgradePerson':'registerPerson').'"' ?>
                                       </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Of Confirmation Box -->
            </form>
        </div>
        <!-- End of col-xs-12 -->
    </div>
    <!-- End of row -->
    <!-- Vertical Spacing -->
    <div class="page-vert-space">
    </div>
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
       -->
    <div class="row">
        <div class="col-xs-12">
            <a href="findperson.php" class="btn btn-default">
                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Go Back
            </a>
        </div>
    </div>
    <!--- Bottom Padding --->
    <div class="page-bottom-padding">
    </div>
</div>
<!-- end of bootstrap container -->
<!--
=== JAVASCRIPT ===========================================
-->
<?php
    //if $isNoTicketTypeOptionsAvailable, then show "there are no ticket types" panel message
    if($isNoTicketTypeOptionsAvailable){
       echo '<script id="temp-script-1">
                       //*** Display No Ticket Types Panel Message ***
                       var messagePanel = document.getElementById("no-ticket-type-options-message");
                       messagePanel.classList.add("panel");
                       messagePanel.classList.add("panel-danger");
                       messagePanel.innerHTML
                           = "<div class=\"panel-heading\">"
                           + "    <strong>Opps...</strong>"
                           + "</div>"
                           + "<div class=\"panel-body\">"
                           + "    <p>There are no ticket type options to select</p>"
                           + "</div>";
                       //*** Delete The JavaScript That Created The Panel Message ***
                       var thisScript = document.getElementById("temp-script-1");
                       //delete temporary script
                       thisScript.outerHTML = "";
             </script>';
}                              
?>
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
<footer>
    <p>2017 DipFestival, LLC &copy;</p>
</footer>
</body>
</html>
