<?php
if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {

    include 'conns/whiteauth.php';

    $sql = new sql();

    $sql->checkLogin();

}
else {
    $notcookie = "http://www.communiloca.com/coms/logout.php";
    header(sprintf("Location: %s", $notcookie));
}

?>