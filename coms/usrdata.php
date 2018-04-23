<?php

  include '../conns/whiteauth.php';

  $sql = new sql();

  $pwdold = "-1";
  if (isset($_POST['pwdold'])) {
    $pwdold = $sql->protect($_POST['pwdold']);
  }
  $pwdnew = "-1";
  if (isset($_POST['pwdnew'])) {
    $pwdnew = $sql->protect($_POST['pwdnew']);
  }

  $name = "-1";
  if (isset($_POST['name'])) {
    $name = $sql->protect($_POST['name']);
  }
  $lastname = "-1";
  if (isset($_POST['lastname'])) {
    $lastname = $sql->protect($_POST['lastname']);
  }
  $mobile = "-1";
  if (isset($_POST['mobile'])) {
    $mobile = $sql->protect($_POST['mobile']);
  }
  $email = "-1";
  if (isset($_POST['email'])) {
    $email = $sql->protect($_POST['email']);
  }
  $skype = "-1";
  if (isset($_POST['skype'])) {
    $skype = $sql->protect($_POST['skype']);
  }
  $country = "-1";
  if (isset($_POST['country'])) {
    $country = $sql->protect($_POST['country']);
  }
  $city = "-1";
  if (isset($_POST['city'])) {
    $city = $sql->protect($_POST['city']);
  }
  $plz = "-1";
  if (isset($_POST['plz'])) {
    $plz = $sql->protect($_POST['plz']);
  }
  $address = "-1";
  if (isset($_POST['address'])) {
    $address = $sql->protect($_POST['address']);
  }
  $usr = "-1";
  if (isset($_POST['usr'])) {
    $usr = $sql->protect($_POST['usr']);
  }
  $notes = "-1";
  if (isset($_POST['notes'])) {
    $notes = $sql->protect($_POST['notes']);
  }

  $act = "-1";
  if (isset($_POST['act'])) {
    $act = $sql->protect($_POST['act']);
  }

  if($act == 'chngpwd') {
    echo $sql->passwordChange($pwdold, $pwdnew);
  }
  else if($act == 'updusr') {
    echo $sql->usrDataChange($name, $lastname, $mobile, $skype, $country, $city, $plz, $address);
  }
  else if($act == 'usrnotes') {
    echo $sql->usrNotes($usr, $notes);
  }

?>