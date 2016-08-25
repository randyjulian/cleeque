<?php
	session_start();
	include("groupFunction.php");
	include("main_ics_processer.php");
	include("databaseconnection.php");
	$username=$_SESSION['username'];
	$_SESSION['fullName']=gettingNameFromUsername($_SESSION['username']);

	//NUSNET connection API
    require_once 'LightOpenID-master/openid.php';
	$openid= new LightOpenID("https://cleeque.herokuapp.com/index.php");

	$openid->identity = 'https://openid.nus.edu.sg/';
	$openid->required = array(
		'contact/email',
		'namePerson/friendly',
		'namePerson');
	$openid->returnUrl = 'https://cleeque.herokuapp.com/nusnetlogin.php';
	
?>
<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
	<title>Cleeque | About</title>
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<meta name="theme-color" content="#ffffff">
	<link type="text/css" rel="stylesheet" href="style.css"></link>
	<!---Fonts-->
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="modal">
		<div class="modal-content">
			<div class="modalHeader">
				<span class="close"> X </span>
				<p id="modalCleeque">CLEEQUE</p>				
			</div>
			<div class="modalBody">
				<a href='<?php echo $openid->authUrl()?>' style="text-decoration:none;"><div class="nusnetLogin">
					<p>Login with NUSNET</p>
				</div></a>
				<form  method="post">
					<input type="text" id="username" placeholder="Username"><br><br>
					<input type="password" id="password" placeholder="Password"><br>
					<p id="errorMessage" style="color:red"></p>
					<input type="submit" name="submit" value="Sign In" id="loginButton">
				</form>
				
				<br id="account"> Don't have an account? <a href="signup.php" id="modalSignup">Sign up!</a>
			</div>
		</div>
	</div>
	<div class="navbar">
		<img id="logo" src="http://i.imgur.com/NXXGa4e.png" height="35" width="35" style="float: left; margin-top: 6.4px;"><p id= "cleeque" style="margin-top:0px;" >  CLEEQUE</p> 
		<div class="menu" style="float:right;">
			<div class="mainMenu">
				<p><a href="index.php">Home</a></p>
				<p><a href="about.php">About</a></p>
			</div>
			<?php 
				if(isset($_SESSION['username'])){
					echo '<a id="usernameNav" style="text-decoration:none;" href="logout.php">Log Out</a>';
				} else {
					echo '<p id="login">Sign In</p>';
				}
			?>
			<p id="responsiveNavButton"> &#9776; Menu</p>
		</div>
		

	</div>
	<div class="mainabout" style="padding-top:50px;">
		<div class="description">
			<p id="descriptionHeader">What's this project?</p>
			<p id="descriptionContent">Cleeque aims to facilitate meet up arrangement so that work can be more productive and friends would be more bonded. This web application is designed especially for NUS students but with a big plan to extend beyond the NUS community. As such, currently, the website only supports the iCalendar file downloaded from <a href="https://nusmods.com/" style="text-decoration:none;">nusmods.com</a>.
			<br>
			<br>
			This web application is a part of the NUS computing project module called "Orbital". If you have any feedback or suggestion, please drop us an email at <a href="mailto:krittin.kawkeeree@u.nus.edu?subject=Cleeque Feedback" style="text-decoration:none;color:#3498db;">Krittin</a> or <a href="mailto:randyjulian@u.nus.edu?subject=Cleeque Feeback" style="text-decoration:none;color:#3498db;">Randy</a>.</p>
		</div>
		
	</div>
	<div class="footer">
		<p style="text-align: left;"> &copy Cleeque 2016</p>
	</div>

</body>
</html>
