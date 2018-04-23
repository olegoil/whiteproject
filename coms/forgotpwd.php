<?php

$gotdata = array();

// RESET PWD
if(isset($_POST['forgotEmail']) && isset($_POST['resetPwd'])) {

    include '../conns/whiteauth.php';

    $sql = new sql();

    $pwdres = json_decode($sql->passwordReset($sql->protect($_POST['forgotEmail'])), true);

    if(isset($pwdres['user_reset_pwd'])) {
        
        $baseDomain = 'http://whitecoin.blockchaindevelopers.org';
        $baseCookieDomain = 'whitecoin.blockchaindevelopers.org';
        
        // SEND RESET EMAIL TO USER
        $email_subject = "Email password reset from ".$baseCookieDomain.".";
        $email_body = '<html style="width:100%;height:100%;"><body style="background-color:#E0F1FF;width:100%;height:100%;">';
        $email_body .= '<div style="text-align:center;"><img style="margin:10px auto;height:60px;" src="'.$baseDomain.'/images/logo.png" alt="White Standard" /></div>';
        $email_body .= '<div style="margin:30px;padding:20px;background-color:#fff;text-align:center;">';
        $email_body .= '<h2 style="text-align:left;">Password Reset</h2>';
        $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">Click the link below to reset Your password:</h2>';
        $email_body .= '<br/><a style="display:inline-block;background-color:#3C8DC8;color:#fff;padding:20px;text-align:center;font-size:24px;text-decoration:none;" href="'.$baseDomain.'/coms/resetpwd.php?forgotEmail='.$_POST['forgotEmail'].'&forgotHash='.urlencode($pwdres['user_reset_pwd']).'" target="_blank">Reset password</a>';
        // $email_body .= '<br/><h2 style="text-align:left;">if this activity is not your own operation, please contact us immediately.</h2>';
        $email_body .= '<br/><br/><br/><h4 style="color:#999;text-align:left;font-weight:normal;margin-bottom:0px;">White Standard Team</h4>';
        $email_body .= '<h4 style="color:#888;text-align:left;font-weight:normal;margin-top:0px;">Automated message. Please do not reply.</h4>';
        $email_body .= '<a style="text-decoration:none;font-weight:normal;color:#3C8DC8;font-size:1.5em;" href="'.$baseDomain.'" target="_blank">'.$baseDomain.'</a>';
        $email_body .= '</div><br/></body"></html>';

        require_once "SendMailSmtpClass.php";
        $mailSMTP = new SendMailSmtpClass('xanatosdark@yandex.ru', 'Vivanco2!', 'ssl://smtp.yandex.ru', 'White Standard', 465);
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: White Standard <noreply@".$baseCookieDomain.">\r\n";
        $mailSMTP->send($_POST['forgotEmail'], $email_subject, $email_body, $headers);

        array_push($gotdata, array("emailReset" => 1));
    }
    else {
        array_push($gotdata, array("emailReset" => 0));
    }

    echo json_encode($gotdata);

}
else {
    array_push($gotdata, array("emailReset" => 0));

    echo json_encode($gotdata);
}

?>