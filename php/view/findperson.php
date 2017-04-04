<?php
// check if the session has started
if(!isset($_SESSION))
{
    session_start();
}

// holds all of the states in one string
$States =  "<option value=\"\"></option>
                                   <option value=\"AL\">Alabama</option>
                                   <option value=\"AK\">Alaska</option>
                                   <option value=\"AZ\">Arizona</option>
                                   <option value=\"AR\">Arkansas</option>
                                   <option value=\"CA\">California</option>
                                   <option value=\"CO\">Colorado</option>
                                   <option value=\"CT\">Connecticut</option>
                                   <option value=\"DE\">Delaware</option>
                                   <option value=\"DC\">District Of Columbia</option>
                                   <option value=\"FL\">Florida</option>
                                   <option value=\"GA\">Georgia</option>
                                   <option value=\"HI\">Hawaii</option>
                                   <option value=\"ID\">Idaho</option>
                                   <option value=\"IL\">Illinois</option>
                                   <option value=\"IN\">Indiana</option>
                                   <option value=\"IA\">Iowa</option>
                                   <option value=\"KS\">Kansas</option>
                                   <option value=\"KY\">Kentucky</option>
                                   <option value=\"LA\">Louisiana</option>
                                   <option value=\"ME\">Maine</option>
                                   <option value=\"MD\">Maryland</option>
                                   <option value=\"MA\">Massachusetts</option>
                                   <option value=\"MI\">Michigan</option>
                                   <option value=\"MN\">Minnesota</option>
                                   <option value=\"MS\">Mississippi</option>
                                   <option value=\"MO\">Missouri</option>
                                   <option value=\"MT\">Montana</option>
                                   <option value=\"NE\">Nebraska</option>
                                   <option value=\"NV\">Nevada</option>
                                   <option value=\"NH\">New Hampshire</option>
                                   <option value=\"NJ\">New Jersey</option>
                                   <option value=\"NM\">New Mexico</option>
                                   <option value=\"NY\">New York</option>
                                   <option value=\"NC\">North Carolina</option>
                                   <option value=\"ND\">North Dakota</option>
                                   <option value=\"OH\">Ohio</option>
                                   <option value=\"OK\">Oklahoma</option>
                                   <option value=\"OR\">Oregon</option>
                                   <option value=\"PA\">Pennsylvania</option>
                                   <option value=\"RI\">Rhode Island</option>
                                   <option value=\"SC\">South Carolina</option>
                                   <option value=\"SD\">South Dakota</option>
                                   <option value=\"TN\">Tennessee</option>
                                   <option value=\"TX\">Texas</option>
                                   <option value=\"UT\">Utah</option>
                                   <option value=\"VT\">Vermont</option>
                                   <option value=\"VA\">Virginia</option>
                                   <option value=\"WA\">Washington</option>
                                   <option value=\"WV\">West Virginia</option>
                                   <option value=\"WI\">Wisconsin</option>
                                   <option value=\"WY\">Wyoming</option>";

