<?php 
session_start();
if (empty($_SESSION)) {
    header('Location: pages/auth/login.php');
}


?>