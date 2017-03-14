<?php if (!isset($_SESSION)){ session_start(); } ?>
<?php
  //--- REQUIRES AND INCLUDES ---
    require_once '../model/db.php';

  //--- RETRIEVE VARIABLES ---
  $action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_STRING);

  //--- CONTROLLER ---
  switch($action)
  {
      case 'upgradePerson':
          $upgradeTicketTypeID = $_POST['selected-ticket-type-option'];
          $visitorID = $_SESSION['VisitorID'];
          $pdoObj = getAccess();
          $query =
            '
            UPDATE
              TicketAssignment INNER JOIN
              TicketTypes
                  ON TicketAssignment.TicketTypeID
                  =  TicketTypes.TicketTypeID
            SET
              TicketAssignment.TicketTypeID = :ticketTypeID
            WHERE
              TicketAssignment.VisitorID = :visitorID
            ';
          $statement = $pdoObj->prepare($query);
          $statement->bindValue(':ticketTypeID',$upgradeTicketTypeID);
          $statement->bindValue(':visitorID','$visitorID');
          $statement->execute();
          $statement->closeCursor();
      
          include '../view/findperson.php';
          break;
      case 'registerPerson':
          $ticketTypeID = $_POST['selected-ticket-type-option'];
          $pdoObj = getAccess();
          $query =
            '
            INSERT INTO
            Visitors
            (FName, LName, DOB, Address, City, StateProvince, Country, PhoneNumber, PostalCode, Email, Comments)
            VALUES
            (:fName, :lName, :dob, :address, :city, :stateProvince, country, :phoneNumber, :postalCode, :email, :comments);
            
            INSERT INTO
            TicketAssignment
            (VisitorID, TicketTypeID, DatePurchased)
            VALUES
            ((SELECT VisitorID 
              FROM Visitors 
              WHERE (FName = :fName OR :fName IS NULL)
                AND (LName = :lName OR :lName IS NULL) 
                AND (DOB = :dob OR :dob IS NULL)
                AND (Address = :address OR :address IS NULL)
                AND (City = :city OR :city IS NULL)
                AND (StateProvince = :stateProvince OR :stateProvince IS NULL)
                AND (Country = :country OR :country IS NULL)
                AND (PhoneNumber = :phoneNumber OR :phoneNumber IS NULL)
                AND (PostalCode = :postalCode OR :postalCode IS NULL)
                AND (Email = :email OR :email IS NULL))
             , :ticketTypeID
             , NOW());
             ';
          $statement = $pdoObj->prepare($query);
          $statement->bindValue(':fName', $_SESSION['FName']);
          $statement->bindValue(':lName', $_SESSION['LName']);
          $statement->bindValue(':dob', $_SESSION['DOB']);
          $statement->bindValue(':address', $_SESSION['Address']);
          $statement->bindValue(':city', $_SESSION['City']);
          $statement->bindValue(':stateProvince', $_SESSION['StateProvince']);
          $statement->bindValue(':country', $_SESSION['Country']);
          $statement->bindValue(':phoneNumber', $_SESSION['PhoneNumber']);
          $statement->bindValue(':postalCode', $_SESSION['PostalCode']);
          $statement->bindValue(':email', $_SESSION['Email']);
          $statement->bindValue(':comments', $_SESSION['Comments']);
          $statement->execute();
          $statement->closeCursor();
          include '../view/findperson.php';
          break;
  }
?>
