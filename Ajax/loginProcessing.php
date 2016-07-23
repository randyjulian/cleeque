<?php
include("databaseconnection.php");
session_start();
$errMessage='';
$username=trim($_POST['username']);
$password=trim($_POST['password']);
echo "username: $username and password: $password ";
if($username==''){
    $errMessage.='Name is not filled! ';
}
if($password==''){
    $errMessage.='Password is not filled! ';
}

if($errMessage==''){
	$records= $database->prepare('SELECT id, username, password, email FROM userid WHERE username=:username');
	$records->bindParam(':username', $username);
	$records->execute();
    $results=$records->fetch(PDO::FETCH_ASSOC);
    echo $password." ".$results['password'];
    $x = '$2y$10$lHl6a6hL.rNxPzLB5vvdIO9j95hbMcLyOIRHEUAJkG6zoflzZhNCK';
    echo password_verify($password, $results['password']);
    /*if(count($results)>0 && password_verify($password, $results['password'])){
    	$_SESSION['username']=$results['username'];
    	echo "ok!";

    } else {
    	$errMessage.="Username and Password are not found!<br>";
    	echo $errMessage;
    }*/
}

echo $errMessage;
