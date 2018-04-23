<?php

include '../conns/whiteauth.php';

if(isset($_POST['email']) && isset($_POST['password'])) {

  $sql = new sql();

  $email = "-1";
  if (isset($_POST['email'])) {
    $email = $sql->protect($_POST['email']);
  }

  $pwd = "-1";
  if (isset($_POST['password'])) {
    $pwd = $sql->protect($_POST['password']);
  }

  $sql->loginUser($email, $pwd);

}
else {
  $sql = new sql();
  $sql->checkLogin();
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
  <body>
    checking..
  </body>
</html>
