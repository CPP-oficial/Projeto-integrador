<?php 
session_start();
unset($_SESSION['id_users']);
header('location: ../html/login/login.php');
exit();
?>