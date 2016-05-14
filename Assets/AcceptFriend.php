<?php
include "Repository/FriendRepository.php";

$repo=new FriendRepository();

$repo->AcceptFriend($_POST['value']);