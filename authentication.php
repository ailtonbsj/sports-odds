<?php

//AUTHENTICATION

session_start();
if(isset($_SESSION['user'])){
  $user = $_SESSION['user'];
  $type = $_SESSION['tipo'];
} else header('Location: logoff.php');

?>