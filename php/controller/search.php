<?php
session_start();
// copyright 2017 DipFestival, LLC

function main() {
    // get the defense file
    require('defense.php');
    // does to see the connection is secure
    if(($_SERVER['REQUEST_METHOD'] === 'POST') && (checkToken() == true) && (checkDomain() == true)) {
        // sets sesssion values for that connection
        $_SESSION['IPAddress'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['BrowserData'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['loginValid'] = true;
        $_SESSION['loginTime'] = date('Y-m-d H:i:s');
        // handles the values sumbit
        actions();
    } else {
        // bad connection
        exit('Something happened');
    }
}

function actions() {
    // get database file
    require '../model/db.php';

    // only accepted values
    $aryMyValues = allowedValues([
       'FName','LName','DOB','Address','City','StateProvince','Country','VisitorID','PhoneNumber','PostalCode','Email','action', 'choosePerson','comment'
    ]);

    // gets the value to perform what needs to be done
    $action = $aryMyValues['action'];

  // looking up a person
  if ($action == 'search') {
      // generates a query based on all the fields entered
      $sqlValues = findPersonHelper();

      // check if there a value
      if (count($sqlValues) == 0) {
        $_SESSION['found'] = 0;
      } else {
        // outpout value
        $_SESSION['found'] = 1;
      }

      // set all of session to what was entered
      $_SESSION['PhoneNumber'] = $aryMyValues["PhoneNumber"];
      $_SESSION['FName'] = $aryMyValues["FName"];
      $_SESSION['LName'] = $aryMyValues["LName"];
      $_SESSION['Address'] = $aryMyValues["Address"];
      $_SESSION['Email'] = $aryMyValues["Email"];
      $_SESSION['VisitorID'] = $aryMyValues["VisitorID"];
      $_SESSION['City'] = $aryMyValues["City"];
      $_SESSION['StateProvince'] = $aryMyValues["StateProvince"];
      $_SESSION['Country'] = $aryMyValues["Country"];
      $_SESSION['PostalCode'] = $aryMyValues["PostalCode"];
      $_SESSION['DOB'] = $aryMyValues["DOB"];
      $_SESSION['Comments'] = $aryMyValues["comment"];
      $_SESSION['sqlValuesForMutiPeople'] = $sqlValues;
      $_SESSION['sqlValues'] = $sqlValues;

      // goes to next page
      header('Location: ../../visitor');
      // looking up a person
  } elseif ($action == 'searchByPhone') {

      $sqlValues = findPersonHelper();

      // check to see if there a value
      if (count($sqlValues) != 0) {
          // check to see if there more than person
          if(count($sqlValues) >= 2) {
              $_SESSION['sqlValuesForMutiPeople'] = $sqlValues;
          }

          // sets the session varible to value from the query
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
          $_SESSION['Comments'] = "";
          $_SESSION['DOB'] = "";
      }

      // return to the page
      header('Location: ../../lookup');
      // stop php from running
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

      header('Location: ../../lookup');
      exit();
      // update to a comment
  } elseif ($action == 'commentsUpdate') {
      // update the comment field in database
      handSQL("update Visitors
                              set Comments = :Comment
                              where VisitorID = :ID", [":Comment",":ID"], [$aryMyValues["comment"], $aryMyValues["VisitorID"]], 2);
      // gets the new value in the database
      $sqlValues = handSQL("SELECT *
                              FROM Visitors
                              where VisitorID = :ID", [":ID"], [$aryMyValues["VisitorID"]], 0);

      // set that value
      $_SESSION['Comments'] = $sqlValues['Comments'];

      header('Location: ../../lookup');
  }
  else {
     // not a valued action
    header('Location: ../../404');
  }
}

function findPersonHelper() {
    // gets own values form posted values
    $aryMyValues = allowedValues([
        'FName','LName','DOB','Address','City','StateProvince','Country','VisitorID','PhoneNumber','PostalCode','Email','action'
    ]);

    // values accept to be input into the query
    // makes emptry array at fixed size
    $aryBlnHasValue = new SplFixedArray(sizeof($aryMyValues));
    // handles value to passed into query function
    $aryHandSQLValues = [];
    // handles keys to passed into query function
    $aryHandSQLKeys = [];
    // gets the value from values
    $aryPostValues =  array_values($aryMyValues);
    // get the key from values
    $aryKeys = array_keys($aryMyValues);
    // starts making the query
    $strWhere = "SELECT *
       from Visitors
       where (";
    // only changes once
    $blnOnce = false;
    // current place for keys and values
    $curPlaceForArys = 0;

    // loops though the values
    for ($lcv =0;$lcv<sizeof($aryMyValues);$lcv++) {
        // makes sure there a value and is't not hte action value
        if((strlen($aryPostValues[$lcv]) == 0) || ($aryKeys[$lcv] == "action")) {
            $aryBlnHasValue[$lcv] = false;
        } else {
            $aryBlnHasValue[$lcv] = true;
        }
    }

    // loops through values
    for ($lcv2 =0;$lcv2<sizeof($aryMyValues);$lcv2++) {
        // check to see that value needs to be entered
        if($aryBlnHasValue[$lcv2] == true) {
            // first time in the loop
            if($blnOnce == false){
                // change  the value
                $blnOnce = true;
                // adds current values in the loop to query
                $strWhere .= "({$aryKeys[$lcv2]} = :{$aryKeys[$lcv2]})";
                // adds those to values and keys arrays
                $aryHandSQLKeys[$curPlaceForArys] = ":{$aryKeys[$lcv2]}";
                $aryHandSQLValues[$curPlaceForArys] = $aryPostValues[$lcv2];
            } else {
                // adds values to the where clause of the query
                $strWhere .= " && ({$aryKeys[$lcv2]} like :{$aryKeys[$lcv2]})";
                $aryHandSQLKeys[$curPlaceForArys] = ":{$aryKeys[$lcv2]}";
                $aryHandSQLValues[$curPlaceForArys] = $aryPostValues[$lcv2];
            }
            // addds one to the current place varible
            $curPlaceForArys++;
        }
    }

    // ends the query
    $strWhere .= ")";
    // get back the query based on values enterd
    return handSQL($strWhere, $aryHandSQLKeys, $aryHandSQLValues, 1);
}

/*TODO:
 *Eliminate parts where ticket date purchesed overwrites the 'Comments' part of
 *the data entry. (Lines 27 & 101 [4/ 13/ 2017])
 *
 *In there place (or near it) insert the data the ticket was bought (SQL FUNCTION: NOW() )
 *into the table 'Oders'. DatePurchesed.
 *
 *and in the same table switch 'Paid' to TRUE
 */

/*Target:
 * Just send the content of the below function to the textbox when entered form information
 * is meant to be reposted on a web page refresh OR where you need that comment information
 */

function getCommentsAndDatePurchesed()
{
    $sendToCommentsField = handSql
    ('SELECT Visitors.Comments, Orders.DatePurchesed
		  FROM Visitors INNER JOIN Orders
			ON Visitors.VisitorID = Orders.VisitorID
		  WHERE Visitors.VisitorID = :visitorID

		 '
        , [ $_SESSION['VisitorID'] ]
        , [ ':visitorID' ]
        , 0
    );

    return
        '[ Ticket Bought On: '.$sendToCommentsField['DatePurchesed'].' ]<br>'
        .$sendToCommentsField['Comments'];

    // IF ABOVE DOESN'T WORK:
    //    *return
    // 	'[ Ticket Bought On: '.$sendToCommentsField[1 /* should be index of 'DatePurchesed' */ ].' ]<br>'
    //	.$sendToCommentsField[0 /* should be index of 'Comments' */];
}

// calls the main method
main();
 ?>
