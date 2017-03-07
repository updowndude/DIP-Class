<?php if (!isset($_SESSION)){ session_start(); } ?>
<?php
  //--- REQUIRES AND INCLUDES ---
    require '../model/db.php';

  //--- RETRIEVE VARIABLES ---
  $action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_STRING);

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
          $ticketTypeID = $_POST['ticketTypeID'];
          $pdoObj = getAccess();
          $query =
            '
            INSERT INTO
            Visitors
            (fName, lName, phone, address)
            VALUES
            (:fName, :lName, :phone, :address);
            
            INSERT INTO
            TicketAssignment
            (VisitorID, TicketTypeID)
            VALUES
            ((SELECT VisitorID 
              FROM Visitors 
              WHERE fName = :fName
                AND lName = :lName 
                AND phone = :phone 
                AND address = :address)
             , :ticketTypeID);
             ';
          $statement = $pdoObj->prepare($query);
          $statement->bindValue(':fName', $_SESSION['sqlValues']['FName']);
          $statement->bindValue(':lName', $_SESSION['sqlValues']['LName']);
          $statement->bindValue(':phone', $_SESSION['sqlValues']['Phone']);
          $statement->bindValue(':address', $_SESSION['sqlValues']['Address']);
          $statement->bindValue(':ticketTypeID', $ticketTypeID);
          $statement->execute();
          $statement->closeCursor();
          include 'php/view/findperson.php';
          break;
  }
?>
