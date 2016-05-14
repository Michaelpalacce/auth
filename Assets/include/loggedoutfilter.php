<?php

if(isset($_SESSION['user_id'])){
    set_include_path("D:/Coding/Xamp/htdocs/auth");
    header("Location: Home");
}