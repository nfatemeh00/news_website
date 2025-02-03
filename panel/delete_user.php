<?php

session_start();
include "../database/pdo_connection.php";
$getId=$_GET['id'];

$delete=$conn->prepare("DELETE FROM users WHERE user_id=?");

$delete->bindValue(1,$getId);

$delete->execute();
header('location:users.php');

if(!isset($_SESSION['user'])){
  header("location:../login.php");
  
}


?>