<?php

    include '../conns/whiteauth.php';
    $sql = new sql();

    if(isset($_POST['walletSend']) && isset($_POST['walletRec']) && isset($_POST['sendAmount']) && isset($_POST['sendNotes'])) {

        $from = $sql->protect($_POST['walletSend']);
        $to = $sql->protect($_POST['walletRec']);
        $amount = $sql->protect($_POST['sendAmount']);
        $notes = $sql->protect($_POST['sendNotes']);

        $sql->makeTransaction($from, $to, $amount, $notes);

        $sendSuccess = 'http://whitecoin.blockchaindevelopers.org/transactions/?sendsuccess=1';
        header(sprintf("Location: %s", $sendSuccess));

    }
    else {
        $sendSuccess = 'http://whitecoin.blockchaindevelopers.org/transactions/?sendfailed=1';
        header(sprintf("Location: %s", $sendSuccess));
    }

?>