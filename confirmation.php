<?php

include 'conns/whiteauth.php';

$baseDomain = 'http://whitecoin.blockchaindevelopers.org';
$baseCookieDomain = 'whitecoin.blockchaindevelopers.org';

// CONFIRM EMAIL
if(isset($_GET['confirm'])) {
    if($_GET['confirm'] == 'success') {
        $email_subject = "Email confirmation from ".$baseCookieDomain.".";
        $email_body = '<html style="width:100%;height:100%;"><head><script>setTimeout(function(){window.location.href="'.$baseDomain.'";},2000);</script></head><body style="background-color:#E0F1FF;width:100%;height:100%;">';
        $email_body .= '<div style="text-align:center;"><img style="margin:10px auto;height:60px;" src="'.$baseDomain.'/images/logo.png" alt="White Standard" /></div>';
        $email_body .= '<div style="margin:30px;padding:20px;background-color:#fff;">';
        $email_body .= '<h2 style="text-align:left;">Email confirmation</h2>';
        $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">Congratulations - Email confirmed! You will be redirected now..</h2>';
        $email_body .= '<br/><br/><br/><h4 style="color:#999;text-align:left;font-weight:normal;margin-bottom:0px;">White Standard Team</h4>';
        $email_body .= '</div></body"></html>';
    
        echo $email_body;
    }
    else if($_GET['confirm'] == 'error') {
        $email_subject = "Email confirmation from ".$baseCookieDomain.".";
        $email_body = '<html style="width:100%;height:100%;"><head><script>setTimeout(function(){window.location.href="'.$baseDomain.'";},2000);</script></head><body style="background-color:#E0F1FF;width:100%;height:100%;">';
        $email_body .= '<div style="text-align:center;"><img style="margin:10px auto;height:60px;" src="'.$baseDomain.'/images/logo.png" alt="White Standard" /></div>';
        $email_body .= '<div style="margin:30px;padding:20px;background-color:#fff;">';
        $email_body .= '<h2 style="text-align:left;">Email confirmation</h2>';
        $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;color:#f00;">Email confirmation failed!! You will be redirected now..</h2>';
        $email_body .= '<br/><br/><br/><h4 style="color:#999;text-align:left;font-weight:normal;margin-bottom:0px;">White Standard Team</h4>';
        $email_body .= '</div></body"></html>';
    
        echo $email_body;
    }
    else {
        header(sprintf("Location: %s", $baseDomain));
    }
}
else if(isset($_GET['emailConf']) && isset($_GET['signUpEmail']) && !isset($_GET['confirm'])) {

    $sql = new sql();

    $signUpEmail = $sql->hashword(str_replace(' ', '', urldecode($_GET['signUpEmail'])));
    $emailConf = str_replace(' ', '', rawurldecode($_GET['emailConf']));

    $query_seluser = "SELECT * FROM users WHERE user_email = '$signUpEmail' AND user_hash = '$emailConf' AND user_confirm = '0'";
    $seluser = $sql->dbquery($query_seluser);
    $row_seluser = odbc_fetch_array($seluser);
    $seluserRows  = odbc_num_rows($seluser);

    // echo $seluserRows . '<br/>' . $signUpEmail . '<br/>' . $emailConf . '<br/>' . $row_seluser['user_hash'];
    if($seluserRows > 0) {
        $ip = $sql->get_client_ip_server();
        $queryUpd = "UPDATE users SET user_ip = '$ip', user_confirm = '1' WHERE user_email = '$signUpEmail' AND user_hash = '$emailConf'";
        $sql->dbquery($queryUpd);

        $succHeader = $baseDomain . '/confirmation.php?confirm=success';
        header(sprintf("Location: %s", $succHeader));
    }
    else {
        $errRefHeader = $baseDomain . '/confirmation.php?confirm=error';
        header(sprintf("Location: %s", $errRefHeader));
    }

}
else {
    header(sprintf("Location: %s", $baseDomain));
}
?>