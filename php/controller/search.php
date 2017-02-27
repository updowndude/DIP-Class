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

      if ((strlen($fName) != 0) && (strlen($lName) != 0) && (strlen($phone) != 0) && (strlen($address) != 0) && (strlen($email) != 0)) {
          $sqlValues = handSQL('SELECT *
       from Visitors
       where ((FName like :fname) && (LName like :lname) && (PhoneNumber like :phoneNumber) && (Address like :adress) && (Email like :email))
       LIMIT 1', [':fname', ':lname', ':phoneNumber',':adress', ':email'], [$fName, $lName, $phone, $address, $email], 0);
      } elseif ((strlen($fName) != 0) && (strlen($lName) != 0) && (strlen($phone) != 0) && (strlen($address) != 0)) {
          $sqlValues = handSQL('SELECT *
       from Visitors
       where ((FName like :fname) && (LName like :lname) && (PhoneNumber like :phoneNumber) && (Address like :adress))
       LIMIT 1', [':fname', ':lname', ':phoneNumber',':adress'], [$fName, $lName, $phone, $address], 0);
      }if((strlen($fName) != 0) && (strlen($lName) != 0) && (strlen($address) != 0)) {
          $sqlValues = handSQL('SELECT *
       from Visitors
       where ((FName like :fname) && (LName like :lname) && (Address like :address))
       LIMIT 1', [':fname', ':lname', ':address'], [$fName, $lName, $address], 0);
      } elseif ((strlen($fName) != 0) && (strlen($lName) != 0) && (strlen($phone) != 0)) {
          $sqlValues = handSQL('SELECT *
       from Visitors
       where ((FName like :fname) && (LName like :lname) && (PhoneNumber like :phoneNumber))
       LIMIT 1', [':fname', ':lname', ':phoneNumber'], [$fName, $lName, $phone], 0);
      } else {
          $sqlValues = handSQL('SELECT *
       from Visitors
       where ((FName like :fname) && (LName like :lname))
       LIMIT 1', [':fname', ':lname'], [$fName, $lName], 0);
      }

      if ($sqlValues == 0) {
        $_SESSION['found'] = false;
          $_SESSION['sqlValues'] = null;
      } else {
        $_SESSION['found'] = true;
        $_SESSION['sqlValues'] = $sqlValues;
      }

      $_SESSION['PhoneNumber'] = "";
      $_SESSION['FName'] = "";
      $_SESSION['LName'] = "";
      $_SESSION['Address'] = "";
      $_SESSION['Email'] = "";

      header('Location: ../view/visitor');
  } elseif ($action == 'searchByPhone') {
      $phone = $_POST['phone-number'];
      $fName = $_POST['first-name'];
      $lName = $_POST['last-name'];
      $address = $_POST['address'];
      $email = $_POST['email'];

      if ((strlen($phone) != 0) && (strlen($fName) == 0) && (strlen($lName) == 0) && (strlen($address) == 0) && (strlen($email) == 0)) {
          $sqlValues = handSQL('SELECT *
       from Visitors
       where PhoneNumber like :phoneNumber
       LIMIT 1', [':phoneNumber'], [$phone], 0);

          $_SESSION['PhoneNumber'] = $sqlValues['PhoneNumber'];
          $_SESSION['FName'] = $sqlValues['FName'];
          $_SESSION['LName'] = $sqlValues['LName'];
          $_SESSION['Address'] = $sqlValues['Address'];
          $_SESSION['Email'] = $sqlValues['Email'];
      } else {
          $_SESSION['PhoneNumber'] = "";
          $_SESSION['FName'] = "";
          $_SESSION['LName'] = "";
          $_SESSION['Address'] = "";
          $_SESSION['Email'] = "";
      }

      header('Location: ../view/lookup');
      exit();
  } else {
    header('Location: ../view/404.php');
  }
}

actions();
 ?>
