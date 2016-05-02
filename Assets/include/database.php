<?php
$server= 'localhost';
$username='root';
$password='';
$database='auth';
try{
    $pdo= new PDO("mysql:host=$server;dbname=$database",$username,$password);
}catch (PDOException $e){
    echo "Connection failed".$e->getMessage();
}