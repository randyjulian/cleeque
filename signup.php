<!DOCTYPE html>
<html>
<head>
	<title>Cleeque | Sign Up</title>
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<meta name="theme-color" content="#ffffff">


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
	<link type="text/css" rel="stylesheet" href="style.css"></link>
	<!---Fonts-->
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
</head>
<body>

<?php
	session_start();
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

	$location = null;
	$error = false;
try {
    $database = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
   		if ($e -> getcode() == 23000) {
   		echo "The username has already exist.";	
   		}
   		else {
   			print($e->getMessage());
   		}
    
    }
    //NUSNET connection API
    require_once 'LightOpenID-master/openid.php';
	$openid= new LightOpenID("https://cleeque.herokuapp.com/index.php");

	$openid->identity = 'https://openid.nus.edu.sg/';
	$openid->required = array(
		'contact/email',
		'namePerson/friendly',
		'namePerson');
	$openid->returnUrl = 'https://cleeque.herokuapp.com/nusnetlogin.php';

    if(isset($_POST['submit'])){
    	$errMessage='';
    	$username=trim($_POST['username']);
    	$password=trim($_POST['password']);
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
    		if(count($results)>0 && password_verify($password, $results['password'])){
    			$_SESSION['username']=$results['username'];
    			echo "<script> alert('Login successful!'); window.location.href='dashboard.php';</script>";
    			echo $_SESSION['username'];
    		} else {
    			$errMessage.="Username and Password are not found!<br>";
    		}
    		}
    	}
    	

?>



	<div class="modal">
		<div class="modal-content">
			<div class="modalHeader">
				<span class="close"> X </span>
				<p id="modalCleeque">CLEEQUE</p>				
			</div>
			<div class="modalBody">
				<a href='<?php echo $openid->authUrl()?>' style="text-decoration:none; display:none;"><div class="nusnetLogin">
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
			<p id="login">Sign In</p>
			<p id="responsiveNavButton"> &#9776; Menu</p>
		</div>
</div>

<style>/* FOR SIGNUP PAGE*/
input.text[type=text], select {
    width: 30%;
    padding: 12px 20px;
    margin: 8px 8px;
    display: block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-family: "Roboto";
    font-size: 15px;
}
input.pass[type=password], select {
    width: 30%;
    padding: 12px 20px;
    margin: 8px 0;
    display: block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
       font-family: "Roboto";
    font-size: 15px;
}

input.button[type=submit] {
    width: 30%;
    background-color: #3498db;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-family: "Roboto";
    font-size: 15px;
}

input.button[type=submit]:hover {
    background-color: #2b3856;
    transition: 0.2s;
}
</style>

<div class="mainSignup" style="text-align: center; padding-top: 70px; ">
<p id="register"> Register</p>
<form action= "signupsuccessful.php" method="post">
<input class= "text" type="text" style="margin: auto;" name="name" value= "<?php if (isset($_GET['name'])){ echo $_GET['name'];} ?>" placeholder="Username">
<?php 
	if (isset($_GET['named'])) {echo "Please input your name";}
	else if (isset($_GET['exist'])) { echo  "This username has already existed.";}?><br>
<input class="pass" type="password" style="margin: auto;" name="password" placeholder="Password"><?php if (isset($_GET['pass'])) {echo "Please input your password";}?><br>
<input class="text" type="text" name="email" style="margin: auto;" value= "<?php if (isset($_GET['email'])){ echo $_GET['email'];} ?>" placeholder="Email">
	<?php 
	if (isset($_GET['emailed'])) {
		echo "Please input your email ";
	}
	if (!isset($_GET['emailed'])&&isset($_GET['emailformaterror']) && !filter_var(isset($_POST['email']), FILTER_VALIDATE_EMAIL)) {
     echo "Invalid email format"; 
    }
    ?>
    <br>
    <input class= "text" type="text" style="margin: auto;" name="fullname" value= "<?php if (isset($_GET['fullname'])){ echo $_GET['fullname'];} ?>" placeholder="Full Name">
    <?php 
    if (isset($_GET['fullnamed'])) {echo "Please input your full name";}?><br>


 

<input class="button" type="submit">
</form>
</div>

    <div class="footer">
        <p style="text-align: left;"> &copy Cleeque 2016</p>
    </div>




</body>
</html>