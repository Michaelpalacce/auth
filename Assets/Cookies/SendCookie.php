<?php
$cookie_name = "send";
$cookie_value = $_POST['value'];
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");