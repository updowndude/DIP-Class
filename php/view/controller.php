<?php
  //--- REQUIRES AND INCLUDES ---
  //require( some database php );

  //--- RETRIEVE VARIABLES ---
  $action = filter_input("INPUT_POST", FILTER_SANITIZE_STRING);

  //--- CONTROLLER ---
  switch($action)
  {
      case 'upgradePerson':
          //Your Code Here
          break;
      case 'registerPerson':
          //Your Code Here
          break;
  }
?>