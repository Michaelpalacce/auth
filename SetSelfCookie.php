<?php
$cookie_name = "friend";
$cookie_value = $_GET['value'];
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
header('Location: ViewAccount.php');
?>