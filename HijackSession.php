<?php
session_start();

session_unset();

session_destroy();

session_start();
$_SESSION['user_id']=$_GET['ID'];
include "Assets/Repository/UserRepository.php";
$repo= new UserRepository();
$user= $repo->GetByID($_GET['ID']);
$_SESSION['Email']=$user->Email;
header('Location: Home.php');

