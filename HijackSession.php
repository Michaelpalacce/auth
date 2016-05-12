<?php
session_start();

session_unset();

session_destroy();

session_start();
$_SESSION['user_id']=$_GET['ID'];
$_SESSION['Email']=$_GET['Email'];
header('Location: Home.php');

