<?php
/**
 * Created by PhpStorm.
 * User: correywinke
 * Date: 3/7/17
 * Time: 11:19 AM
 */
// easyer to use secure functions in php
function s($str) {
    return htmlspecialchars($str);
}
function d($str) {
    return addslashes($str);
}
//only selected value are accepted
function allowedValues($aryValues=[]) {
    // makes emptry array
    $aryAllowValues = [];
    // loops throught the values submit
    foreach ($aryValues as $curValue) {
        // if that value makes what is in the post it's ok
        if (isset($_POST[$curValue]) == true) {
            // secure the value
            $aryAllowValues[$curValue] = s(d($_POST[$curValue]));
        } else {
            // makes that nothing
            $aryAllowValues[$curValue] = null;
        }
    }
    // get back the value
    return $aryAllowValues;
}

// see if the page is from the same domain
function checkDomain() {
    // error message
    $strErrorMessage = 'There was a problem';
    // display the error if they don't match
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        exit($strErrorMessage);
    }
    if(isset($_SERVER['HTTP_REFERER']) == false) {
        exit($strErrorMessage);
    } else {
        // client connection
        $clientHost = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        // web hosting service that is being used doesn't send this data
        // server connection
        $serveHost = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST);
        if ($clientHost != $serveHost) {
            return true;
            // dons't work on site5
            // exit($strErrorMessage);
        } else {
            return true;
        }
    }
}
// generates a random token
function makeToken() {
    // see how long the person been longed in
    if (checkTime() == false) {
        // random token
        $token = md5(uniqid(rand(), TRUE));
        $_SESSION['token'] = $token;
        $_SESSION['tokenTime'] = time();
        // makes the new token
        return "<input type=\"hidden\" name=\"token\" value=\"{$token}\">";
    } else {
        // display the token with the current value
        return "<input type=\"hidden\" name=\"token\" value=\"{$_SESSION['token']}\">";
    }
}
// check to if not been to long
function checkTime() {
    // no time has stared
    if(isset($_SESSION['tokenTime']) == false) {
        return false;
    } else {
        // makes the varible to store the tiem when created
        $timer = $_SESSION['tokenTime'] + (60 * 30);
    }
    // check the time to see been to long
    if ($timer < time()) {
        return false;
    } else {
        return true;
    }
}
// checks the token
function checkToken() {
    // see the session and client token are same and time is the same
    if ((htmlspecialchars($_POST['token']) != $_SESSION['token']) || (checkTime() == false)) {
        return false;
    } else {
        return true;
    }
}
?>