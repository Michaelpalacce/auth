<?php
include "Assets/Repository/EventRepository.php";
$repo= new EventRepository();
$repo->Delete($_GET['ID']);
header('Location: Calendar.php');