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
          $ticketTypeID = $_POST['ticketTypeID'];
          $pdoObj = getAccess();
          $query =
            '
            INSERT INTO
            Visitors
            (FName, LName, PhoneNumber, Address, Email)
            VALUES
            (:fName, :lName, :phone, :address, :email);
            
            INSERT INTO
            TicketAssignment
            (VisitorID, TicketTypeID)
            VALUES
            ((SELECT VisitorID 
              FROM Visitors 
              WHERE FName = :fName
                AND LName = :lName 
                AND PhoneNumber = :phone 
                AND Address = :address
                AND Email = :email)
             , :ticketTypeID);
             ';
          $statement = $pdoObj->prepare($query);
          $statement->bindValue(':fName', $_SESSION['sqlValues']['FName']);
          $statement->bindValue(':lName', $_SESSION['sqlValues']['LName']);
          $statement->bindValue(':phone', $_SESSION['sqlValues']['PhoneNumber']);
          $statement->bindValue(':address', $_SESSION['sqlValues']['Address']);
          $statement->bindValue(':email', $_SESSION['sqlValues']['Email']);
          $statement->bindValue(':ticketTypeID', $ticketTypeID);
          $statement->execute();
          $statement->closeCursor();
          include 'php/view/findperson.php';
          break;
  }
?>
