<?php
set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Assets/Repository/PhoneRepository.php';
$rep= new PhonesRepository();
$id = $_GET['NID'];
$rep->Delete($id);

$contId=$_GET['ID'];
$str = 'Location: Phones.php?ID='.$contId;
header($str);