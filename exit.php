<?php
require_once "functions.php";
require_once "data.php";
session_start();
setcookie('user_name', "", -3600);
setcookie('avatar', "", -3600);
header("location:index.php");
?>
