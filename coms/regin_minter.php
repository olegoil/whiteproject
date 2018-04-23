<?php

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['lastname'])) {

  include '../conns/whiteauth.php';

  $sql = new sql();

  $email = "-1";
  if (isset($_POST['email'])) {
    $email = $sql->protect($_POST['email']);
  }

  $pwd = "-1";
  if (isset($_POST['password'])) {
    $pwd = $sql->protect($_POST['password']);
  }

  $firstname = "-1";
  if (isset($_POST['firstname'])) {
    $firstname = $sql->protect($_POST['firstname']);
  }

  $lastname = "-1";
  if (isset($_POST['lastname'])) {
    $lastname = $sql->protect($_POST['lastname']);
  }

  echo json_encode($sql->registerMinter($email, $pwd, $firstname, $lastname));

}
else {
  echo json_encode(array("success" => 0));
}

?>
