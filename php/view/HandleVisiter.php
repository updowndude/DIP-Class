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
//*** SQL Related PHP ***
//**********************
  $TicketTypeCountQuery
    = handSQL
    ('SELECT TicketTypes.TicketTypeID, TicketTypes.Name, TicketTypes.Price, Available.Total
      FROM TicketTypes INNER JOIN Available ON TicketTypes.AvailableID = Available.AvailableID'
    , ///* Function Default Value */
    , ///* Function Default Value */
    , 1 /* Fetch All Rows */
    );
  $TicketOfVisitorQuery
    = handSQL
    ('SELECT
        TicketTypes.Price
      FROM
        TicketAssignment INNER JOIN TicketTypes ON TicketAssignment.TicketTypeID = TicketTypes.TicketTypeID
      WHERE
        :visitorID = TicketAssignment.VisitorID
        AND TicketAssignment.TicketTypeID = TicketTypes.TicketTypeID'
    , [":visitorID"]
    , [$_SESSION["sqlValues"]["VisitorID"]]
    , 0
    );
  $TicketOfVisitorPrice = $TicketOfVisitorQuery[0];
?>
<?php
if($_SESSION['found'] == false) {
    $found = false;
} else {
    $found = true;
}
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <!--- SCRIPTS --->
    <!--
      Placeholder
    -->
    <!--- CSS --->
    <!--
      Placeholder
    -->
      <link rel="icon", type="image/x-icon", href="../../images/favicon.ico">
      <link rel="stylesheet" href="../../dist/myStyle.css">
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
              <div class="panel panel-default">
                <div class="panel-heading">
                  Visiter Status  
                </div>
                <div class="panel-body">
                  <p id="msgPanel" class="text-center" style="font-size:20px;">
                    <?php
                      if($found)
                      {
                        echo 'Registered';
                      }
                      else
                      {
                        echo 'Not Registered';
                      }
                    ?>
                  </p>
                </div>
              </div>
          </div>
      </div>
      
      <!--- Vertical Spacing --->
      <div class="page-vert-space">
      </div>
      
      <!--
        === PAGE BUTTONS ===
      -->
      <div class="row">
        <!--- Horizontal Spacer --->
        <div class="col-xs-3">
        </div>
          
        <!--- Button Group: Upgrade --->
        <div class="col-xs-4">
	  <?php //*** Label For Button Group *** ?>
	  <div class="label label-default">
	    Upgrade Options
	  </div>
	  <div class="btn-group-vertical">
	    <?php
	    //*** Generate Upgrade Buttons ***
	    //*******************************?>
	    <?php
	    /* *** Outputed Button UI ***
	     *  ~~~ KEY ~~~
	     *  #RT ~ Remaining amount of ticket type
	     *
	     *  ===========
	     *
	     *  _________________________________
	     * /  Highest Upgrade Option "(#RT)" \  <==== css class: btn btn-primary
	     * |---------------------------------|
	     * | ... Lower Options "(#RT)"       |  <=|
	     * |---------------------------------|
	     * | ... ... "(#RT)"                 |  <=/
	     * |---------------------------------|
	     * | "Current Ticket: [type]"        |  <==== css class: btn btn-default disabled
	     * \_________________________________/
	     *
	     * Note:
	     * Only posiable upgrades for a visitor is shown or disabled (excluding visitors current ticket type). 
	     */
	    ?>
	    <?php foreach /* thing in */ ($TicketTypeCountQuery AS $TicketType) : ?>
	      <?php
		//*** Remember Values Of Ticket Type ***
		$TicketTypeID = $TicketType[0];
		$TicketTypeName = $TicketType[1];
		$TicketTypePrice = $TicketType[2];
		$TicketTypeAmount = $TicketType[3];
	      ?>

	      <?php //*** If Valid Option: Add Button Into HTML *** ?>
	      <?php if($TicketOfVisitorPrice < $TicketTypePrice): ?>
		<form action ="<?php if(!found){ echo /*Action URL: */ '<!-- URL HERE -->'; }else{ /*Exclude form link*/ } ?>"
		      method="post">
		  <input type="submit"
			 class="btn btn-primary <?php if($TicketTypeAmount == 0){ echo 'disabled'; } ?>"
			 value="<?php echo $TicketTypeName.' ('.$TicketTypeAmount.')' ?>">
		  <input type="hidden"
			 name="action"
			 value="registerPerson">
		  <input type="hidden"
			 name="ticketTypeID"
			 value="<?php echo $TicketTypeID ?>">
		</form>
	      <?php elseif ($TicketOfVisitorPrice == $TicketTypePrice): ?>
	      <?php //*** Add Unclickable Button With Visitor's Current Ticket Type *** ?>
		<div class="btn btn-default disabled">
		  <?php echo 'Current Ticket: '.$TicketTypeName; ?>
		</div>
	      <?php endif; ?>
	    <?php endforeach; ?>
	  </div>
	</div>
        
        <!--- Horizontal Spacer --->
        <div class="">
        </div>
         
        <!--- Button: Register --->  
        <div class="col-xs-4">
            <form action="
                  <?php
                    if(!$found)
                    {
                      echo '<!-- URL HERE -->';
                    }
                    else
                    {
                      /* Exclude form link */
                    }
                  ?>"
                  method="post">
                 <input class="
                        btn btn-primary
                        <?php
                          if ( !$found ) 
                          { 
                            /* Keep button enabled */
                          }
                          else
                          {
                            /* Disable button */
                            echo 'disabled';
                          }
                        ?>"
                        type="submit"
                        value="Register">
                <input name="action"
                       type="hidden"
                       value="registerPerson">
            </form>
        </div>
          
        <!--- Horizontal Spacer --->
        <div class="col-xs-1">
        </div>
      </div>
    
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
            <button class="btn btn-default">
                <a href="../view/findPerson.php">
                    <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Go Back
              </a>
            </button>
	    </div>
	  </div>
      <!--- Bottom Padding --->
      <div class="page-bottom-padding"> 
      </div>
        
      <!-- end of bootstrap container -->
    </div>
    <script src="../../dist/my-com.js" type="text/javascript"></script>
  </body>
</html>
