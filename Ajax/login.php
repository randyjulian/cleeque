
<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <title></title>
    <script type="text/javascript" src="main.js"></script>
</head>
<body>
<?php
if(isset($errMessage)){
	echo $errMessage."<br>";	
}
?>

<form action="" method="post" id="login-form">
	<label>Username: </label><input type="text" name="username" id="username"><br><br>
	<label>Password: </label><input type="password" name="password" id="password"><br><br>
	<input type="submit" name="submit" value="LOG IN" id="login"><br>
</form>
<p id="message"></p>

<a href="logout.php">Log out</a>

</body>
</html>