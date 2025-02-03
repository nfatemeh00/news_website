<?php

session_start();
include "../database/pdo_connection.php";
$getId=$_GET['id'];

$delete=$conn->prepare("DELETE FROM news WHERE news_id=?");

$delete->bindValue(1,$getId);

$delete->execute();
header('location:news.php');

if(!isset($_SESSION['user'])){
  header("location:../login.php");
  
}


?>