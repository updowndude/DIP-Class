<html>
   <head>
      <title>Main Gate</title>
      <meta content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" type="text/css" href="../../dist/myStyle.css" />
       <link rel="icon" type="image/x-icon" href="../../images/favicon.ico">
   </head>
   <body id="findPerson">
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
                        if(isset($phone)) {
                            echo $phone;
                        }
                     ?>" placeholder="Phone Number" name="phone-number">
                  </div>
                  <div class="form-group">
                     <label>First Name</label>
                     <input class="form-control" value="<?php
                     if(isset($fName)) {
                         echo $fName;
                     }
                     ?>" type="text" placeholder="First Name" name="first-name">
                  </div>
                  <div class="form-group">
                     <label>Last Name</label>
                     <input class="form-control" value="<?php
                     if(isset($lName)) {
                         echo $lName;
                     }
                     ?>" type="text" placeholder="Last Name" name="last-name">
                  </div>
                  <div class="form-group">
                     <label>Address</label>
                     <input class="form-control" value="<?php
                     if(isset($address)) {
                         echo $address;
                     }
                     ?>" type="text" placeholder="Anddress" name="address">
                  </div>
                   <div class="form-group">
                       <label>Email</label>
                       <input class="form-control" value="<?php
                       if(isset($email)) {
                           echo $email;
                       }
                       ?>" type="text" placeholder="Email" name="email">
                   </div>
                   <div class="btn-group" role="group">
                       <button type="submit" class="btn btn-default" name="ff" id="findPerson">Find person</button>
                       <button type="submit" class="btn btn-default" name="jkl">Search by phone number</button>
                   </div>
                  </div>
                  <input type="hidden" type="text" name="action" value="search">
               </form>
            </div>
         </div>
      <script src="../../dist/my-com.js" type="text/javascript"></script>
   </body>
</html>
