<?php
  //--- REQUIRES AND INCLUDES ---
  //require( some database php );

  //--- RETRIEVE VARIABLES ---
  $action = filter_input("INPUT_POST", "action", FILTER_SANITIZE_STRING);

  //--- CONTROLLER ---
  switch($action)
  {
      case 'upgradePerson':
          $upgradeTicketTypeID = $_POST["ticketTypeID"];
          $visitorID = $_SESSION["sqlValues"]["VisitorID"];
          $pdoObj = getAccess();
          $query =
            '
            UPDATE
              (Visitors INNER JOIN TicketAssignment ON Visitors.VisitorID = TicketAssignment.VisitorID)
              INNER JOIN TicketTypes ON TicketAssignment.TicketTypeID = TicketTypes.TicketTypeID
            SET
              TicketAssignment.TicketTypeID = :ticketTypeID
            WHERE
              VisitorID = :visitorID
            ';
          $statement = $pdoObj->prepare($query);
          $statement->bindValue(':ticketTypeID',$upgradeTicketTypeID);
          $statement->bindValue(':visitorID','$visitorID');
          $statement->execute();
          $statement->closeCursor();
      
          include 'php/view/findperson.php';
          break;
      case 'registerPerson':
          //Your Code Here
          
          include 'php/view/findperson.php';
          break;
  }
?>
