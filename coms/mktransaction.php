<?php

if(isset($_POST['act']) && isset($_POST['amnt'])) {

  include '../conns/whiteauth.php';

  $sql = new sql();

  $to = "-1";
  if (isset($_POST['adr'])) {
    $to = $sql->protect($_POST['adr']);
  }

  $fromadr = "-1";
  if (isset($_POST['fromadr'])) {
    $fromadr = $sql->protect($_POST['fromadr']);
  }

  $amount = "-1";
  if (isset($_POST['amnt'])) {
    $amount = $sql->protect($_POST['amnt']);
  }

  $notes = "";
  if (isset($_POST['notes'])) {
    $notes = $sql->protect($_POST['notes']);
  }

  $act = "";
  if (isset($_POST['act'])) {
    $act = $sql->protect($_POST['act']);
  }

  $state = "";
  if (isset($_POST['state'])) {
    $state = $sql->protect($_POST['state']);
  }

  $from = $_COOKIE['u'];
  $success = 1;

  if($act == 'send') {
    $success = $sql->adminMakeTransaction($sql->adminGetBank()['recid'], $to, $amount, $notes);
  }
  else if($act == 'create') {
    $success = $sql->adminCoinCreate($sql->adminGetBank()['recid'], $amount);
  }
  else if($act == 'destroy') {
    $success = $sql->adminCoinRemove($sql->adminGetBank()['recid'], $amount);
  }
  else if($act == 'reqwc') {
    $success = $sql->coinRequest($sql->adminGetBank()['recid'], $amount, 'Request WCR', $state);
  }
  else if($act == 'sellwc') {
    $success = $sql->coinSell($sql->adminGetBank()['recid'], $amount, 'Sell WCR');
  }
  else if($act == 'btcreqwc') {
    $success = $sql->coinRequestBTC($sql->adminGetBank()['recid'], $amount, 'Request BTC to WCR', $state, $fromadr);
  }
  // else if($act == 'btcsellwc') {
  //   $success = $sql->coinSellBTC($sql->adminGetBank()['recid'], $amount, 'Sell WCR to BTC');
  // }
  else if($act == 'reqwcur') {
    $success = $sql->coinRequestUR($sql->adminGetBank()['recid'], $amount, 'Request WCUR');
  }
  else if($act == 'sellwcur') {
    $success = $sql->coinSellUR($sql->adminGetBank()['recid'], $amount, 'Sell WCUR');
  }
  else if($act == 'minterproof') {
    $sql->minterProof($to, $amount, $fromadr);
  }
  else if($act == 'mintdel') {
    $success = $sql->minterDel($to);
  }
  else if($act == 'adminproof') {
    $success = $sql->adminProof($to, $amount);
  }
  else if($act == 'adminproof2') {
    $success = $sql->adminProof2($to, $amount);
  }
  else if($act == 'userproof') {
    $success = $sql->userProof($to, $amount);
  }
  else if($act == 'docproof') {
    $success = $sql->docProof($to, $amount);
  }
  else if($act == 'sendwc') {
    $success = $sql->makeTransaction($fromadr, $to, $amount, $notes);
  }
  else if($act == 'sendwcur') {
    $success = $sql->coinSendUR($fromadr, $to, $amount, $notes);
  }
  else if($act == 'wcrtowcur') {
    $success = $sql->wcrtoWcur($amount);
  }
  else if($act == 'setethwallet') {
    $sql->setEthWallet($amount);
  }
  else if($act == 'minterrest') {
    $sql->minterRest($amount, $to, $fromadr);
  }
  else if($act == 'feeset') {
    $success = $sql->setFee($fromadr, $to, $amount);
  }
  else if($act == 'quoteset') {
    $success = $sql->setQuote($amount);
  }

  $str = array('success' => $success);
  echo json_encode($str);

}
else {
    $str = array('success' => 0);
    echo json_encode($str);
}

?>
