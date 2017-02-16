<?php

    /*Summary:
     *Returns a PDO object that has access to the festival database.
     */
    function getAccess() {
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
            return $db;
        } catch (PDOException $err) {
            exit($err->getMessage());
        }
    }

    /*Summary:
     *Takes the required parts to query a database through a PDO object
     *and inserts those things into working code.
     */
    /*Remarks:
     *Function provides some error feedback.
     */
    /*Parameters:
     * ($strQuer) - The MySQL query as a string (i.e. SELECT * FROM someTable WHERE someTable = :someValue)
     * ($aryStatments) - Array of each thing in the MySQL query that looks like this (element example: ":someSQLVariablePlaceholder")
     * ($aryValues) - Array of each value assigned to each element in '$aryStatments' (element example: 1, "a string", true)
     * ($intGetValues) - Value determining if a single or all rows of fetched data is returned.
     *                      If value = 0, then only a single row is returned
     *                      If value = 1, then all rows are returned
     */
    function handSQL($strQuer="",$aryStatments=[], $aryValues=[], $intGetValues = 0) {
        $db = getAccess();

        if (count($aryStatments) == count($aryValues)) {
            $statement = $db->prepare($strQuer);
            if (!$statement) {
                exit("Sorry prepare failed");
            }
            for($lcv = 0;$lcv < count($aryStatments);$lcv++){
                $bind_results = $statement->bindValue($aryStatments[$lcv], $aryValues[$lcv]);
                if(!$bind_results) {
                    exit("Sorry can't bind these value");
                }
            }

            $workQuery = $statement->execute();
            if(!$workQuery) {
                exit("Bad execcution");
            }

            if ($intGetValues == 0){
                $newFeedback = $statement -> fetch();
            } elseif ($intGetValues == 1) {
                $newFeedback = $statement -> fetchAll();
            }

            $statement->closeCursor();
            return $newFeedback;
        } else {
            exit("Mismatched values");
        }
    }
?>
