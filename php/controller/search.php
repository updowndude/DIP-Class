<?php
session_start();

function actions() {
  require '../model/db.php';

  $action = $_POST['action'];

  if ($action == 'search') {
      $phone = $_POST['phone-number'];
      $fName = $_POST['first-name'];
      $lName = $_POST['last-name'];
      $address = $_POST['address'];
      $query = 'SELECT *
       from Visitors
       where ((FName = :fname) && (LName = :lname) && (PhoneNumber = :phone) && (Address = :address))
       LIMIT 1';
      $statement = $db->prepare($query);
      if (!$statement) {
        exit("Sorry prepare failed");
      }
      $bind_results = $statement->bindValue(':fname', $fName);
      if(!$bind_results) {
        exit("Sorry can't bind those value");
      }
      $bind_results = $statement->bindValue(':lname', $lName);
      if(!$bind_results) {
        exit("Sorry can't bind those value");
      }
      $bind_results = $statement->bindValue(':address', $address);
      if(!$bind_results) {
        exit("Sorry can't bind those value");
      }
      $bind_results = $statement->bindValue(':phone', $phone);
      if(!$bind_results) {
        exit("Sorry can't bind those value");
      }
      $workQuery = $statement->execute();
      if(!$workQuery) {
        exit("Bad execcution");
      }
      $newFeedback = $statement -> fetch();
      $statement->closeCursor();

      if ($newFeedback == 0) {
        $_SESSION['found'] = "Sorry didn't find";
      } else {
        $_SESSION['found'] = $newFeedback;
      }
      header('Location: ../view/HandleVisiter.php');
  } else {
    header('Location: ../view/404.php');
  }
}

actions();
 ?>
