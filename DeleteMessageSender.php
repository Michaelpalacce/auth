<?php
include "Assets/Repository/MessageRepository.php";
$repo=new MessageRepository();
$id=$_POST['value'];
echo $id;
$repo->DeleteForSender($id);