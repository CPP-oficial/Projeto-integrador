<?php 
session_start();

if(!$_SESSION['id_users']){
    header('location: ../login/login.php');
    exit();
}
?>