<?php
  // by Correy Winke
  // 10/27/16
  // opens up a database
  $dsn = 'mysql:host=localhost;dbname=Festival_DB';
  $username = 'root';
  $password = 'root';
  // check to se it works
  try {
      $db = new PDO($dsn, $username, $password);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $err) {
    exit($err->getMessage());
  }

?>