// holds all of the countries
$countries = " <option value=\"\"></option>
                                   <option value=\"AF\">Afghanistan</option>
                                   <option value=\"AX\">Åland Islands</option>
                                   <option value=\"AL\">Albania</option>
                                   <option value=\"DZ\">Algeria</option>
                                   <option value=\"AS\">American Samoa</option>
                                   <option value=\"AD\">Andorra</option>
                                   <option value=\"AO\">Angola</option>
                                   <option value=\"AI\">Anguilla</option>
                                   <option value=\"AQ\">Antarctica</option>
                                   <option value=\"AG\">Antigua and Barbuda</option>
                                   <option value=\"AR\">Argentina</option>
                                   <option value=\"AM\">Armenia</option>
                                   <option value=\"AW\">Aruba</option>
                                   <option value=\"AU\">Australia</option>
                                   <option value=\"AT\">Austria</option>
                                   <option value=\"AZ\">Azerbaijan</option>
                                   <option value=\"BS\">Bahamas</option>
                                   <option value=\"BH\">Bahrain</option>
                                   <option value=\"BD\">Bangladesh</option>
                                   <option value=\"BB\">Barbados</option>
                                   <option value=\"BY\">Belarus</option>
                                   <option value=\"BE\">Belgium</option>
                                   <option value=\"BZ\">Belize</option>
                                   <option value=\"BJ\">Benin</option>
                                   <option value=\"BM\">Bermuda</option>
                                   <option value=\"BT\">Bhutan</option>
                                   <option value=\"BO\">Bolivia, Plurinational State of</option>
                                   <option value=\"BQ\">Bonaire, Sint Eustatius and Saba</option>
                                   <option value=\"BA\">Bosnia and Herzegovina</option>
                                   <option value=\"BW\">Botswana</option>
                                   <option value=\"BV\">Bouvet Island</option>
                                   <option value=\"BR\">Brazil</option>
                                   <option value=\"IO\">British Indian Ocean Territory</option>
                                   <option value=\"BN\">Brunei Darussalam</option>
                                   <option value=\"BG\">Bulgaria</option>
                                   <option value=\"BF\">Burkina Faso</option>
                                   <option value=\"BI\">Burundi</option>
                                   <option value=\"KH\">Cambodia</option>
                                   <option value=\"CM\">Cameroon</option>
                                   <option value=\"CA\">Canada</option>
                                   <option value=\"CV\">Cape Verde</option>
                                   <option value=\"KY\">Cayman Islands</option>
                                   <option value=\"CF\">Central African Republic</option>
                                   <option value=\"TD\">Chad</option>
                                   <option value=\"CL\">Chile</option>
                                   <option value=\"CN\">China</option>
                                   <option value=\"CX\">Christmas Island</option>
                                   <option value=\"CC\">Cocos (Keeling) Islands</option>
                                   <option value=\"CO\">Colombia</option>
                                   <option value=\"KM\">Comoros</option>
                                   <option value=\"CG\">Congo</option>
                                   <option value=\"CD\">Congo, the Democratic Republic of the</option>
                                   <option value=\"CK\">Cook Islands</option>
                                   <option value=\"CR\">Costa Rica</option>
                                   <option value=\"CI\">Côte d'Ivoire</option>
                                   <option value=\"HR\">Croatia</option>
                                   <option value=\"CU\">Cuba</option>
                                   <option value=\"CW\">Curaçao</option>
                                   <option value=\"CY\">Cyprus</option>
                                   <option value=\"CZ\">Czech Republic</option>
                                   <option value=\"DK\">Denmark</option>
                                   <option value=\"DJ\">Djibouti</option>
                                   <option value=\"DM\">Dominica</option>
                                   <option value=\"DO\">Dominican Republic</option>
                                   <option value=\"EC\">Ecuador</option>
                                   <option value=\"EG\">Egypt</option>
                                   <option value=\"SV\">El Salvador</option>
                                   <option value=\"GQ\">Equatorial Guinea</option>
                                   <option value=\"ER\">Eritrea</option>
                                   <option value=\"EE\">Estonia</option>
                                   <option value=\"ET\">Ethiopia</option>
                                   <option value=\"FK\">Falkland Islands (Malvinas)</option>
                                   <option value=\"FO\">Faroe Islands</option>
                                   <option value=\"FJ\">Fiji</option>
                                   <option value=\"FI\">Finland</option>
                                   <option value=\"FR\">France</option>
                                   <option value=\"GF\">French Guiana</option>
                                   <option value=\"PF\">French Polynesia</option>
                                   <option value=\"TF\">French Southern Territories</option>
                                   <option value=\"GA\">Gabon</option>
                                   <option value=\"GM\">Gambia</option>
                                   <option value=\"GE\">Georgia</option>
                                   <option value=\"DE\">Germany</option>
                                   <option value=\"GH\">Ghana</option>
                                   <option value=\"GI\">Gibraltar</option>
                                   <option value=\"GR\">Greece</option>
                                   <option value=\"GL\">Greenland</option>
                                   <option value=\"GD\">Grenada</option>
                                   <option value=\"GP\">Guadeloupe</option>
                                   <option value=\"GU\">Guam</option>
                                   <option value=\"GT\">Guatemala</option>
                                   <option value=\"GG\">Guernsey</option>
                                   <option value=\"GN\">Guinea</option>
                                   <option value=\"GW\">Guinea-Bissau</option>
                                   <option value=\"GY\">Guyana</option>
                                   <option value=\"HT\">Haiti</option>
                                   <option value=\"HM\">Heard Island and McDonald Islands</option>
                                   <option value=\"VA\">Holy See (Vatican City State)</option>
                                   <option value=\"HN\">Honduras</option>
                                   <option value=\"HK\">Hong Kong</option>
                                   <option value=\"HU\">Hungary</option>
                                   <option value=\"IS\">Iceland</option>
                                   <option value=\"IN\">India</option>
                                   <option value=\"ID\">Indonesia</option>
                                   <option value=\"IR\">Iran, Islamic Republic of</option>
                                   <option value=\"IQ\">Iraq</option>
                                   <option value=\"IE\">Ireland</option>
                                   <option value=\"IM\">Isle of Man</option>
                                   <option value=\"IL\">Israel</option>
                                   <option value=\"IT\">Italy</option>
                                   <option value=\"JM\">Jamaica</option>
                                   <option value=\"JP\">Japan</option>
                                   <option value=\"JE\">Jersey</option>
                                   <option value=\"JO\">Jordan</option>
                                   <option value=\"KZ\">Kazakhstan</option>
                                   <option value=\"KE\">Kenya</option>
                                   <option value=\"KI\">Kiribati</option>
                                   <option value=\"KP\">Korea, Democratic People's Republic of</option>
                                   <option value=\"KR\">Korea, Republic of</option>
                                   <option value=\"KW\">Kuwait</option>
                                   <option value=\"KG\">Kyrgyzstan</option>
                                   <option value=\"LA\">Lao People's Democratic Republic</option>
                                   <option value=\"LV\">Latvia</option>
                                   <option value=\"LB\">Lebanon</option>
                                   <option value=\"LS\">Lesotho</option>
                                   <option value=\"LR\">Liberia</option>
                                   <option value=\"LY\">Libya</option>
                                   <option value=\"LI\">Liechtenstein</option>
                                   <option value=\"LT\">Lithuania</option>
                                   <option value=\"LU\">Luxembourg</option>
                                   <option value=\"MO\">Macao</option>
                                   <option value=\"MK\">Macedonia, the former Yugoslav Republic of</option>
                                   <option value=\"MG\">Madagascar</option>
                                   <option value=\"MW\">Malawi</option>
                                   <option value=\"MY\">Malaysia</option>
                                   <option value=\"MV\">Maldives</option>
                                   <option value=\"ML\">Mali</option>
                                   <option value=\"MT\">Malta</option>
                                   <option value=\"MH\">Marshall Islands</option>
                                   <option value=\"MQ\">Martinique</option>
                                   <option value=\"MR\">Mauritania</option>
                                   <option value=\"MU\">Mauritius</option>
                                   <option value=\"YT\">Mayotte</option>
                                   <option value=\"MX\">Mexico</option>
                                   <option value=\"FM\">Micronesia, Federated States of</option>
                                   <option value=\"MD\">Moldova, Republic of</option>
                                   <option value=\"MC\">Monaco</option>
                                   <option value=\"MN\">Mongolia</option>
                                   <option value=\"ME\">Montenegro</option>
                                   <option value=\"MS\">Montserrat</option>
                                   <option value=\"MA\">Morocco</option>
                                   <option value=\"MZ\">Mozambique</option>
                                   <option value=\"MM\">Myanmar</option>
                                   <option value=\"NA\">Namibia</option>
                                   <option value=\"NR\">Nauru</option>
                                   <option value=\"NP\">Nepal</option>
                                   <option value=\"NL\">Netherlands</option>
                                   <option value=\"NC\">New Caledonia</option>
                                   <option value=\"NZ\">New Zealand</option>
                                   <option value=\"NI\">Nicaragua</option>
                                   <option value=\"NE\">Niger</option>
                                   <option value=\"NG\">Nigeria</option>
                                   <option value=\"NU\">Niue</option>
                                   <option value=\"NF\">Norfolk Island</option>
                                   <option value=\"MP\">Northern Mariana Islands</option>
                                   <option value=\"NO\">Norway</option>
                                   <option value=\"OM\">Oman</option>
                                   <option value=\"PK\">Pakistan</option>
                                   <option value=\"PW\">Palau</option>
                                   <option value=\"PS\">Palestinian Territory, Occupied</option>
                                   <option value=\"PA\">Panama</option>
                                   <option value=\"PG\">Papua New Guinea</option>
                                   <option value=\"PY\">Paraguay</option>
                                   <option value=\"PE\">Peru</option>
                                   <option value=\"PH\">Philippines</option>
                                   <option value=\"PN\">Pitcairn</option>
                                   <option value=\"PL\">Poland</option>
                                   <option value=\"PT\">Portugal</option>
                                   <option value=\"PR\">Puerto Rico</option>
                                   <option value=\"QA\">Qatar</option>
                                   <option value=\"RE\">Réunion</option>
                                   <option value=\"RO\">Romania</option>
                                   <option value=\"RU\">Russian Federation</option>
                                   <option value=\"RW\">Rwanda</option>
                                   <option value=\"BL\">Saint Barthélemy</option>
                                   <option value=\"SH\">Saint Helena, Ascension and Tristan da Cunha</option>
                                   <option value=\"KN\">Saint Kitts and Nevis</option>
                                   <option value=\"LC\">Saint Lucia</option>
                                   <option value=\"MF\">Saint Martin (French part)</option>
                                   <option value=\"PM\">Saint Pierre and Miquelon</option>
                                   <option value=\"VC\">Saint Vincent and the Grenadines</option>
                                   <option value=\"WS\">Samoa</option>
                                   <option value=\"SM\">San Marino</option>
                                   <option value=\"ST\">Sao Tome and Principe</option>
                                   <option value=\"SA\">Saudi Arabia</option>
                                   <option value=\"SN\">Senegal</option>
                                   <option value=\"RS\">Serbia</option>
                                   <option value=\"SC\">Seychelles</option>
                                   <option value=\"SL\">Sierra Leone</option>
                                   <option value=\"SG\">Singapore</option>
                                   <option value=\"SX\">Sint Maarten (Dutch part)</option>
                                   <option value=\"SK\">Slovakia</option>
                                   <option value=\"SI\">Slovenia</option>
                                   <option value=\"SB\">Solomon Islands</option>
                                   <option value=\"SO\">Somalia</option>
                                   <option value=\"ZA\">South Africa</option>
                                   <option value=\"GS\">South Georgia and the South Sandwich Islands</option>
                                   <option value=\"SS\">South Sudan</option>
                                   <option value=\"ES\">Spain</option>
                                   <option value=\"LK\">Sri Lanka</option>
                                   <option value=\"SD\">Sudan</option>
                                   <option value=\"SR\">Suriname</option>
                                   <option value=\"SJ\">Svalbard and Jan Mayen</option>
                                   <option value=\"SZ\">Swaziland</option>
                                   <option value=\"SE\">Sweden</option>
                                   <option value=\"CH\">Switzerland</option>
                                   <option value=\"SY\">Syrian Arab Republic</option>
                                   <option value=\"TW\">Taiwan, Province of China</option>
                                   <option value=\"TJ\">Tajikistan</option>
                                   <option value=\"TZ\">Tanzania, United Republic of</option>
                                   <option value=\"TH\">Thailand</option>
                                   <option value=\"TL\">Timor-Leste</option>
                                   <option value=\"TG\">Togo</option>
                                   <option value=\"TK\">Tokelau</option>
                                   <option value=\"TO\">Tonga</option>
                                   <option value=\"TT\">Trinidad and Tobago</option>
                                   <option value=\"TN\">Tunisia</option>
                                   <option value=\"TR\">Turkey</option>
                                   <option value=\"TM\">Turkmenistan</option>
                                   <option value=\"TC\">Turks and Caicos Islands</option>
                                   <option value=\"TV\">Tuvalu</option>
                                   <option value=\"UG\">Uganda</option>
                                   <option value=\"UA\">Ukraine</option>
                                   <option value=\"AE\">United Arab Emirates</option>
                                   <option value=\"GB\">United Kingdom</option>
                                   <option value=\"USA\">United States</option>
                                   <option value=\"UM\">United States Minor Outlying Islands</option>
                                   <option value=\"UY\">Uruguay</option>
                                   <option value=\"UZ\">Uzbekistan</option>
                                   <option value=\"VU\">Vanuatu</option>
                                   <option value=\"VE\">Venezuela, Bolivarian Republic of</option>
                                   <option value=\"VN\">Viet Nam</option>
                                   <option value=\"VG\">Virgin Islands, British</option>
                                   <option value=\"VI\">Virgin Islands, U.S.</option>
                                   <option value=\"WF\">Wallis and Futuna</option>
                                   <option value=\"EH\">Western Sahara</option>
                                   <option value=\"YE\">Yemen</option>
                                   <option value=\"ZM\">Zambia</option>
                                   <option value=\"ZW\">Zimbabwe</option>";

