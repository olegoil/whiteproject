<?php

class whitesql {

    var $serverName = "BlockChain5-SQL"; //serverName\instanceName
    var $database = "WhiteCoin";
    var $user= "sa";
    var $password = "Pos!2014";
    var $connection;

    function ConnectODBC() {

        return    $connection = odbc_connect("Driver={SQL Server Native Client 11.0};Server=$this->serverName;Database=$this->database;", $this->user, $this->password);

    }
        
    function ODBC_EXEC( $connection ,$q ) {
        
        $result =  odbc_exec($connection, $q) or die("<p>".odbc_errormsg());
        return $result;
        
    }

    function ODBC_CLOSE() {
        
        odbc_close( $connection );
        
    }

    function QUERY($q) {

        $connection = $this->ConnectODBC();
        $result = $this->ODBC_EXEC ( $connection , $q );
         
        return $result;
    }

    function getTableSchema($tblname) {
        $q = "select column_name, data_type, CHARACTER_MAXIMUM_LENGTH from information_schema.columns
        where table_name = '".$tblname."'
        order by ordinal_position";
        $result = $this->QUERY( $q );
        $results = $tblname.'<br/>';
        $x=0;
        while ($x< odbc_num_rows( $result )) {
            $row = odbc_fetch_array( $result );
            $results .= json_encode($row['column_name'] . ' | (' . $row['data_type'] . ' ' . $row['CHARACTER_MAXIMUM_LENGTH'] . ' )', JSON_UNESCAPED_UNICODE).'<br/>';
            $x++;
        }
        echo $results.'<br/><hr/>';
    }

    // QUERIES FOR CRUD
    function dbQuery($query) {
        $result = $this->QUERY( $query );
    }

    function getTableData($table) {
        $q = "SELECT * FROM ".$table;
        $result = $this->QUERY( $q );
        $results = '';
        $x=0;
        while ($x< odbc_num_rows( $result )) {
            $row = odbc_fetch_array( $result );
            $results .= json_encode($row, JSON_UNESCAPED_UNICODE).'<hr/>';
            $x++;
        }
        echo $results;
    }

    function getSchemaDatabases() {
        $q = "SELECT name FROM master.dbo.sysdatabases";
        $result = $this->QUERY( $q );
        $results = '';
        $x=0;
        while ($x< odbc_num_rows( $result )) {
            $row = odbc_fetch_array( $result );
            $results .= json_encode($row['name'], JSON_UNESCAPED_UNICODE).'<br/>';
            $x++;
        }
        echo $results;
    }

    function getSchema() {
        $q = "SELECT * FROM sys.tables";
        $result = $this->QUERY( $q );
        $results = '';
        $x=0;
        while ($x< odbc_num_rows( $result )) {
            $row = odbc_fetch_array( $result );
            $results .= json_encode($row['name'], JSON_UNESCAPED_UNICODE).'<br/>';
            $x++;
        }
        echo $results;
    }

    // ID GENERATOR
    function createRecordID() {
        $valid_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYX1234567890";
        $length = 32;
        
        // start with an empty random string
        $random_string = "";

        // count the number of chars in the valid chars string so we know how many choices we have
        $num_valid_chars = strlen($valid_chars);

        // repeat the steps until we've created a string of the right length
        for ($i = 0; $i < $length; $i++)
        {
            // pick a random number from 1 up to the number of valid chars
            $random_pick = mt_rand(1, $num_valid_chars);

            // take the random character out of the string of valid chars
            // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
            $random_char = $valid_chars[$random_pick-1];

            // add the randomly-chosen char onto the end of our string so far
            $random_string .= $random_char;
        }

        // return our finished random string
        return $random_string;
    }

}

$basic2 = new whitesql();

// GET DATABASE SCHEMA
// $basic2->getSchemaDatabases();

// DB QUERY
// $sql = "CREATE TABLE bank ("
//       . " recid VARCHAR(100) NOT NULL"
//       . ", name VARCHAR(100)"
//       . ", amount VARCHAR(100)"
//       . ", datetime VARCHAR(100)"
//       . ", bankdel VARCHAR(1)"
//       . ")";
// $basic2->dbQuery($sql);

// DELETE COLUMN
// $sql = "ALTER TABLE Tickets DROP COLUMN Category";
// $basic->sql->dbQuery($sql);

// ADD COLUMN
// $sql = "ALTER TABLE documents ADD userid VARCHAR(100)";
// $basic2->dbQuery($sql);

// RENAME COLUMN
// $sql = "EXEC sp_rename 'Team.mem_id', 'RecID', 'COLUMN'";
// $basic2->dbQuery($sql);

// CHANGE DATA TYPE OF COLUMN
// $sql = "ALTER TABLE users ALTER COLUMN user_hash varchar(200)";
// $basic2->dbQuery($sql);

// DELETE ROWS
// $sql = "DELETE FROM bank";
// $basic2->dbQuery($sql);

// UPDATE ROWS
// $sql1 = "UPDATE transactions SET amount_to='1' WHERE recid='WKMLJU2WNJF2O3RTP4A81334C36J59J3'";
// $basic2->dbQuery($sql1);

// INSERT ROWS
// $recId = $basic2->createRecordID();
// $when = time();
// $sql1 = "INSERT INTO exchange (recid, amount1, amount2, currency1, currency2, datetime) VALUES ('$recId', '550', '1', 'USD', 'WCR', '$when')";
// $basic2->dbQuery($sql1);

// SHA-256 ENCRYPTION TO DB
// function hashFwd($plaintext) {
//     $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
//     $iv = openssl_random_pseudo_bytes($ivlen);
//     $ciphertext_raw = openssl_encrypt($plaintext, $cipher, 'whiteprojectforever', $options=OPENSSL_RAW_DATA, $iv);
//     $hmac = hash_hmac('sha256', $ciphertext_raw, 'whiteprojectforever', $as_binary=true);
//     $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
//     return $ciphertext;
// }

// GET ALL TABLE COLUMNS
$basic2->getTableSchema('users');
$basic2->getTableSchema('bank');
$basic2->getTableSchema('transactions');
$basic2->getTableSchema('documents');
$basic2->getTableSchema('wallets');
$basic2->getTableSchema('support');
$basic2->getTableSchema('exchange');

// GRAB TABLE DATA
echo 'bank<br/>' . json_encode($basic2->getTableData('bank')) . '<hr/>';
echo 'wallets<br/>' . json_encode($basic2->getTableData('wallets')) . '<hr/>';
echo 'users<br/>' . json_encode($basic2->getTableData('users')) . '<hr/>';
echo 'exchange<br/>' . json_encode($basic2->getTableData('exchange')) . '<hr/>';
echo 'transactions<br/>' . json_encode($basic2->getTableData('transactions')) . '<hr/>';

?>