<?php
include "Assets/Repository/EventRepository.php";
$repo= new EventRepository();
$repo->Delete($_POST['value']);