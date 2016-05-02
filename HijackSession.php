<?php
session_start();

session_unset();

session_destroy();

session_start();
$_SESSION['user_id']=$_GET['ID'];
$_SESSION['Email']=$_GET['Email'];
?>
<style>
    <?php include 'Assets/CSS/home.css'; ?>
</style>
<a href="Index.php" class="but2">INDEX</a>

