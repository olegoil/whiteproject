<?php

include '../conns/whiteauth.php';

if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
  
  $sql = new sql();

  $sql->logoutUser();

}
else {
  $cookiesuccess = "http://whitecoin.blockchaindevelopers.org";
  header(sprintf("Location: %s", $cookiesuccess));
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Логин</title>
</head>
  <body>
    обработка..
  </body>
</html>
