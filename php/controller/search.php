<?php
session_start();

function actions() {
    require_once '../model/db.php';

    $action = $_POST['action'];

  if ($action == 'search') {
      $phone = $_POST['phone-number'];
      $fName = $_POST['first-name'];
      $lName = $_POST['last-name'];
      $address = $_POST['address'];
      $email = $_POST['email'];

      if((strlen($address) != 0) && (strlen($phone) == 0)) {
          $sqlVaues = handSQL('SELECT *
       from Visitors
       where ((FName = :fname) && (LName = :lname) && (Address = :adress))
       LIMIT 1', [':fname', ':lname', ':adress'], [$fName, $lName, $address], 0);
      } elseif ((strlen($address) != 0) && (strlen($phone) == 0)) {
          $sqlVaues = handSQL('SELECT *
       from Visitors
       where ((FName = :fname) && (LName = :lname) && (PhoneNumber = :phoneNumber))
       LIMIT 1', [':fname', ':lname', ':phoneNumber'], [$fName, $lName, $phone], 0);
      } elseif ((strlen($address) != 0) && (strlen($phone) != 0)) {
          $sqlVaues = handSQL('SELECT *
       from Visitors
       where ((FName = :fname) && (LName = :lname) && (PhoneNumber = :phoneNumber) && (Address = :adress))
       LIMIT 1', [':fname', ':lname', ':phoneNumber',':adress'], [$fName, $lName, $phone, $address], 0);
      } elseif ((strlen($phone) != 0) && (strlen($fName) == 0) && (strlen($lName) == 0) && (strlen($address) == 0) && (strlen($email) == 0)) {
          $sqlVaues = handSQL('SELECT *
       from Visitors
       where PhoneNumber = :phoneNumber
       LIMIT 1', [':phoneNumber'], [$phone], 0);

          $phone = $sqlVaues['PhoneNumber'];
          $fName = $sqlVaues['FName'];
          $lName = $sqlVaues['LName'];
          $address = $sqlVaues['Address'];
          $email = $sqlVaues['Email'];

          require('../view/findPerson.php');
          exit();
      } else {
          $sqlVaues = handSQL('SELECT *
       from Visitors
       where ((FName = :fname) && (LName = :lname))
       LIMIT 1', [':fname', ':lname'], [$fName, $lName], 0);
      }

      if ($sqlVaues == 0) {
        $_SESSION['found'] = false;
      } else {
        $_SESSION['found'] = $sqlVaues;
      }
      require('../view/HandleVisiter.php');
  } else {
    header('Location: ../view/404.php');
  }
}

actions();
 ?>
