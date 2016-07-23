<?php
/*
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
    
    //echo password_verify($password, $results['password']);
    /*if(count($results)>0 && password_verify($password, $results['password'])){
    	$_SESSION['username']=$results['username'];
    	echo "ok!";

    } else {
    	$errMessage.="Username and Password are not found!<br>";
    	echo $errMessage;
    }*/

session_start();
include("databaseconnection.php");
$errMessage="";
$loginusername = $_POST["username"];
$loginpassword = $_POST["password"];
$errMessage='';
$username=trim($_POST['username']);
$password=trim($_POST['password']);
$records= $database->prepare('SELECT id, username, password, email FROM userid WHERE username=:username');
$records->bindParam(':username', $_POST['username']);
$records->execute();
$results=$records->fetch(PDO::FETCH_ASSOC);
    //print_r($results);
    //echo "Results: _".password_verify($loginpassword,$results['password'])."_";
    //echo "Count: ".count($results);
if(count($results)>0 && password_verify($loginpassword, $results['password'])){
    $_SESSION['username']=$results['username'];
    echo json_encode(array('message'=> "ok")); //Login successfully. 
} else {
    echo json_encode(array('message'=> "Incorrect Username or Password"));
}


?>

