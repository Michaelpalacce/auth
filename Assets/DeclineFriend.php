<?php
include "Repository/FriendRepository.php";
$repo=new FriendRepository();

$repo->DeleteByID($_POST['value']);