<?php session_start(); ?>
<html>
   <head>
      <title>Main Gate</title>
      <meta content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" type="text/css" href="../../dist/myStyle.css" />
       <link rel="icon" type="image/x-icon" href="../../images/favicon.ico">
   </head>
   <body id="findPersonBody">
      <div class="container">
         <!--main container-->
         <div class="row">
            <div class="col-centered">
               <h1 class="text-center">Visitor Lookup</h1>
               <br>
               <form action="../controller/search.php" method="post" id="searchPerson">
                  <div class="form-group">
                     <label>Phone Number</label>
                     <input class="form-control" type="tel" value="<?php
                        if(isset( $_SESSION['PhoneNumber']) == true) {
                            echo  $_SESSION['PhoneNumber'];
                        }
                     ?>" placeholder="Phone Number" name="phone-number">
                  </div>
                  <div class="form-group">
                     <label>First Name</label>
                     <input class="form-control" value="<?php
                     if(isset($_SESSION['FName']) == true) {
                         echo $_SESSION['FName'];
                     }
                     ?>" type="text" placeholder="First Name" name="first-name">
                  </div>
                  <div class="form-group">
                     <label>Last Name</label>
                     <input class="form-control" value="<?php
                     if(isset( $_SESSION['LName']) == true) {
                         echo  $_SESSION['LName'];
                     }
                     ?>" type="text" placeholder="Last Name" name="last-name">
                  </div>
                  <div class="form-group">
                     <label>Address</label>
                     <input class="form-control" value="<?php
                     if(isset( $_SESSION['Address']) == true) {
                         echo  $_SESSION['Address'];
                     }
                     ?>" type="text" placeholder="Anddress" name="address">
                  </div>
                   <div class="form-group">
                       <label>Email</label>
                       <input class="form-control" value="<?php
                       if(isset( $_SESSION['Email']) == true) {
                           echo  $_SESSION['Email'];
                       }
                       ?>" type="text" placeholder="Email" name="email">
                   </div>
                   <div class="btn-group" role="group">
                       <button type="submit" class="btn btn-default" id="findPerson">Find person</button>
                       <button type="submit" class="btn btn-default" id="searchPhone" disabled="disabled">Search by phone number</button>
                       <button class="btn btn-default" id="btnClear">Clear</button>
                   </div>
                  </div>
                  <input type="hidden" type="text" id="action" name="action" value="search">
               </form>
            </div>
         </div>
      <script type="text/javascript">
          <?php echo file_get_contents("../../dist/my-com.js") ?>
      </script>
   </body>
</html>
