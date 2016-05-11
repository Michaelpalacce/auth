<?php
include 'Assets/Repository/FriendRepository.php';
if(!isset($_SESSION)){
    session_start();
}
$repo= new FriendRepository();
$id = $_SESSION['user_id'];
$frID=$_POST['value'];

$repo->Delete($id,$frID);
