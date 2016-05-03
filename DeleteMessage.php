<?php
include "Assets/include/loggedfilter.php";
include "Assets/Repository/MessageRepository.php";

$repo=new MessageRepository();

$id=$_GET['ID'];
$person=$_GET['Person'];
$dire=$_GET['Place'];
if($person=='Sender'){
    $repo->DeleteForSender($id);
}
else{
    $repo->DeleteForReciever($id);
}
if($dire=='S'){
    header('Location: SentMessagept2.php');
}
else{
    header('Location: Inboxpt2.php');
}