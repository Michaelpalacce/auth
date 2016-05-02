<?php
include "Assets/include/loggedfilter.php";
if(!class_exists('FriendRepository')){
    include 'Assets/Repository/FriendRepository.php';
}

if(!isset($_SESSION)){
    session_start();
}
$repo= new FriendRepository();
$id = $_SESSION['user_id'];
$frID=$_GET['ID'];
$friend =new Friend();
$friend->UserID_1=$id;
$friend->UserID_2=$frID;
$repo->Add($friend);




header('Location: FindFriends.php');