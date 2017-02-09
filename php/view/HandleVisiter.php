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
<!--
====== PLACEHOLDER PHP ======
-->
<?php
$found = false;
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
      <!--jQuery-->
      <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

      <!--Bootstrap JS-->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<!--- CSS --->
	<!--
	  Placeholder
	-->
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
          
        <!--- Button: Upgrade --->
		<div class="col-xs-4">
		    <form action="
                  <?php
                    if($found)
                    {
                      echo '<!-- URL HERE -->';
                    }
                    else
                    {
                      /* Exclude form link */
                    }?>" 
                  method="post">
			  <input class="
                  btn btn-primary
				  <?php
				    if( $found )
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
			      value="Upgrade">
			  <input name="action"
			      type="hidden"
				  value="upgradePerson">
			</form>
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
		  <div class="btn btn-default"
		       onclick="window.history.back()">
            <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Go Back
          </div>
	    </div>
	  </div>
	
      <!--- Bottom Padding --->
	  <div class="page-bottom-padding"> 
	  </div>
        
      <!-- end of bootstrap container -->
    </div>
  </body>
</html>