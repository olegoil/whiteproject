<?php

class sql {

    var $serverName = "BlockChain5-SQL";
    var $database = "WhiteCoin";
    var $user= "sa";
    var $password = "Pos!2014";
    var $hostname = "olegtronics.com";
    var $salt = 'bestprojectever';
    var $key = 'whiteprojectforever';
    var $conn;

    // PROTECT FUNCTION FROM INJECTION, ETC (TO SAVE STRINGS IN DB)
    function protect($v) {
        $v = trim($v);
        $v = stripslashes($v);
        $v = htmlentities($v, ENT_QUOTES);
        $v = str_replace("'", "''", $v);
        $v = addslashes($v);
        return $v;
    }
    // SHA-256 ENCRYPTION TO DB
    function hashFwd($plaintext) {
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $this->key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $this->key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        return $ciphertext;
    }
    // SHA-256 DECRYPTION FROM DB
    function hashBack($ciphertext) {
        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $this->key, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $this->key, $as_binary=true);
        if (hash_equals($hmac, $calcmac))
        {
            return $original_plaintext;
        }
    }
    // HASHING PWD
    function hashword($str) {
        $str = crypt($str.$this->salt, '$1$xxx$');
        return $str;
    }
    // RANDOM STRING GENERATOR
    function generateRandomString($length = 9) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
    // ID GENERATOR
    function createBankWireID() {
        $valid_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYX1234567890";
        $length = 10;
        
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
    // CONNECT TO DB
    function connectDB() {
        return $connection = odbc_connect("Driver={SQL Server Native Client 11.0};Server=$this->serverName;Database=$this->database;", $this->user, $this->password);
    }
    // CLOSE DB CONNECTION
    function closeConn() {
        odbc_close($this->conn);
    }
    // QUERY EXECUTION
    function dbquery($q) {
        $connection = $this->connectDB();
        $result = odbc_exec($connection, $q) or die("<p>".odbc_errormsg());
        return $result;
    }
    // USER REGISTRATION
    function registerUser($email, $pwd) {

        $emailhash = $this->hashword($email);
        $pwd = $this->hashword($pwd);
        $when = time();
        $recID = $this->createRecordID();
        $accesLevel = array("User" => 0, "Manager" => 1, "Minter" => 2, "KYCAML" => 3);
      
        $query = "SELECT * FROM users WHERE user_id = '$recID' OR user_email = '$emailhash'";
        $checkUsr = $this->dbquery($query);
        $rows = odbc_num_rows($checkUsr);

        $regArr = array();
      
        // IF USER NOT EXISTS
        if($rows == 0) {

            $uip = $this->get_client_ip_server();
            $queryIns = "INSERT INTO users (user_id, user_email, user_pwd, user_when, user_ip, user_confirm, user_mobile_confirm, user_type) VALUES ('$recID', '$emailhash', '$pwd', '$when', '$uip', 0, 1, 0)";
            $insUsr = $this->dbquery($queryIns);

            $querySel = "SELECT * FROM users WHERE user_email = '$emailhash' AND user_pwd = '$pwd' AND user_when = '$when'";
            $selUsr = $this->dbquery($querySel);
            $rowUsr = odbc_fetch_array($selUsr);
            $rowsUsr = odbc_num_rows($selUsr);

            if($rowsUsr > 0) {

                $this->createWallets($rowUsr);

                $hash = $when . '_' . $rowUsr['user_id'];
                $hash = $this->hashFwd($hash);

                $setUsrHash = "UPDATE users SET user_hash='$hash' WHERE user_id='".$rowUsr['user_id']."'";
                $this->dbquery($setUsrHash);

                $this->registrationEmail($hash, $email);

                array_push($regArr, array("success" => 1));

            }
            else {
                // $headerErrCreate = 'http://whitecoin.blockchaindevelopers.org?msg=errcreate2';
                // header(sprintf("Location: %s", $headerErrCreate));
                array_push($regArr, array("success" => 2));
            }
      
        }
        // IF USER EXISTS
        else {
            // $this->checkLogin();
            array_push($regArr, array("success" => 0));
        }

        return $regArr;

    }
    // USER REGISTRATION
    function registerMinter($email, $pwd, $firstname, $lastname) {

        $emailhash = $this->hashword($email);
        $pwd = $this->hashword($pwd);
        $when = time();
        $recID = $this->createRecordID();
        $accesLevel = array("User" => 0, "Manager" => 1, "Minter" => 2, "KYCAML" => 3);
      
        $query = "SELECT * FROM users WHERE user_id = '$recID' OR user_email = '$emailhash'";
        $checkUsr = $this->dbquery($query);
        $rows = odbc_num_rows($checkUsr);

        $regArr = array();
      
        // IF USER NOT EXISTS
        if($rows == 0) {

            $uip = $this->get_client_ip_server();
            $queryIns = "INSERT INTO users (user_id, user_email, user_pwd, user_when, user_ip, user_confirm, user_mobile_confirm, user_type, user_name, user_lastname) VALUES ('$recID', '$emailhash', '$pwd', '$when', '$uip', 1, 1, 2, '$firstname', '$lastname')";
            $insUsr = $this->dbquery($queryIns);

            $querySel = "SELECT * FROM users WHERE user_email = '$emailhash' AND user_pwd = '$pwd' AND user_when = '$when'";
            $selUsr = $this->dbquery($querySel);
            $rowUsr = odbc_fetch_array($selUsr);
            $rowsUsr = odbc_num_rows($selUsr);

            if($rowsUsr > 0) {

                $this->createWallets($rowUsr);

                $hash = $when . '_' . $rowUsr['user_id'];
                $hash = $this->hashFwd($hash);

                $setUsrHash = "UPDATE users SET user_hash='$hash' WHERE user_id='".$rowUsr['user_id']."'";
                $this->dbquery($setUsrHash);

                array_push($regArr, array("success" => 1));

            }
            else {
                // NO USER CREATED
                array_push($regArr, array("success" => 2));
            }
      
        }
        // IF USER EXISTS
        else {
            // $this->checkLogin();
            array_push($regArr, array("success" => 0));
        }

        return $regArr;

    }
    // CREATE WALLETS AT REGISTRATION
    function createWallets($rowUsr) {
        $recIDwalletWCR = $this->createRecordID();
        $recIDwalletWCUR = $this->createRecordID();
        $recIDwalletBTC = $this->createRecordID();
        $recIDwalletETH = $this->createRecordID();
        $when = time();
        $queryWalletWCR = "INSERT INTO wallets (recid, userid, type, amount, datetime, walletdel) VALUES ('$recIDwalletWCR', '".$rowUsr['user_id']."', 0, 0, '$when', 0)";
        $this->dbquery($queryWalletWCR);
        $queryWalletWCUR = "INSERT INTO wallets (recid, userid, type, amount, datetime, walletdel) VALUES ('$recIDwalletWCUR', '".$rowUsr['user_id']."', 1, 0, '$when', 0)";
        $this->dbquery($queryWalletWCUR);
        $queryWalletBTC = "INSERT INTO wallets (recid, userid, type, amount, datetime, walletdel) VALUES ('$recIDwalletBTC', '".$rowUsr['user_id']."', 2, 0, '$when', 0)";
        $this->dbquery($queryWalletBTC);
        $queryWalletETH = "INSERT INTO wallets (recid, userid, type, amount, datetime, walletdel) VALUES ('$recIDwalletETH', '".$rowUsr['user_id']."', 3, 0, '$when', 0)";
        $this->dbquery($queryWalletETH);
    }
    // REGISTRATION CONFIRMATION EMAIL
    function registrationEmail($hash, $email) {
        $baseDomain = 'http://whitecoin.blockchaindevelopers.org';
        $baseCookieDomain = 'whitecoin.blockchaindevelopers.org';

        // SEND EMAIL TO NEW USER
        $email_subject = "Email confirmation from ".$baseCookieDomain.".";
        $email_body = '<html style="width:100%;height:100%;"><body style="background-color:#E0F1FF;width:100%;height:100%;">';
        $email_body .= '<div style="text-align:center;"><img style="margin:10px auto;height:60px;" src="'.$baseDomain.'/images/logo.png" alt="White Standard" /></div>';
        $email_body .= '<div style="margin:30px;padding:20px;background-color:#fff;text-align:center;">';
        $email_body .= '<h2 style="text-align:left;">Confirm Your Registration</h2>';
        $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">Welcome to <strong>White Standard!</strong></h2>';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">Click the link below to complete verification:</h2>';
        $email_body .= '<br/><a style="display:inline-block;background-color:#3C8DC8;color:#fff;padding:20px;text-align:center;font-size:36px;text-decoration:none;" href="'.$baseDomain.'/confirmation.php?emailConf='.urlencode($hash).'&signUpEmail='.urlencode($email).'" target="_blank">Verify Email</a>';
        // $email_body .= '<br/><h2 style="text-align:left;">if this activity is not your own operation, please contact us immediately.</h2>';
        $email_body .= '<br/><br/><br/><h4 style="color:#999;text-align:left;font-weight:normal;margin-bottom:0px;">White Standard Team</h4>';
        $email_body .= '<h4 style="color:#888;text-align:left;font-weight:normal;margin-top:0px;">Automated message. Please do not reply.</h4>';
        $email_body .= '<a style="text-decoration:none;font-weight:normal;color:#3C8DC8;font-size:1.5em;" href="'.$baseDomain.'" target="_blank">'.$baseDomain.'</a>';
        $email_body .= '</div><br/></body"></html>';
    
        require_once "SendMailSmtpClass.php";
        $mailSMTP = new SendMailSmtpClass('xanatosdark@yandex.ru', 'Vivanco2!', 'ssl://smtp.yandex.ru', 'White Standard', 465);
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: White Standard <noreply@".$baseCookieDomain.">\r\n";
        $mailSMTP->send($email, $email_subject, $email_body, $headers);
    }
    // USER LOGIN
    function loginUser($email, $pwd) {

        $emailhash = $this->hashword($email);
        $pwd = $this->hashword($pwd);
        $when = time();
      
        $query = "SELECT * FROM users WHERE user_email = '$emailhash' AND user_pwd = '$pwd'";
        $checkUsr = $this->dbquery($query);
        $row = odbc_fetch_array($checkUsr);
        $rows = odbc_num_rows($checkUsr);

        if($rows > 0) {

            if($row['user_confirm'] == '1') {

                $uid = $row['user_id'];
                $hash = $when . '_' . $uid;
                $hash = $this->hashFwd($hash);

                $setUsrHash = "UPDATE users SET user_hash='$hash', user_log='$when' WHERE user_id='$uid'";
                $this->dbquery($setUsrHash);

                // SET COOKIES FOR 24 HOURS
                $cookielife = $when + 60*30*24;
                if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
                    setcookie("u", $uid, $cookielife, '/', 'localhost');
                    setcookie("h", $hash, $cookielife, '/', 'localhost');
                }
                else {
                    setcookie("u", $uid, $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
                    setcookie("h", $hash, $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
                }
            
                $cookiesuccess = "http://whitecoin.blockchaindevelopers.org/main/";
                header(sprintf("Location: %s", $cookiesuccess));

            }
            else {
                $loginFailed = 'http://whitecoin.blockchaindevelopers.org/?failed=2&email='.$email;
                header(sprintf("Location: %s", $loginFailed));
            }

        }
        else {
            $loginFailed = 'http://whitecoin.blockchaindevelopers.org/?failed=1&email='.$email;
            header(sprintf("Location: %s", $loginFailed));
        }

    }
    // USER LOGOUT
    function logoutUser() {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $when = time();
            $cookielife = $when - 60*30;
            if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
                setcookie("u", $_COOKIE['u'], $cookielife, '/', 'localhost');
                setcookie("h", $_COOKIE['h'], $cookielife, '/', 'localhost');
            }
            else {
                setcookie("u", $_COOKIE['u'], $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
                setcookie("h", $_COOKIE['h'], $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
            }
        }
        $headerLogout = "http://whitecoin.blockchaindevelopers.org";
        header(sprintf("Location: %s", $headerLogout));
    }
    // USER CHECK LOGIN
    function checkLogin() {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $query = "SELECT * FROM users WHERE user_id = '$u'";
            $checkUsr = $this->dbquery($query);
            $row = odbc_fetch_array($checkUsr);
            $rows = odbc_num_rows($checkUsr);

            if($rows > 0) {

                if(urlencode($row['user_hash']) == urlencode($h)) {

                    // SET COOKIES FOR 24 HOURS
                    $when = time();
                    $cookielife = $when + 60*30*24;
                    if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
                        setcookie("u", $_COOKIE['u'], $cookielife, '/', 'localhost');
                        setcookie("h", $_COOKIE['h'], $cookielife, '/', 'localhost');
                    }
                    else {
                        setcookie("u", $_COOKIE['u'], $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
                        setcookie("h", $_COOKIE['h'], $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
                    }

                }
                else {
                    $notcookie = "http://whitecoin.blockchaindevelopers.org/coms/logout.php";
                    header(sprintf("Location: %s", $notcookie));
                }
                
            }
            else {
                $notcookie = "http://whitecoin.blockchaindevelopers.org/coms/logout.php";
                header(sprintf("Location: %s", $notcookie));
            }
        }
        else {
            $notcookie = "http://whitecoin.blockchaindevelopers.org/coms/logout.php";
            header(sprintf("Location: %s", $notcookie));
        }
    }
    // USER PASSWORD RESET
    function passwordReset($useremail) {
    
        if($useremail == "") return json_encode(array("emailReset" => 0), JSON_UNESCAPED_UNICODE);

        $useremailhash = $this->hashword($useremail);
    
        $q = "SELECT * FROM users WHERE user_email='$useremailhash'";
        $result = $this->dbquery($q);
        $results = odbc_fetch_array($result);
        $resrows = odbc_num_rows($result);
    
        if($resrows > 0) {

            $userId = $results['user_id'];
            $forgotHash = time() . '_' . $userId;
            $forgotHash = $this->hashword($forgotHash);
    
            $qupd = "UPDATE users SET user_reset_pwd = '$forgotHash' WHERE user_id = '$userId'";
            $resultupd = $this->dbquery($qupd);
    
            $results['user_reset_pwd'] = $forgotHash;
            $results['emailReset'] = 1;

            $baseDomain = 'http://whitecoin.blockchaindevelopers.org';
            $baseCookieDomain = 'whitecoin.blockchaindevelopers.org';

            // SEND RESET EMAIL TO USER
            $email_subject = "Email password reset from whitecoin.blockchaindevelopers.org.";
            $email_body = '<html style="width:100%;height:100%;"><body style="background-color:#E0F1FF;width:100%;height:100%;">';
            $email_body .= '<div style="text-align:center;"><img style="margin:10px auto;height:60px;" src="'.$baseDomain.'/images/logo.png" alt="White Standard" /></div>';
            $email_body .= '<div style="margin:30px;padding:20px;background-color:#fff;text-align:center;">';
            $email_body .= '<h2 style="text-align:left;">Password Reset</h2>';
            $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
            $email_body .= '<h2 style="text-align:left;font-weight:normal;">Click the link below to reset Your password:</h2>';
            $email_body .= '<br/><a href="'.$baseDomain.'/coms/resetpwd.php?forgotEmail='.$useremail.'&forgotHash='.urlencode($forgotHash).'" target="_blank" style="display:inline-block;background-color:#3C8DC8;color:#fff;padding:20px;text-align:center;font-size:24px;text-decoration:none;">Reset password</a>';
            // $email_body .= '<br/><h2 style="text-align:left;">if this activity is not your own operation, please contact us immediately.</h2>';
            $email_body .= '<br/><br/><br/><h4 style="color:#999;text-align:left;font-weight:normal;margin-bottom:0px;">White Standard Team</h4>';
            $email_body .= '<h4 style="color:#888;text-align:left;font-weight:normal;margin-top:0px;">Automated message. Please do not reply.</h4>';
            $email_body .= '<a style="text-decoration:none;font-weight:normal;color:#3C8DC8;font-size:1.5em;" href="http://www.support.'.$baseCookieDomain.'/" target="_blank">http://support.'.$baseCookieDomain.'</a>';
            $email_body .= '</div><br/></body"></html>';
        
            require_once "SendMailSmtpClass.php";
            $mailSMTP = new SendMailSmtpClass('xanatosdark@yandex.ru', 'Vivanco2!', 'ssl://smtp.yandex.ru', 'White Standard', 465);
            $headers= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\r\n";
            $headers .= "From: White Standard <noreply@".$baseCookieDomain.">\r\n";
            $mailSMTP->send($useremail, $email_subject, $email_body, $headers);
            
            return json_encode($results, JSON_UNESCAPED_UNICODE);
    
        }
        return json_encode(array("emailReset" => 0), JSON_UNESCAPED_UNICODE);
    
    }
    // USER PASSWORD CHANGE
    function passwordChange($oldpwd, $newpwd) {

        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $oldpwd = $this->hashword($oldpwd);
        $newpwd = $this->hashword($newpwd);
        $when = time();
    
        $q = "SELECT * FROM users WHERE user_id='$u' AND user_hash='$h'";
        $result = $this->dbquery($q);
        $results = odbc_fetch_array($result);
        $resrows = odbc_num_rows($result);
    
        if($resrows > 0) {

            $qpwd = "SELECT * FROM users WHERE user_id='$u' AND user_hash='$h' AND user_pwd='$oldpwd'";
            $resultpwd = $this->dbquery($qpwd);
            $resultspwd = odbc_fetch_array($resultpwd);
            $resrowspwd = odbc_num_rows($resultpwd);

            if($resrowspwd > 0) {
                $qupd = "UPDATE users SET user_pwd = '$newpwd' WHERE user_id = '$u'";
                $this->dbquery($qupd);
                return json_encode(array("success" => 1), JSON_UNESCAPED_UNICODE);
            }
            else {
                return json_encode(array("success" => 2), JSON_UNESCAPED_UNICODE);
            }
    
        }
        else {
            return json_encode(array("success" => 0), JSON_UNESCAPED_UNICODE);
        }
    
    }
    // USER DATA CHANGE
    function usrDataChange($name, $lastname, $mobile, $skype, $country, $city, $plz, $address) {

        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $when = time();
    
        $q = "SELECT * FROM users WHERE user_id='$u' AND user_hash='$h'";
        $result = $this->dbquery($q);
        $results = odbc_fetch_array($result);
        $resrows = odbc_num_rows($result);
    
        if($resrows > 0) {

            // $email = $this->hashword($email);
            // if($results['user_confirm'] == 1) {
            //     $email = $results['user_email'];
            // }
            if($results['user_adress_confirm'] == 1) {
                $country = $results['user_country'];
                $city = $results['user_city'];
                $plz = $results['user_postal'];
                $address = $results['user_adress'];
            }

            $qupd = "UPDATE users SET user_name = '$name', user_lastname='$lastname', user_mobile='$mobile', user_mobile_confirm='1', user_skype='$skype', user_country='$country', user_city='$city', user_postal='$plz', user_adress='$address' WHERE user_id='$u'";
            $this->dbquery($qupd);
            return json_encode(array("success" => 1), JSON_UNESCAPED_UNICODE);
    
        }
        else {
            return json_encode(array("success" => 0), JSON_UNESCAPED_UNICODE);
        }
    
    }
    // USER NOTES
    function usrNotes($usr, $notes) {
        if($this->checkLevel() != '0') {
            $q = "SELECT * FROM users WHERE user_id='$usr'";
            $result = $this->dbquery($q);
            $results = odbc_fetch_array($result);
            $resrows = odbc_num_rows($result);
        
            if($resrows > 0) {

                $qupd = "UPDATE users SET user_notes = '$notes' WHERE user_id='$usr'";
                $this->dbquery($qupd);
                return json_encode(array("success" => 1), JSON_UNESCAPED_UNICODE);
        
            }
            else {
                return json_encode(array("success" => 0), JSON_UNESCAPED_UNICODE);
            }
        }
    }
    // USER CHECK USER TYPE
    function checkLevel() {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $query = "SELECT * FROM users WHERE user_id = '$u' AND user_hash = '$h'";
            $checkUsr = $this->dbquery($query);
            $row = odbc_fetch_array($checkUsr);
            $rows = odbc_num_rows($checkUsr);

            if($rows > 0) {
                return $row['user_type'];
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }
    // LEVEL NAME
    function levelName($usertype) {
        switch($usertype) {
            case 0:
                return 'USER';
                break;
            case 1:
                return 'MANAGER';
                break;
            case 2:
                return 'MINTER';
                break;
            case 3:
                return 'KYCAML';
                break;
            default:
                return 'USER';
                break;
        }
    }
    // GET CLIENTS IP
    function get_client_ip_server() {
        $ipaddress = '';
        if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    }


    // USER DATA
    function getUser() {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $query = "SELECT * FROM users WHERE user_id = '$u' AND user_hash = '$h'";
            $checkUsr = $this->dbquery($query);
            $row = odbc_fetch_array($checkUsr);
            $rows = odbc_num_rows($checkUsr);

            if($rows > 0) {
                return $row;
            }
        }
    }
    // ADMIN USER DATA
    function getAdminUser($usr) {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $query = "SELECT * FROM users WHERE user_id = '$u' AND user_hash = '$h'";
            $checkUsr = $this->dbquery($query);
            $row = odbc_fetch_array($checkUsr);
            $rows = odbc_num_rows($checkUsr);

            if($rows > 0) {
                if($usr != $u) {
                    $queryCheck = "SELECT * FROM users WHERE user_id = '$usr'";
                    $checkOtherUsr = $this->dbquery($queryCheck);
                    $rowUsr = odbc_fetch_array($checkOtherUsr);
                    $rowsUsr = odbc_num_rows($checkOtherUsr);

                    if($rowsUsr > 0) {
                        return $rowUsr;
                    }
                }
                else {
                    return $row;
                }
            }
            else {
                return $row;
            }
        }
    }
    // BANK DATA
    function getBank() {
        $query = "SELECT * FROM bank";
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);

        if($rows > 0) {
            return $row;
        }
    }
    // GET TRANSACTIONS
    function getTransactions() {
        $u = $_COOKIE['u'];
        $query = "SELECT * FROM transactions WHERE userid = '$u' ORDER BY datetime DESC";
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);

        $tblobj = '';
        if($rows > 0) {
            $i = 0;
            do {
                $handleBtn = '&nbsp;';
                if($row['acception'] == 0) {
                    $handleBtn = '<button class="btn btn-warning">Pending</button>';
                }
                else if($row['acception'] == 1) {
                    $handleBtn = '<button class="btn btn-success">Aprofed</button>';
                }
                else if($row['acception'] == 2) {
                    $handleBtn = '<button class="btn btn-danger">Declined</button>';
                }
                else if($row['acception'] == 3) {
                    $handleBtn = '<button class="btn btn-danger">Declined</button>';
                }
                else if($row['acception'] == 4) {
                    $handleBtn = '<button class="btn btn-danger">Pending</button>';
                }
                else if($row['acception'] == 6) {
                    $handleBtn = '<button class="btn btn-danger">Declined</button>';
                }
                else if($row['acception'] == 7) {
                    $handleBtn = '<button class="btn btn-success">Aprofed</button>';
                }
                if($i%2 == 0) {
                    $tblobj .= '<tbody><tr class="even pointer">';
                    // $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$row['recid'].'</td>';
                    // $tblobj .= '<td>'.$row['userid'].'</td>';
                    $tblobj .= '<td>'.$row['amount_from'].' '.$this->getCurrency($row['currency_from']).'</td>';
                    $tblobj .= '<td>'.$row['amount_to'].' '.$this->getCurrency($row['currency_to']).'</td>';
                    $tblobj .= '<td>'.$row['commissions'].'</td>';
                    $tblobj .= '<td>'.$row['notes'].'</td>';
                    $tblobj .= '<td>'.$row['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$row['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y h:i A', $row['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                else {
                    $tblobj .= '<tbody><tr class="odd pointer">';
                    // $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$row['recid'].'</td>';
                    // $tblobj .= '<td>'.$row['userid'].'</td>';
                    $tblobj .= '<td>'.$row['amount_from'].' '.$this->getCurrency($row['currency_from']).'</td>';
                    $tblobj .= '<td>'.$row['amount_to'].' '.$this->getCurrency($row['currency_to']).'</td>';
                    $tblobj .= '<td>'.$row['commissions'].'</td>';
                    $tblobj .= '<td>'.$row['notes'].'</td>';
                    $tblobj .= '<td>'.$row['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$row['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y h:i A', $row['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                $i++;
            } while ($row = odbc_fetch_array($checkBank));
        }
        return $tblobj;
    }
    // GET TRANSACTIONS GRAPH
    function getTransactionsGraph() {
        $u = $_COOKIE['u'];
        $wallet = $this->getBalance(0)['recid'];
        $query = "SELECT * FROM transactions WHERE userid='$u' OR wallet_to='".$this->getBalance(0)['recid']."' ORDER BY datetime DESC, changed DESC";
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);

        $tblobj = array();
        if($rows > 0) {
            do {
                array_push($tblobj, $row);
            } while ($row = odbc_fetch_array($checkBank));
        }
        return json_encode($tblobj, JSON_UNESCAPED_UNICODE);
    }
    // GET INCOME TRANSACTIONS SUM
    function getIncomeTransactions() {
        $u = $_COOKIE['u'];
        $wcr = $this->getBalance(0)['recid'];
        $query = "SELECT * FROM transactions WHERE wallet_from!='0' AND wallet_from!='".$wcr."' AND wallet_to='".$wcr."' ORDER BY datetime DESC";
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);

        $amount = 0;
        if($rows > 0) {
            do {
                $amount += $row['amount_to'];
            } while ($row = odbc_fetch_array($checkBank));
        }
        return $amount;
    }
    // GET OUTGOING TRANSACTIONS SUM
    function getOutTransactions() {
        $u = $_COOKIE['u'];
        $wcr = $this->getBalance(0)['recid'];
        $query = "SELECT * FROM transactions WHERE wallet_to!='0' AND wallet_to!='".$wcr."' AND wallet_from='".$wcr."' ORDER BY datetime DESC";
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);
        
        $amount = 0;
        if($rows > 0) {
            do {
                $amount += $row['amount_from'];
            } while ($row = odbc_fetch_array($checkBank));
        }
        return $amount;
    }
    // GET TRANSACTION
    function getTransaction($transid) {
        $query = "SELECT * FROM transactions WHERE recid=".$transid;
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);

        if($rows > 0) {
            return $row;
        }
    }
    // LIST TRANSACTIONS MINT
    function mintGetTransactions($bankID) {
        $queryTrans = "SELECT * FROM transactions WHERE acception = '0' AND (wallet_from = '$bankID' OR wallet_to = '$bankID') ORDER BY datetime DESC";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        $tblobj = '';
        if($rowsTrans > 0) {
            $i = 0;
            do {
                $handleBtn = '&nbsp;';
                if($rowTrans['acception'] == 0) {
                    $handleBtn = '<button class="btn btn-warning">Pending</button>';
                }
                else if($rowTrans['acception'] == 1) {
                    $handleBtn = '<button class="btn btn-success">Aprofed</button>';
                }
                else if($rowTrans['acception'] == 2) {
                    $handleBtn = '<button class="btn btn-danger">Declined</button>';
                }
                if($i%2 == 0) {
                    $tblobj .= '<tbody><tr class="even pointer">';
                    // $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                else {
                    $tblobj .= '<tbody><tr class="odd pointer">';
                    // $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                $i++;
            } while ($rowTrans = odbc_fetch_array($checkTrans));
        }
        return $tblobj;
    }
    // MINTER PROOF TRANSACTION
    function minterProof($recID, $amount, $fromadr) {
        $when = time();
        
        $queryTrans = "SELECT * FROM transactions WHERE recid = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            if($amount == 0) {
                $updTrans = "UPDATE transactions SET acception='3', transdel='1', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
            }
            else if($fromadr != '' && $fromadr != '-1') {
                $updTrans = "UPDATE transactions SET acception='4', transdel='0', mintreq='$fromadr', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
            }
            else {
                $updTrans = "UPDATE transactions SET acception='4', transdel='0', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
            }
        }
    }
    // USER PROOF TRANSACTION
    function userProof($recID, $amount) {
        
        $queryTrans = "SELECT * FROM transactions WHERE recid = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            $delTrans = "DELETE FROM transactions WHERE recid='$recID'";
            $this->dbquery($delTrans);
        }
    }
    // ADMIN PROOF TRANSACTION
    function adminProof($recID, $amount) {
        $when = time();
        
        $queryTrans = "SELECT * FROM transactions WHERE recid = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            if($amount == 0) {
                $updTrans = "UPDATE transactions SET acception='6', transdel='1', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
                return 1;
            }
            else {
                $updTrans = "UPDATE transactions SET acception='7', transdel='0', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);

                $queryWallet = "SELECT * FROM wallets WHERE type='0' AND userid='".$rowTrans['userid']."'";
                $checkWallet = $this->dbquery($queryWallet);
                $rowWallet = odbc_fetch_array($checkWallet);
                $rowsWallet = odbc_num_rows($checkWallet);
                
                if($rowsWallet > 0) {
                    if($rowTrans['currency_from'] == '0') {
                        $newAmount = $rowWallet['amount'] - $rowTrans['amount_from'];
                    }
                    else {
                        $amountTo = $rowTrans['amount_to'];
                        if($rowTrans['notes'] == 'Request BTC to WCR') {
                            $amountTo = $amount;
                        }
                        $newAmount = $rowWallet['amount'] + $amountTo;
                    }

                    $updWallet = "UPDATE wallets SET amount='$newAmount', datetime='$when' WHERE type='0' AND userid='".$rowTrans['userid']."'";
                    $this->dbquery($updWallet);
                    return 1;
                }
                else {
                    return 0;
                }
            }
        }
    }
    // ADMIN PROOF TRANSACTION WCR TO WCUR
    function adminProof2($recID, $amount) {
        $when = time();
        
        $queryTrans = "SELECT * FROM transactions WHERE recid = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            if($amount == 0) {
                $updTrans = "UPDATE transactions SET acception='6', transdel='1', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
                return 0;
            }
            else {
                $updTrans = "UPDATE transactions SET acception='0', transdel='0', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);

                $queryWallet = "SELECT * FROM wallets WHERE type='0' AND userid='".$rowTrans['userid']."'";
                $checkWallet = $this->dbquery($queryWallet);
                $rowWallet = odbc_fetch_array($checkWallet);
                $rowsWallet = odbc_num_rows($checkWallet);
                
                if($rowsWallet > 0) {
                    // if($rowTrans['currency_from'] == '0') {
                    //     $newAmount = $rowWallet['amount'] - $rowTrans['amount_from'];
                    // }
                    // else {
                    //     $newAmount = $rowWallet['amount'] + $rowTrans['amount_to'];
                    // }

                    // $updWallet = "UPDATE wallets SET amount='$newAmount', datetime='$when' WHERE type='0' AND userid='".$rowTrans['userid']."'";
                    // $this->dbquery($updWallet);
                    return 1;
                }
                else {
                    return 0;
                }
            }
        }
    }
    // LIST TRANSACTIONS ADMIN
    function adminGetTransactions() {
        $queryTrans = "SELECT * FROM transactions ORDER BY datetime DESC";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        $tblobj = '';
        if($rowsTrans > 0) {
            $i = 0;
            do {
                $handleBtn = '&nbsp;';
                if($rowTrans['acception'] == 0) {
                    $handleBtn = '<button class="btn btn-success" onclick="permitTrans(\''.$rowTrans['recid'].'\')">Permit</button><button class="btn btn-danger" onclick="refuseTrans(\''.$rowTrans['recid'].'\')">Refuse</button>';
                }
                else if($rowTrans['acception'] == 1) {
                    $handleBtn = '<button class="btn btn-success">Aprofed</button>';
                }
                else if($rowTrans['acception'] == 2) {
                    $handleBtn = '<button class="btn btn-danger">Declined</button>';
                }
                if($i%2 == 0) {
                    $tblobj .= '<tbody><tr class="even pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                else {
                    $tblobj .= '<tbody><tr class="odd pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                $i++;
            } while ($rowTrans = odbc_fetch_array($checkTrans));
        }
        return $tblobj;
    }
    // GET SITE ENDING
    function siteTitle() {
        $link = $_SERVER['PHP_SELF'];
        $link_array = explode('/',$link);
        $page = end($link_array);

        switch($page) {
            case 'index.php':
                echo 'index';
                break;
            default:
                echo 'xxx';
                break;
        }
    }
    // GET BALANCE
    function getBalance($type) {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $query = "SELECT * FROM wallets WHERE userid = '$u' AND type='$type'";
            $checkWallet = $this->dbquery($query);
            $row = odbc_fetch_array($checkWallet);
            $rows = odbc_num_rows($checkWallet);
            if($rows > 0) {
                return $row;
            }
        }
    }
    // MAKE PRIVATE TRANSACTION
    function makeTransaction($from, $to, $amount, $notes) {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $queryCheck = "SELECT * FROM wallets WHERE recid = '$from' AND userid = '$u' AND amount >= '$amount'";
            $checkWalletFrom = $this->dbquery($queryCheck);
            $rowFrom = odbc_fetch_array($checkWalletFrom);
            $rowsFrom = odbc_num_rows($checkWalletFrom);

            if($rowsFrom > 0) {

                $queryWallet = "SELECT * FROM wallets WHERE recid = '$to'";
                $checkWalletFrom = $this->dbquery($queryWallet);
                $rowFromWallet = odbc_fetch_array($checkWalletFrom);
                $rowsFromWallet = odbc_num_rows($checkWalletFrom);

                if($rowsFromWallet > 0) {

                    $recAmount = $amount;
                    $commissions = 0;
                    $when = time();
                    $recID = $this->createRecordID();
                    $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', '".$rowFrom['type']."', '$recAmount', '".$rowFrom['type']."', '$notes', 0, '$when', 0, 0, 0, '$from', '$to', '$commissions')";
                    $this->dbquery($queryTrans);

                    $newAmount = $rowFromWallet['amount']+$recAmount;
                    $querySet = "UPDATE wallets SET amount = '$newAmount', datetime = '$when' WHERE recid = '$to'";
                    $this->dbquery($querySet);

                    $newAmount2 = $rowFrom['amount']-$amount;
                    $querySet2 = "UPDATE wallets SET amount = '$newAmount2', datetime = '$when' WHERE recid = '$from'";
                    $this->dbquery($querySet2);

                    $this->commissionsToBank($this->getBank()['recid'], $from, $commissions);

                    return 1;

                }
                else {
                    return 2;
                }

            }
            else {
                return 0;
            }
        }
    }
    // SEND WHITECOINS UNRESTRICTED
    function coinSendUR($from, $to, $amount, $notes) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        // if($this->getBalance(1)['amount'] >= $amount) {
            $when = time();
            $recID = $this->createRecordID();
            $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 3, '$amount', 3, '$notes', 0, '$when', 7, 0, 0, '$from', '$to', '0')";
            $this->dbquery($queryTrans);

            $this->sendMail($this->getUser()['user_email'], $recID, $amount, 3);

            return 1;
        // }
        // else {
        //     return 0;
        // }
    }
    // ADMIN CONFIRM TRANSACTION
    function adminConfirmTransaction($recID, $confirm) {
        $queryTrans = "SELECT * FROM transactions WHERE recid = '$recID' AND acception = '0'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            $queryTo = "SELECT * FROM wallets WHERE recid = '".$rowTrans['wallet_from']."' AND userid = '".$rowTrans['userid']."'";
            $checkWalletTo = $this->dbquery($queryTo);
            $rowTo = odbc_fetch_array($checkWalletTo);
            $rowsTo = odbc_num_rows($checkWalletTo);

            if($rowsTo > 0) {
                $newAmount = $rowTo['amount']+$rowTrans['amount_to'];
                $querySet = "UPDATE wallets SET amount = '$newAmount' WHERE recid = '".$rowTrans['wallet_to']."'";
                $this->dbquery($querySet);
            }
        }
    }
    // UPLOAD FILE
    function uploadFile($filename, $doctype) {
        $recId = $this->createRecordID();
        $u = $_COOKIE['u'];
        $when = time();
        $query = "INSERT INTO documents (recid, userid, doctype, datetime, docdel, confirmed, confdatetime, docurl) VALUES ('$recId', '$u', '$doctype', '$when', '0', '0', '0', '$filename')";
        $this->dbquery($query);
    }
    // LIST WALLETS
    function adminGetWallets() {
        $queryWallet = "SELECT * FROM wallets WHERE type = '0' ORDER BY datetime DESC";
        $checkWallet = $this->dbquery($queryWallet);
        $rowWallet = odbc_fetch_array($checkWallet);
        $rowsWallet = odbc_num_rows($checkWallet);

        $tblobj = '';
        if($rowsWallet > 0) {
            $i=0;
            do {
                if($i%2 == 0) {
                    $tblobj .= '<tbody><tr class="even pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowWallet['recid'].'</td>';
                    $tblobj .= '<td>'.$rowWallet['userid'].'</td>';
                    $tblobj .= '<td><i class="fa fa-krw"></i> WTR</td>';
                    $tblobj .= '<td>'.$rowWallet['amount'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowWallet['datetime']).'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                else {
                    $tblobj .= '<tbody><tr class="odd pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowWallet['recid'].'</td>';
                    $tblobj .= '<td>'.$rowWallet['userid'].'</td>';
                    $tblobj .= '<td><i class="fa fa-krw"></i> WTR</td>';
                    $tblobj .= '<td>'.$rowWallet['amount'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowWallet['datetime']).'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                $i++;
            } while ($rowWallet = odbc_fetch_array($checkWallet));
        }
        return $tblobj;
    }
    // GET BANK
    function adminGetBank() {
        $queryBank = "SELECT * FROM bank";
        $checkBank = $this->dbquery($queryBank);
        $rowBank = odbc_fetch_array($checkBank);
        $rowsBank = odbc_num_rows($checkBank);
        if($rowsBank > 0) {
            return $rowBank;
        }
    }
    // CHECK CURRENCY
    function getCurrency($val) {
        switch ($val) {
            case 0: return 'WCR';
                break;
            case 1: return 'WCUR';
                break;
            case 2: return 'BTC';
                break;
            case 3: return 'ETH';
                break;
            case 5: return 'USD';
                break;
            default: return 'WCR';
                break;
        }
    }
    // GET BANK TRANSACTIONS
    function adminGetBankTransactions($recId) {
        $queryTrans = "SELECT * FROM transactions WHERE wallet_from = '$recId' OR wallet_to = '$recId' ORDER BY datetime DESC";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        $tblobj = '';
        if($rowsTrans > 0) {
            $i=0;
            do {
                if($i%2 == 0) {
                    $tblobj .= '<tbody><tr class="even pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                else {
                    $tblobj .= '<tbody><tr class="odd pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                $i++;
            } while ($rowTrans = odbc_fetch_array($checkTrans));
        }
        return $tblobj;
    }
    // ADD TO BANK
    function adminCoinCreate($bankID, $amount) {
        $queryBank = "SELECT * FROM bank WHERE recid = '$bankID'";
        $checkBank = $this->dbquery($queryBank);
        $rowBank = odbc_fetch_array($checkBank);
        $rowsBank = odbc_num_rows($checkBank);

        if($rowsBank > 0) {
            $when = time();
            $recID = $this->createRecordID();
            $u = $_COOKIE['u'];
            $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$amount', 0, 'Coin Create', 0, '$when', 1, 0, 0, '$bankID', '$bankID', 0)";
            $this->dbquery($queryTrans);

            $newAmount = $rowBank['amount']+$amount;
            $querySet = "UPDATE bank SET amount = '$newAmount', datetime = '$when' WHERE recid = '$bankID'";
            $this->dbquery($querySet);

            return $newAmount;

        }
        else {
            return 'no wallet';
        }
    }
    // REMOVE FROM BANK
    function adminCoinRemove($bankID, $amount) {
        $queryBank = "SELECT * FROM bank WHERE recid = '$bankID'";
        $checkBank = $this->dbquery($queryBank);
        $rowBank = odbc_fetch_array($checkBank);
        $rowsBank = odbc_num_rows($checkBank);

        if($rowsBank > 0) {
            if($amount <= $rowBank['amount']) {
                $when = time();
                $recID = $this->createRecordID();
                $u = $_COOKIE['u'];
                $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$amount', 0, 'Coin Destroy', 0, '$when', 1, 0, 0, '$bankID', 0, 0)";
                $this->dbquery($queryTrans);

                $newAmount = $rowBank['amount']-$amount;
                $querySet = "UPDATE bank SET amount = '$newAmount', datetime = '$when' WHERE recid = '$bankID'";
                $this->dbquery($querySet);

                return $newAmount;
            }
            else {
                return 'no money';
            }
        }
    }
    // COMMISSIONS TO BANK
    function commissionsToBank($bankID, $from, $amount) {
        $queryBank = "SELECT * FROM bank WHERE recid = '$bankID'";
        $checkBank = $this->dbquery($queryBank);
        $rowBank = odbc_fetch_array($checkBank);
        $rowsBank = odbc_num_rows($checkBank);

        if($rowsBank > 0) {
            $when = time();
            $recID = $this->createRecordID();
            $u = $_COOKIE['u'];
            $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$amount', 0, 'Commissions', 0, '$when', 1, 0, 0, '$from', '$bankID', 0)";
            $this->dbquery($queryTrans);

            $newAmount = $rowBank['amount']+$amount;
            $querySet = "UPDATE bank SET amount = '$newAmount', datetime = '$when' WHERE recid = '$bankID'";
            $this->dbquery($querySet);

            return $newAmount;
        }
        else {
            return 'no wallet';
        }
    }
    // MAKE ADMIN TRANSACTION
    function adminMakeTransaction($from, $to, $amount, $notes) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $queryCheck = "SELECT * FROM bank WHERE recid = '$from' AND amount >= '$amount'";
        $checkBankFrom = $this->dbquery($queryCheck);
        $rowFrom = odbc_fetch_array($checkBankFrom);
        $rowsFrom = odbc_num_rows($checkBankFrom);

        if($rowsFrom > 0) {

            $queryWallet = "SELECT * FROM wallets WHERE recid = '$to'";
            $checkWalletFrom = $this->dbquery($queryWallet);
            $rowFromWallet = odbc_fetch_array($checkWalletFrom);
            $rowsFromWallet = odbc_num_rows($checkWalletFrom);

            if($rowsFromWallet > 0) {
                
                $when = time();
                $recID = $this->createRecordID();
                $u = $_COOKIE['u'];
                $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$amount', 0, '$notes', 0, '$when', 1, 0, 0, '$from', '$to', 0)";
                $this->dbquery($queryTrans);

                $newAmount = $rowFromWallet['amount']+$amount;
                $querySet = "UPDATE wallets SET amount = '$newAmount', datetime = '$when' WHERE recid = '$to'";
                $this->dbquery($querySet);

                $newAmount2 = $rowFrom['amount']-$amount;
                $querySet2 = "UPDATE bank SET amount = '$newAmount2', datetime = '$when' WHERE recid = '$from'";
                $this->dbquery($querySet2);

                return $newAmount2;

            }
            else {
                return 'no wallet';
            }
        }
        else {
            return 'no money';
        }
    }
    // GET EXCHANGE RATES
    function getExchangeRate($currency1, $currency2) {
        $queryExchange = "SELECT * FROM exchange WHERE currency1 = '$currency1' AND currency2 = '$currency2'";
        $checkExchange = $this->dbquery($queryExchange);
        $row = odbc_fetch_array($checkExchange);
        $rows = odbc_num_rows($checkExchange);
        if($rows > 0) {
            return $row;
        }
    }
    // REQUEST WHITECOINS
    function coinRequest($bankID, $amount, $notes, $state) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $when = time();
        $recID = $this->createRecordID();
        $recamount = $amount / $this->getExchangeRate('USD', 'WCR')['amount1'];
        // GENERATE BANKWIRE CODE
        $user = $this->getUser();
        $transid = '';

        // initials
        $initials = 'XX';
        if(isset($user['user_name']) && $user['user_name'] != '') {
            $initials = substr($user['user_name'], 0, 1);
            if(isset($user['user_lastname']) && $user['user_lastname'] != '') {
                $initials .= substr($user['user_lastname'], 0, 1);
            }
        }

        // transnum
        $daybegin = mktime(0,0,0, date("m", $when), date("d", $when), date("Y", $when));
        $dayend = mktime(23,59,59, date("m", $when), date("d", $when), date("Y", $when));
        $queryLastTrans = "SELECT * FROM transactions WHERE datetime > '$daybegin' AND datetime <= '$dayend'";
        $checkLastTrans = $this->dbquery($queryLastTrans);
        $rowLastTrans = odbc_fetch_array($checkLastTrans);
        $rowsLastTrans = odbc_num_rows($checkLastTrans);
        $transnum = '000000';
        $nexttrans = $rowsLastTrans+1;
        $transcnt = strlen($nexttrans);
        $transnum = substr_replace($transnum, $nexttrans, -$transcnt);

        // date
        $datetoday = date('mdy', $when);

        $transid = (string)$initials . (string)$transnum . (string)$datetoday . (string)$this->createBankWireID();

        $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions, state, transid) VALUES ('$recID', '$u', '$amount', 5, '$recamount', 0, '$notes', 0, '$when', 0, 0, 0, '$bankID', '$u', 0, '$state', '$transid')";
        $this->dbquery($queryTrans);

        $this->sendMail($this->getUser()['user_email'], $recID, $amount, 0);
        return 1;
    }
    // SELL REQUEST WHITECOINS
    function coinSell($bankID, $amount, $notes) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        if($this->getBalance(0)['amount'] >= $amount) {
            $when = time();
            $recID = $this->createRecordID();
            $recamount = $amount * $this->getExchangeRate('USD', 'WCR')['amount1'];
            $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$recamount', 5, '$notes', 0, '$when', 0, 0, 0, '$u', '$bankID', 0)";
            $this->dbquery($queryTrans);

            $this->sendMail($this->getUser()['user_email'], $recID, $amount, 5);

            return 1;
        }
        else {
            return 0;
        }
    }
    // REQUEST WHITECOINS UNRESTRICTED
    function coinRequestUR($bankID, $amount, $notes) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $when = time();
        $recID = $this->createRecordID();
        $recamount = $amount / $this->getExchangeRate('ETH', 'WCUR')['amount1'];
        $commissions = $recamount*0.05;
        $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 3, '$recamount', 1, '$notes', 0, '$when', 7, 0, 0, '$bankID', '$u', '$commissions')";
        $this->dbquery($queryTrans);

        $this->sendMail($this->getUser()['user_email'], $recID, $amount, 1);
    }
    // REQUEST WHITECOINS SELLING BITCOINS
    function coinRequestBTC($bankID, $amount, $notes, $state, $fromadr) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $when = time();
        $recID = $this->createRecordID();
        $fee = str_replace(',', '.', $this->getFee('BTC', 'WCR')['fee']);
        $recamount = $amount / 100;
        $recamount = $recamount * (100 - $fee);
        // GENERATE BANKWIRE CODE
        $user = $this->getUser();
        $transid = '';
        $toadr = $this->getBalance(0)['recid'];

        // initials
        $initials = 'XX';
        if(isset($user['user_name']) && $user['user_name'] != '') {
            $initials = substr($user['user_name'], 0, 1);
            if(isset($user['user_lastname']) && $user['user_lastname'] != '') {
                $initials .= substr($user['user_lastname'], 0, 1);
            }
        }

        $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions, state) VALUES ('$recID', '$u', '$amount', 2, '$recamount', 2, '$notes', 0, '$when', 0, 0, 0, '$fromadr', '$u', '$fee', '$state')";
        $this->dbquery($queryTrans);

        return 1;
    }
    // SELL REQUEST WHITECOINS TO GET BITCOINS
    // function coinSellBTC($bankID, $amount, $notes) {
    //     $u = $_COOKIE['u'];
    //     $h = $_COOKIE['h'];
    //     if($this->getBalance(0)['amount'] >= $amount) {
    //         $when = time();
    //         $recID = $this->createRecordID();
    //         $recamount = $amount * $this->getExchangeRate('USD', 'WCR')['amount1'];
    //         $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$recamount', 5, '$notes', 0, '$when', 0, 0, 0, '$u', '$bankID', 0)";
    //         $this->dbquery($queryTrans);

    //         $this->sendMail($this->getUser()['user_email'], $recID, $amount, 5);

    //         return 1;
    //     }
    //     else {
    //         return 0;
    //     }
    // }
    // RESTRICTED TO UNRESTRICTED WHITECOIN
    function wcrtoWcur($amount) {
        $u = $_COOKIE['u'];
        $when = time();
        $recID = $this->createRecordID();
        // $accFrom = $this->getBalance(1)['recid'];
        $accFrom = $this->getBank()['recid'];
        $accTo = $this->getBalance(3)['wallet_minter'];
        $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$amount', 1, 'WCR to WCUR', 0, '$when', 0, 0, 0, '$accFrom', '$accTo', '0')";
        $this->dbquery($queryTrans);
        $this->sendMail($this->getUser()['user_email'], $recID, $amount, 3);
        return 1;
    }
    // REQUEST WHITECOINS UNRESTRICTED
    function coinSellUR($bankID, $amount, $notes) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        if($this->getBalance(1)['amount'] >= $amount) {
            $when = time();
            $recID = $this->createRecordID();
            $recamount = $amount * $this->getExchangeRate('ETH', 'WCUR')['amount1'];
            $commissions = $recamount*0.05;
            $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 1, '$recamount', 3, '$notes', 0, '$when', 7, 0, 0, '$u', '$bankID', '$commissions')";
            $this->dbquery($queryTrans);

            $this->sendMail($this->getUser()['user_email'], $recID, $amount, 3);

            return 1;
        }
        else {
            return 0;
        }
    }
    // DOCUMENT PROOFED
    function docProof($recID, $amount) {
        $when = time();
        
        $queryTrans = "SELECT * FROM documents WHERE recid = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            if($amount == 2) {
                $updTrans = "UPDATE documents SET confirmed='2', confdatetime='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
                return 1;
            }
            else if($amount == 1) {
                $updTrans = "UPDATE documents SET confirmed='1', confdatetime='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);

                $queryUser = "SELECT * FROM users WHERE user_id='".$rowTrans['userid']."'";
                $checkUser = $this->dbquery($queryUser);
                $rowUser = odbc_fetch_array($checkUser);
                $rowsUser = odbc_num_rows($checkUser);
                
                if($rowsUser > 0) {
                    if($rowTrans['doctype'] == 'mobile') {
                        $updUsers = "UPDATE users SET user_mobile_confirm ='1' WHERE user_id='".$rowTrans['userid']."'";
                        $this->dbquery($updUsers);
                        return 1;
                    }
                    else if($rowTrans['doctype'] == 'address') {
                        $updUsers = "UPDATE users SET user_adress_confirm ='1' WHERE user_id='".$rowTrans['userid']."'";
                        $this->dbquery($updUsers);
                        return 1;
                    }
                    else if($rowTrans['doctype'] == 'passport') {
                        $updUsers = "UPDATE users SET user_passport_confirm ='1' WHERE user_id='".$rowTrans['userid']."'";
                        $this->dbquery($updUsers);
                        return 1;
                    }
                    else {
                        return 'no doctype';
                    }
                }
                else {
                    return 'no user';
                }
            }
            else {
                return 'no handler';
            }
        }
        else {
            return 'no doc';
        }
    }
    // CHECK CONFIRMED DOCS
    function getDocsConfirmed($doctype, $usr) {
        $queryTrans = "SELECT * FROM documents WHERE userid = '$usr' AND doctype='$doctype' ORDER BY datetime DESC";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            return $rowTrans['confirmed'];
        }
        else {
            return 'no doc';
        }
    }
    // SEND EMAIL
    function sendMail($email, $recId, $amount, $currency) {

        $currency = $this->getCurrency($currency);

        // SEND EMAIL TO NEW USER
        $email_subject = "White Standard token request.";
        $email_body = '<html style="width:100%;height:100%;"><body style="background-color:rgba(106, 164, 203, 1);width:100%;height:100%;">';
        $email_body .= '<div style="text-align:center;"><img style="margin:10px auto;height:60px;" src="http://whitecoin.blockchaindevelopers.org/images/logo.png" alt="White Standard" /></div>';
        $email_body .= '<div style="margin:30px;padding:20px;background-color:#fff;text-align:center;">';
        $email_body .= '<h2 style="text-align:left;">Token request</h2>';
        $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">Request <strong>White Standard</strong></h2>';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">Please make a wire transfer to the following bank account:</h2>';
        $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
        $email_body .= '<p style="text-align:left;font-weight:normal;">Bank account: 1234567890</p>';
        $email_body .= '<p style="text-align:left;font-weight:normal;">Amount in '.$currency.': '.$amount.'</p>';
        $email_body .= '<p style="text-align:left;font-weight:normal;">Purpose of payment: White Standard purchase - '.$recId.'</p>';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">For questions please contact:</h2><div style="text-align:left;"><a style="text-align:left;font-weight:bold;font-size:18px;" href="mailto:info@whitecoin.blockchaindevelopers.org">info@whitecoin.blockchaindevelopers.org</a></div>';
        $email_body .= '<br/><br/><br/><h4 style="color:#999;text-align:left;font-weight:normal;margin-bottom:0px;">White Standard Team</h4><br/>';
        $email_body .= '<h4 style="color:#888;text-align:left;font-weight:normal;margin-top:0px;">Automated message. Please do not reply.</h4>';
        $email_body .= '<a style="text-decoration:none;font-weight:normal;color:#3C8DC8;font-size:1.5em;" href="http://whitecoin.blockchaindevelopers.org/" target="_blank">http://whitecoin.blockchaindevelopers.org/</a>';
        $email_body .= '</div><br/></body"></html>';
    
        require_once "SendMailSmtpClass.php";
        $mailSMTP = new SendMailSmtpClass('xanatosdark@yandex.ru', 'Vivanco2!', 'ssl://smtp.yandex.ru', 'BlockSave', 465);
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: White Standard <noreply@whitecoin.blockchaindevelopers.org>\r\n";
        $mailSMTP->send($email, $email_subject, $email_body, $headers);
    
    }
    // DELETE MINTER
    function minterDel($recID) {
        $queryTrans = "SELECT * FROM users WHERE user_id = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            $delUser = "DELETE FROM users WHERE user_id='$recID'";
            $this->dbquery($delUser);
            $queryDelMinter = "DELETE FROM wallets WHERE userid='$recID'";
            $this->dbquery($queryDelMinter);
            return 1;
        }
        else {
            return 0;
        }
    }
    // SET ETHEREUM WALLET
    function setEthWallet($ethwallet) {
        $u = $_COOKIE['u'];
        $updWallet = "UPDATE wallets SET wallet_minter='$ethwallet' WHERE type='3' AND userid='$u'";
        $this->dbquery($updWallet);
    }
    // TOGGLE MINTER RESTRICTION
    function minterRest($amnt, $to, $fromadr) {
        if($amnt == 0) {
            $updUser = "UPDATE users SET user_minter='0' WHERE user_id='$fromadr'";
            $this->dbquery($updUser);
        }
        else if($amnt == 1) {
            $queryWallet = "SELECT * FROM wallets WHERE userid='$fromadr' AND type='3'";
            $checkWallet = $this->dbquery($queryWallet);
            $rowWallet = odbc_fetch_array($checkWallet);
            $rowsWallet = odbc_num_rows($checkWallet);
            if($rowsWallet > 0) {
                $updUser = "UPDATE users SET user_minter='".$rowWallet['wallet_minter']."' WHERE user_id='$fromadr'";
                $this->dbquery($updUser);
            }
        }
    }
    // GET FEE
    function getFee($from, $to) {
        $query = "SELECT * FROM fee WHERE currfrom = '$from' AND currto='$to'";
        $checkFee = $this->dbquery($query);
        $row = odbc_fetch_array($checkFee);
        $rows = odbc_num_rows($checkFee);
        if($rows > 0) {
            return $row;
        }
    }
    // SET FEE
    function setFee($from, $to, $percent) {
        
        $when = time();

        $query = "SELECT * FROM fee WHERE currfrom = '$from' AND currto='$to'";
        $checkFee = $this->dbquery($query);
        $row = odbc_fetch_array($checkFee);
        $rows = odbc_num_rows($checkFee);
        if($rows > 0) {
            $queryUpd = "UPDATE fee SET fee='$percent', datetime='$when' WHERE recid='".$row['recid']."'";
            $this->dbquery($queryUpd);
            return 1;
        }
        else {
            $recID = $this->createRecordID();
            $queryIns = "INSERT INTO fee (recid, currfrom, currto, fee, datetime) VALUES ('$recID', '$from', '$to', '".$percent."', '$when')";
            $this->dbquery($queryIns);
            return 1;
        }
        
    }
    // LIST FEES
    function listFee() {
        $query = "SELECT * FROM fee";
        $checkFee = $this->dbquery($query);
        $row = odbc_fetch_array($checkFee);
        $rows = odbc_num_rows($checkFee);
        $result = '';
        if($rows > 0) {
            do {
                $result .= '<tr>
                <td>'.$this->currName($row['currfrom']).'</td>
                <td>'.$this->currName($row['currto']).'</td>
                <td>'.$row['fee'].'%</td></tr>';
            } while ($row = odbc_fetch_array($checkFee));
        }
        return $result;
    }
    // GET EXCHANGE RATES
    function getRates() {
        $lasttime = time() - 600;
        $queryCheck = "SELECT * FROM exchange WHERE currency1 != 'WCR' AND currency2 != 'WCR' AND currency1 != 'WCUR' AND currency2 != 'WCUR' AND datetime <= '$lasttime' ORDER BY datetime DESC";
        $checkRates = $this->dbquery($queryCheck);
        $rowFrom = odbc_fetch_array($checkRates);
        $rowsFrom = odbc_num_rows($checkRates);

        if($rowsFrom > 0) {
            
        }
        else {
            $when = time();
            $recID = $this->createRecordID();
            $queryTrans = "INSERT INTO exchange (recid, amount1, amount2, currency1, currency2, datetime) VALUES ('$recID', '$u', '$amount', '".$rowFrom['type']."', '$recAmount', '".$rowFrom['type']."', '$notes', 0, '$when', 0, 0, 0, '$from', '$to', '$commissions')";
            $this->dbquery($queryTrans);
        }

    }
    // MAKE EXCHANGE
    function makeExchange($from, $to, $amount, $notes) {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $queryCheck = "SELECT * FROM wallets WHERE recid = '$from' AND userid = '$u' AND amount >= '$amount'";
            $checkWalletFrom = $this->dbquery($queryCheck);
            $rowFrom = odbc_fetch_array($checkWalletFrom);
            $rowsFrom = odbc_num_rows($checkWalletFrom);

            if($rowsFrom > 0) {

                $queryWallet = "SELECT * FROM wallets WHERE recid = '$to'";
                $checkWalletFrom = $this->dbquery($queryWallet);
                $rowFromWallet = odbc_fetch_array($checkWalletFrom);
                $rowsFromWallet = odbc_num_rows($checkWalletFrom);

                if($rowsFromWallet > 0) {

                    $recAmount = $amount*0.95;
                    $commissions = $amount*0.05;
                    $when = time();
                    $recID = $this->createRecordID();
                    $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', '".$rowFrom['type']."', '$recAmount', '".$rowFrom['type']."', '$notes', 0, '$when', 0, 0, 0, '$from', '$to', '$commissions')";
                    $this->dbquery($queryTrans);

                    $newAmount = $rowFromWallet['amount']+$recAmount;
                    $querySet = "UPDATE wallets SET amount = '$newAmount', datetime = '$when' WHERE recid = '$to'";
                    $this->dbquery($querySet);

                    $newAmount2 = $rowFrom['amount']-$amount;
                    $querySet2 = "UPDATE wallets SET amount = '$newAmount2', datetime = '$when' WHERE recid = '$from'";
                    $this->dbquery($querySet2);

                    $this->commissionsToBank($this->getBank()['recid'], $from, $commissions);

                    return 1;

                }
                else {
                    return 2;
                }

            }
            else {
                return 0;
            }
        }
    }
    // CURRENCY NAME
    function currName($name) {
        $realName = '';
        switch($name) {
            case 'WCR':
                $realName = 'White Standard Restricted';
                break;
            case 'WCUR':
                $realName = 'White Standard Unrestricted';
                break;
            case 'ETH':
                $realName = 'Ethereum';
                break;
            case 'BTC':
                $realName = 'Bitcoin';
                break;
            case 'USD':
                $realName = 'USD';
                break;
            case 'BA':
                $realName = 'Bank wire';
                break;
            case 'CC':
                $realName = 'Credit Card';
                break;
            case 'CA':
                $realName = 'ACH';
                break;
            default:
                $realName = '';
                break;
        }
        return $realName;
    }
    // SET QUOTE
    function setQuote($amount) {
        
        $when = time();

        $query = "SELECT * FROM exchange WHERE currency1='USD' AND currency2='WCR'";
        $checkFee = $this->dbquery($query);
        $row = odbc_fetch_array($checkFee);
        $rows = odbc_num_rows($checkFee);
        if($rows > 0) {
            $queryUpd = "UPDATE exchange SET amount1='$amount', datetime='$when' WHERE currency1='USD' AND currency2='WCR'";
            $this->dbquery($queryUpd);
            return 1;
        }
        else {
            $recID = $this->createRecordID();
            $queryIns = "INSERT INTO exchange (recid, amount1, amount2, currency1, currency2, datetime) VALUES ('$recID', '$amount', '1', 'USD', 'WCR', '$when')";
            $this->dbquery($queryIns);
            return 1;
        }
        
    }

}

?>