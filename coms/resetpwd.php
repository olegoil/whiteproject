<?php

$baseDomain = 'http://whitecoin.blockchaindevelopers.org';
$baseCookieDomain = 'whitecoin.blockchaindevelopers.org';

if(isset($_GET['forgotEmail']) && isset($_GET['forgotHash'])) {

    include '../conns/whiteauth.php';

    $sql = new sql();

    $forgotEmail = $sql->protect($_GET['forgotEmail']);
    $forgotEmailHash = $sql->hashword($forgotEmail);
    $forgotHash = $sql->protect(urldecode($_GET['forgotHash']));
    $newPwd = $sql->generateRandomString();
    $userPwd = $sql->hashword($newPwd);
    $now = time();

    $qseluser = "SELECT * FROM users WHERE user_email = '$forgotEmailHash' AND user_reset_pwd = '$forgotHash'";
    $seluser = $sql->dbquery($qseluser);
    $row_seluser = odbc_fetch_array($seluser);
    $seluserRows  = odbc_num_rows($seluser);
    if ($seluserRows > 0) {

        $updreset = "UPDATE users SET user_reset_pwd = '0', user_pwd='$userPwd' WHERE user_email = '$forgotEmailHash' AND user_reset_pwd = '$forgotHash'";
        $sql->dbquery($updreset);

        // SEND EMAIL TO NEW USER
        $email_subject = "Password reset from ".$baseCookieDomain.".";
        $email_body = '<html style="width:100%;height:100%;"><head><script>setTimeout(function(){window.location.href="'.$baseDomain.'";},2000);</script></head><body style="background-color:#E0F1FF;width:100%;height:100%;">';
        $email_body .= '<div style="text-align:center;"><img style="margin:10px auto;height:60px;" src="'.$baseDomain.'/images/logo.png" alt="White Standard" /></div>';
        $email_body .= '<div style="margin:30px;padding:20px;background-color:#fff;">';
        $email_body .= '<h2 style="text-align:left;">Password changed</h2>';
        $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">Your temporary password: '.$newPwd.'</h2>';
        $email_body .= '<br/><br/><br/><h4 style="color:#999;text-align:left;font-weight:normal;margin-bottom:0px;">White Standard Team</h4>';
        $email_body .= '</div></body"></html>';
    
        require_once "SendMailSmtpClass.php";
        $mailSMTP = new SendMailSmtpClass('xanatosdark@yandex.ru', 'Vivanco2!', 'ssl://smtp.yandex.ru', 'White Standard', 465);
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: White Standard <noreply@".$baseCookieDomain.">\r\n";
        $mailSMTP->send($forgotEmail, $email_subject, $email_body, $headers);

        echo $email_body;

    }
    else {

        $redire = $baseDomain;
        header(sprintf("Location: %s", $redire));

    }

}
else {
    $redire = $baseDomain;
    header(sprintf("Location: %s", $redire));
}

?>