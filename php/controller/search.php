<?php
session_start();

function main() {
    require('defense.php');
    if(($_SERVER['REQUEST_METHOD'] === 'POST') && (checkToken() == true) && (checkDomain() == true)) {
        $_SESSION['IPAddress'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['BrowserData'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['loginValid'] = true;
        $_SESSION['loginTime'] = date('Y-m-d H:i:s');
        actions();
    } else {
        exit('Something happened');
    }
}

function actions() {
    require '../model/db.php';

    $aryMyValues = allowedValues([
       'FName','LName','DOB','Address','City','StateProvince','Country','VisitorID','PhoneNumber','PostalCode','Email','action', 'choosePerson','comment'
    ]);

    $action = $aryMyValues['action'];

  if ($action == 'search') {
      $sqlValues = findPersonHelper();

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
      $_SESSION['VisitorID'] = "";
      $_SESSION['City'] = "";
      $_SESSION['StateProvince'] = "";
      $_SESSION['Country'] = "";
      $_SESSION['PostalCode'] = "";
      $_SESSION['DOB'] = "";
      $_SESSION['sqlValuesForMutiPeople'] = [];

      header('Location: ../view/visitor');
  } elseif ($action == 'searchByPhone') {

      $sqlValues = findPersonHelper();

      if (count($sqlValues) != 0) {
          if(count($sqlValues) >= 2) {
              $_SESSION['sqlValuesForMutiPeople'] = $sqlValues;
          }

          $_SESSION['PhoneNumber'] = $sqlValues[0]['PhoneNumber'];
          $_SESSION['FName'] = $sqlValues[0]['FName'];
          $_SESSION['LName'] = $sqlValues[0]['LName'];
          $_SESSION['Address'] = $sqlValues[0]['Address'];
          $_SESSION['Email'] = $sqlValues[0]['Email'];
          $_SESSION['VisitorID'] = $sqlValues[0]['VisitorID'];
          $_SESSION['City'] = $sqlValues[0]['City'];
          $_SESSION['StateProvince'] = $sqlValues[0]['StateProvince'];
          $_SESSION['Country'] = $sqlValues[0]['Country'];
          $_SESSION['PostalCode'] = $sqlValues[0]['PostalCode'];
          $_SESSION['DOB'] = $sqlValues[0]['DOB'];
          $_SESSION['Comments'] = $sqlValues[0]['Comments'];
      } else {
          $_SESSION['PhoneNumber'] = "";
          $_SESSION['FName'] = "";
          $_SESSION['LName'] = "";
          $_SESSION['Address'] = "";
          $_SESSION['Email'] = "";
          $_SESSION['VisitorID'] = "";
          $_SESSION['City'] = "";
          $_SESSION['StateProvince'] = "";
          $_SESSION['Country'] = "";
          $_SESSION['PostalCode'] = "";
          $_SESSION['DOB'] = "";
      }

      header('Location: ../view/lookup');
      exit();
  }  elseif ($action == 'choosePerson'){
      $sqlValues = handSQL("SELECT *
                              FROM Visitors
                              where VisitorID = :ID", [":ID"], [$aryMyValues["choosePerson"]], 0);

      $_SESSION['PhoneNumber'] = $sqlValues['PhoneNumber'];
      $_SESSION['FName'] = $sqlValues['FName'];
      $_SESSION['LName'] = $sqlValues['LName'];
      $_SESSION['Address'] = $sqlValues['Address'];
      $_SESSION['Email'] = $sqlValues['Email'];
      $_SESSION['VisitorID'] = $sqlValues['VisitorID'];
      $_SESSION['City'] = $sqlValues['City'];
      $_SESSION['StateProvince'] = $sqlValues['StateProvince'];
      $_SESSION['Country'] = $sqlValues['Country'];
      $_SESSION['PostalCode'] = $sqlValues['PostalCode'];
      $_SESSION['DOB'] = $sqlValues['DOB'];
      $_SESSION['Comments'] = $sqlValues['Comments'];

      header('Location: ../view/lookup');
      exit();
  } elseif ($action == 'commentsUpdate') {
      $sqlValues = handSQL("update Visitors
                              set Comments = :Comment
                              where VisitorID = :ID", [":Comment",":ID"], [$aryMyValues["comment"], $aryMyValues["VisitorID"]], 2);
      $sqlValues = handSQL("SELECT *
                              FROM Visitors
                              where VisitorID = :ID", [":ID"], [$aryMyValues["VisitorID"]], 0);

      $_SESSION['Comments'] = $sqlValues['Comments'];

      header('Location: ../view/lookup');
  }
  else {
    header('Location: ../view/404');
  }
}

function findPersonHelper() {
    $aryMyValues = allowedValues([
        'FName','LName','DOB','Address','City','StateProvince','Country','VisitorID','PhoneNumber','PostalCode','Email','action'
    ]);

    $aryBlnHasValue = new SplFixedArray(sizeof($aryMyValues));
    $aryHandSQLValues = [];
    $aryHandSQLKeys = [];
    $aryPostValues =  array_values($aryMyValues);
    $aryKeys = array_keys($aryMyValues);
    $strWhere = "SELECT *
       from Visitors
       where (";
    $blnOnce = false;
    $curPlaceForArys = 0;

    for ($lcv =0;$lcv<sizeof($aryMyValues);$lcv++) {
        if((strlen($aryPostValues[$lcv]) == 0) || ($aryKeys[$lcv] == "action")) {
            $aryBlnHasValue[$lcv] = false;
        } else {
            $aryBlnHasValue[$lcv] = true;
        }
    }

    for ($lcv2 =0;$lcv2<sizeof($aryMyValues);$lcv2++) {
        if($aryBlnHasValue[$lcv2] == true) {
            if($blnOnce == false){
                $blnOnce = true;
                $strWhere .= "({$aryKeys[$lcv2]} = :{$aryKeys[$lcv2]})";
                $aryHandSQLKeys[$curPlaceForArys] = ":{$aryKeys[$lcv2]}";
                $aryHandSQLValues[$curPlaceForArys] = $aryPostValues[$lcv2];
            } else {
                $strWhere .= " && ({$aryKeys[$lcv2]} like :{$aryKeys[$lcv2]})";
                $aryHandSQLKeys[$curPlaceForArys] = ":{$aryKeys[$lcv2]}";
                $aryHandSQLValues[$curPlaceForArys] = $aryPostValues[$lcv2];
            }
            $curPlaceForArys++;
        }
    }

    $strWhere .= ")";
    return handSQL($strWhere, $aryHandSQLKeys, $aryHandSQLValues, 1);
}

main();
 ?>
