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
