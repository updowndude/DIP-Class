<?php if (!isset($_SESSION)){ session_start(); } ?>
<?php
// copyright 2017 DipFestival, LLC
  //--- REQUIRES AND INCLUDES ---
    require_once '../model/db.php';

  //--- RETRIEVE VARIABLES ---
  $action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_STRING);

  //--- CONTROLLER ---
  switch($action)
  {
      /*SUMMARY:
       *Does only everything required to update a visitors selected assigned ticket
       */
      case 'upgradePerson':
          //ID of ticket that the selected visitor ticket will be converted (upgraded) to
          $upgradeTicketTypeID = $_POST['selected-ticket-type-option'];
          //ID of ticket that will be updated
          $selectedVisitorTicketOption = $_POST['selected-visitor-ticket-option'];
          //ID of visitor
          $visitorID = $_SESSION['VisitorID'];
          $pdoObj = getAccess();
          $query =
            '
            UPDATE
                TicketAssignment
                    INNER JOIN
                Merchandise ON TicketAssignment.MerchID = Merchandise.MerchID
                    INNER JOIN	
                Visitors ON Visitors.VisitorID = TicketAssignment.VisitorID
                    INNER JOIN
                Orders ON Orders.VisitorID = Visitors.VisitorID
            SET
                TicketAssignment.MerchID = :merchID
                , TicketAssignment.DatePurchased = NOW()
                , Orders.DatePurchased = NOW()
                
                -- ???below needed???
                -- YES: as fail safe should buisness rules change
                , Orders.Paid = TRUE
            WHERE
                TicketAssignment.VisitorID = :visitorID AND
                TicketAssignment.TicketID = :selectedVisitorTicketOption
            ';
          $statement = $pdoObj->prepare($query);
          $statement->bindValue(':merchID',$upgradeTicketTypeID);
          $statement->bindValue(':visitorID',$visitorID);
          $statement->bindValue(':visitorTicketOption', $selectedVisitorTicketOption);
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
    
      /*SUMMARY:
       *Does only everything thats required to regisiter a visitor
       *into the database with a assigned ticket.
       *
       *TODO (regisiter person rules):
       * - A minimum of 1 ticket must be assigned to visitor for attending the Accordian Discordian 
       *   Appocalypse
       *
       * - A visitor may be assigned multiple attendance tickets
       *
       * - Optional: allow visitor to get a parking ticket (for camping, not a fine)
       */
      case 'registerPerson':
          $ticketTypeID = $_POST['selected-ticket-type-option'];
          $pdoObj = getAccess();

          $fullName = $_SESSION['FName'].$_SESSION['LName'];
          handSQL("INSERT INTO Users (Username, Password, AccessLevel)
             VALUES (:Username, '', 1)
          ",[":Username"],[$fullName],2);

          $sqlValues = handSQL("SELECT * FROM Users WHERE Username = :Username
          ",[":Username"],[$fullName],0);

          $secQuery = "INSERT INTO
            TicketAssignment
            (VisitorID, MerchID, DatePurchased)
            VALUES
            ((SELECT VisitorID 
              FROM Visitors  WHERE";
          $thrQuery = "(SELECT VisitorID 
              FROM Visitors  WHERE";
          $arySessionKey = array_keys($_SESSION);
          $intTmp = sizeof($arySessionKey) -1;

          for($lcv = 0;$lcv<sizeof($arySessionKey);$lcv++) {
              if((($arySessionKey[$lcv] == "FName") || ($arySessionKey[$lcv] == "LName") || ($arySessionKey[$lcv] == "DOB") ||
                      ($arySessionKey[$lcv] == "Address") || ($arySessionKey[$lcv] == "City") || ($arySessionKey[$lcv] == "StateProvince") ||
                      ($arySessionKey[$lcv] == "Country") || ($arySessionKey[$lcv] == "PhoneNumber") || ($arySessionKey[$lcv] == "PostalCode") ||
                      ($arySessionKey[$lcv] == "Email") || ($arySessionKey[$lcv] == "Comments")) && (strlen($_SESSION[$arySessionKey[$lcv]]) != 0)) {
                 if($lcv !== $intTmp) {
                     $secQuery .= "({$arySessionKey[$lcv]} = :{$arySessionKey[$lcv]}) AND";
                     $thrQuery .= "({$arySessionKey[$lcv]} = :{$arySessionKey[$lcv]}) AND";
                 }
              }
          }

          $secQuery = substr($secQuery, 0, strlen($secQuery) - 3);
          $thrQuery = substr($thrQuery, 0, strlen($thrQuery) - 3);

          $secQuery .= ")
             , :merchID
             , NOW());";
          $thrQuery .= ");";
          $query =
            "
            INSERT INTO
            Visitors
            (UserID,FName, LName, DOB, Address, City, StateProvince, Country, PhoneNumber, PostalCode, Email)
            VALUES
            (:UserID,:FName, :LName, :DOB, :Address, :City, :StateProvince, :Country, :PhoneNumber, :PostalCode, :Email);
            
            {$secQuery}
             ";

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
          $statement->bindValue(':merchID', $ticketTypeID);
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
