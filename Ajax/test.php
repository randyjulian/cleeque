<?php
include("databaseconnection.php");
session_start();
$errMessage='';
$username=trim($_POST['username']);
$password=trim($_POST['password']);
echo "username: $username and password: $password ";
$username='31431';
$x = '$2y$10$lHl6a6hL.rNxPzLB5vvdIO9j95hbMcLyOIRHEUAJkG6zoflzZhNCK';

//$password=password_hash($_POST['password'], PASSWORD_DEFAULT);
if($password==$x){
	echo "true";
} esle {
	echo "false";
}