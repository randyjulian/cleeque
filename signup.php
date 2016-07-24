<!DOCTYPE html>
<html>
<head>
	<title>Cleeque | Sign Up</title>
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>
<div class="navbar">
		<img id="logo" src="http://i.imgur.com/NXXGa4e.png" height="35" width="35" style="float: left; margin-top: 6.4px;"><p id= "cleeque" style="margin-top:0px;" >  CLEEQUE</p> 
		<div class="menu" style="float:right;">
			<div class="mainMenu">
				<p >Home</p>
				<p>About</p>
				<p>Contact Us</p>
			</div>
			<a id="usernameNav" style="text-decoration:none;" href="logout.php">Log Out</a>
			<p id="responsiveNavButton"> &#9776; Menu</p>
		</div>
</div>



<div class="mainSignup" style="text-align: center; padding-top: 70px; ">
<form action= "signupsuccessful.php" method="post">
<input type="text" style="margin: auto;" name="name" value= "<?php if (isset($_GET['name'])){ echo $_GET['name'];} ?>" placeholder="Username">
<?php 
	if (isset($_GET['named'])) {echo "Please input your name";}
	else if (isset($_GET['exist'])) { echo  "This username has already existed.";}?><br>
<input type="password" style="margin: auto;" name="password" placeholder="Password"><?php if (isset($_GET['pass'])) {echo "Please input your password";}?><br>

<input type="text" name="email" style="margin: auto;" value= "<?php if (isset($_GET['email'])){ echo $_GET['email'];} ?>" placeholder="Email">
	<?php 
	if (isset($_GET['emailed'])) {
		echo "Please input your email ";
	}
	if (!isset($_GET['emailed'])&&isset($_GET['emailformaterror']) && !filter_var(isset($_POST['email']), FILTER_VALIDATE_EMAIL)) {
     echo "Invalid email format"; 
    }
    ?>
<br>


 

<input type="submit">
</form>
</div>






</body>
</html>