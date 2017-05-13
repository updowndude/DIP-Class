<?php if (!isset($_SESSION)){ session_start(); } ?>
<?php
// copyright 2017 DipFestival, LLC
  //--- REQUIRES AND INCLUDES ---
    require_once '../model/db.php';
    require_once '../includes/controller_upgrade_functions.php';

  //--- RETRIEVE VARIABLES ---
  $action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_STRING);

  //--- CONTROLLER ---
  switch($action)
  {
      /*SUMMARY:
       *Does only everything required to update a visitors selected assigned ticket
       */
      case 'upgradePerson':
          /*SEE:
           * ../php/includes/controller_upgrade_functions.php
           */
          runAllUpgradeRequests();

          $_SESSION['PhoneNumber'] = "";
          $_SESSION['FName'] = "";
          $_SESSION['LName'] = "";
          $_SESSION['Address'] = "";
          $_SESSION['Email'] = "";
          $_SESSION['VisitorID'] = "";
          $_SESSION['City'] = "";
          $_SESSION['StateProvince'] = "";
          $_SESSION['Country'] = "";
          $_SESSION['PostalCode'] = "";
          $_SESSION['DOB'] = "";
          $_SESSION['Comments'] = "";
          $_SESSION['sqlValuesForMutiPeople'] = [];

          header('Location: ../../lookup');
          break;
    
      /*SUMMARY:
       *Does only everything thats required to regisiter a visitor
       *into the database with a assigned ticket.
       */
      case 'registerPerson':
          //$ticketTypeID = $_POST['selected-ticket-type-option'];
          $selectedAdmissionTickets = $_POST['selected-day-admission-ticket-option'];
          $selectedParkingTickets = $_POST['selected-day-parking-ticket-option'];
          $selectedCampingTickets = $_POST['selected-day-camping-ticket-option'];
          $allSelectedTickets = array_merge
              ( (is_array($selectedAdmissionTickets)?$selectedAdmissionTickets:array())
              , (is_array($selectedParkingTickets)?$selectedParkingTickets:array())
              , (is_array($selectedCampingTickets)?$selectedCampingTickets:array())
              );
          $numberOfSelectedTickets
              = sizeof($allSelectedTickets);
          $pdoObj = getAccess();
          
          /*echo var_dump($selectedAdmissionTickets).'<br>';
          echo var_dump($selectedParkingTickets).'<br>';
          echo var_dump($selectedCampingTickets).'<br>';
         exit();*/

          //*** Get Value for $fullName ***
          //*******************************
          $fullName = $_SESSION['FName'].$_SESSION['LName'];
          handSQL("INSERT INTO Users (Username, Password, AccessLevel)
             VALUES (:Username, '', 1)
          ",[":Username"],[$fullName],2);

          //*** Get Value for $sqlValues ***
          //********************************
          $sqlValues = handSQL("SELECT * FROM Users WHERE Username = :Username
          ",[":Username"],[$fullName],0);

          /*SUMMARY:
           * Inserts visitor and his/ her purchased tickets into the database
           */
          //*** Make & Run Last Query ***
          //*****************************
          $query =
            "
            INSERT INTO
            Visitors
            (UserID,FName, LName, DOB, Address, City, StateProvince, Country, PhoneNumber, PostalCode, Email)
            VALUES
            (:UserID,:FName, :LName, :DOB, :Address, :City, :StateProvince, :Country, :PhoneNumber, :PostalCode, :Email);";
              
          //for each selected ticket...
          for($i = 0; $i < $numberOfSelectedTickets; $i++){
              $secQuery = "INSERT INTO
                TicketAssignment
                (VisitorID, MerchID, DatePurchased)
                VALUES
                ((SELECT VisitorID 
                  FROM Visitors WHERE ";
              $arySessionKey = array_keys($_SESSION);
              $intTmp = sizeof($arySessionKey) -1;

              //for each allowed element in $_SESSION, append condition part to MySQL WHERE clause...
              for($lcv = 0;$lcv<sizeof($arySessionKey);$lcv++) {
                  if((($arySessionKey[$lcv] == "FName") || ($arySessionKey[$lcv] == "LName") || ($arySessionKey[$lcv] == "DOB") ||
                          ($arySessionKey[$lcv] == "Address") || ($arySessionKey[$lcv] == "City") || ($arySessionKey[$lcv] == "StateProvince") ||
                          ($arySessionKey[$lcv] == "Country") || ($arySessionKey[$lcv] == "PhoneNumber") || ($arySessionKey[$lcv] == "PostalCode") ||
                          ($arySessionKey[$lcv] == "Email") || ($arySessionKey[$lcv] == "Comments")) && (strlen($_SESSION[$arySessionKey[$lcv]]) != 0)) {
                     if($lcv !== $intTmp) {
                         $secQuery .= "({$arySessionKey[$lcv]} = :{$arySessionKey[$lcv]}) AND";
                     }
                  }
              }

              //eliminates the last "AND". with out this an error can happen
              $secQuery = substr($secQuery, 0, strlen($secQuery) - 3);

              //append static query portion
              $secQuery 
                 .= "), "
                 .filter_var($allSelectedTickets[$i], FILTER_SANITIZE_NUMBER_INT)
                 .", NOW());";

              //finish building the MySQL for giving a visitor 1 ticket, and continue building onto $query if
              //there are more tickets to give
              $query .="{$secQuery}";
          }
          echo '<pre>';
          echo $query;
          echo '</pre>';
          //die();
          $statement = $pdoObj->prepare($query);
          $statement->bindValue(':UserID', $sqlValues['UserID']);
          $statement->bindValue(':FName', $_SESSION['FName']);
          $statement->bindValue(':LName', $_SESSION['LName']);
          $statement->bindValue(':DOB', $_SESSION['DOB']);
          $statement->bindValue(':Address', $_SESSION['Address']);
          $statement->bindValue(':City', $_SESSION['City']);
          $statement->bindValue(':StateProvince', $_SESSION['StateProvince']);
          $statement->bindValue(':Country', $_SESSION['Country']);
          $statement->bindValue(':PhoneNumber', $_SESSION['PhoneNumber']);
          $statement->bindValue(':PostalCode', $_SESSION['PostalCode']);
          $statement->bindValue(':Email', $_SESSION['Email']);
          $statement->bindValue(':Comments', $_SESSION['Comments']);
          $statement->execute();
          $statement->closeCursor();

          $_SESSION['PhoneNumber'] = "";
          $_SESSION['FName'] = "";
          $_SESSION['LName'] = "";
          $_SESSION['Address'] = "";
          $_SESSION['Email'] = "";
          $_SESSION['VisitorID'] = "";
          $_SESSION['City'] = "";
          $_SESSION['StateProvince'] = "";
          $_SESSION['Country'] = "";
          $_SESSION['PostalCode'] = "";
          $_SESSION['DOB'] = "";
          $_SESSION['Comments'] = "";
          $_SESSION['sqlValuesForMutiPeople'] = [];

          header('Location: ../../lookup');
          break;
  }
?>
