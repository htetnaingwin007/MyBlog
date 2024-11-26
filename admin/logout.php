<?php 

session_start();

unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_email']);
unset($_SESSION['user_profile']);
unset($_SESSION['user_role']);

header("location:login.php");