// turns the strings into arrays
$aryState = explode("\n",$States);
$aryCountry = explode("\n",$countries);
?>
<html>
<head>
    <title>Main Gate</title>
    <meta charset="utf-8">
    <meta name="theme-color" content="#ff8080">
    <link rel="manifest" href="manifest.json">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="dist/myStyle.css" />
    <link rel="icon" type="image/x-icon" href="images/favicon.ico"/>
</head>
<body id="findPersonBody">
<div class="container">
    <!--main container-->
    <div class="row">
        <div class="col-centered">
            <h1 class="text-center">Visitor Lookup</h1>
            <form action="php/controller/search.php" method="post" id="searchPerson">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#pBodyBasicInfro">Basic info</a>
                        </div>
                        <div id="pBodyBasicInfro" class="in panel-body panel-collapse collapse">
                            <div class="form-group">
                                <label>First Name</label>
                                <input class="form-control" value="<?php
                                // see if there value
                                if(isset($_SESSION['FName']) == true) {
                                    // puts the value
                                    echo $_SESSION['FName'];
                                } ?>" type="text" placeholder="First Name" name="FName">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="form-control" value="<?php
                                if(isset( $_SESSION['LName']) == true) {
                                    echo  $_SESSION['LName'];
                                } ?>" type="text" placeholder="Last Name" name="LName">
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#pBodyAddressGroup">Address group</a>
                        </div>
                        <div id="pBodyAddressGroup" class="panel-body panel-collapse collapse">
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" value="<?php
                                if(isset( $_SESSION['Address']) == true) {
                                    echo  $_SESSION['Address'];
                                } ?>" type="text" placeholder="Address" name="Address">
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input class="form-control" type="text" value="<?php
                                if(isset( $_SESSION['City']) == true) {
                                    echo  $_SESSION['City'];
                                } ?>" placeholder="City" name="City">
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                <select class="form-control" name="StateProvince">
                                    <?php
                                    // http://stackoverflow.com/questions/8251426/insert-string-at-specified-position
                                    // loops though the array
                                    foreach ($aryState as $curState) {
                                        // remove spaces
                                        $curState = trim($curState);
                                        // check to if the value is there
                                        if(isset($_SESSION['StateProvince']) == true) {
                                            // focus on the correct value in session varible
                                            if (substr($curState, strpos($curState, "value=")+7,2) == $_SESSION['StateProvince']) {
                                                // outputs focus value
                                                echo substr($curState, 0, strpos($curState, "value=")+10) . "selected=\"selected\"" . substr($curState, strpos($curState, "value=")+10);
                                            } else {
                                                // stanrd value
                                                echo $curState;
                                            }
                                        } else {
                                            echo $curState;
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <select name="Country" class="form-control">
                                    <?php
                                    foreach ($aryCountry as $curCountry) {
                                        $curCountry = trim($curCountry);
                                        if(isset($_SESSION['Country']) == true) {
                                            if(substr($curCountry, strpos($curCountry, "value=")+7,3) == $_SESSION['Country']) {
                                                echo substr($curCountry, 0, strpos($curCountry, "value=")+11) . "selected=\"selected\"" . substr($curCountry, strpos($curCountry, "value=")+11);
                                            } else {
                                                if (substr($curCountry, strpos($curCountry, "value=")+7,2) == $_SESSION['Country']) {
                                                    echo substr($curCountry, 0, strpos($curCountry, "value=")+10) . "selected=\"selected\"" . substr($curCountry, strpos($curCountry, "value=")+10);
                                                } else {
                                                    echo $curCountry;
                                                }
                                            }
                                        } else {
                                            echo $curCountry;
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#pBodyContact">Contact info</a>
                        </div>
                        <div id="pBodyContact" class="panel-body panel-collapse collapse">
                            <div class="form-group">
                                <label>ID</label>
                                <input class="form-control" type="text" value="<?php
                                if(isset( $_SESSION['VisitorID']) == true) {
                                    echo  $_SESSION['VisitorID'];
                                } ?>" placeholder="Person ID" name="VisitorID">
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input class="form-control" type="tel" value="<?php
                                if(isset( $_SESSION['PhoneNumber']) == true) {
                                    echo  $_SESSION['PhoneNumber'];
                                } ?>" placeholder="Phone Number" name="PhoneNumber">
                            </div>
                            <div class="form-group">
                                <label>Zip</label>
                                <input class="form-control" type="text" value="<?php
                                if(isset( $_SESSION['PostalCode']) == true) {
                                    echo  $_SESSION['PostalCode'];
                                } ?>" placeholder="Zip" name="PostalCode">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" value="<?php
                                if(isset( $_SESSION['Email']) == true) {
                                    echo  $_SESSION['Email'];
                                } ?>" type="text" placeholder="Email" name="Email">
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input class="form-control" value="<?php
                                if(isset( $_SESSION['DOB']) == true) {
                                    echo  $_SESSION['DOB'];
                                } ?>" type="text" placeholder="Date of Birth YYYY/DD/MM" name="DOB">
                            </div>
                        </div>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-default" id="findPerson">Find person</button>
                        <button type="submit" class="btn btn-default" id="searchPhone" disabled="disabled">Search by fields</button>
                        <button class="btn btn-default" id="btnClear">Clear</button>
                        <a class="btn btn-default" id="btnLogout" href="logout">Logout</a>
                    </div>
                </div>
                <input type="hidden" type="text" id="action" name="action" value="search">
                <?php
                require('../controller/defense.php');
                echo makeToken();
                ?>
            </form>
            <?php
            if(isset($_SESSION['sqlValuesForMutiPeople']) == true) {
                // checks the number of people return from the query
                if(sizeof($_SESSION['sqlValuesForMutiPeople'])>= 2){
                    // display the panel for it
                    require "../includes/mutiPeople.php";
                }
            }
            ?>
            <?php
            // check if there a person alright there
            if((isset($_SESSION['FName']) == true) && (isset($_SESSION['LName']) == true)) {
                // display the panel for it
                require "../includes/comments.php";
            }
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    // get the Javascript
    <?php echo file_get_contents("../../dist/my-com.js") ?>
</script>
</body>
</html>