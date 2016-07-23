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
    $database = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
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

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
if(isset($errMessage)){
	echo $errMessage."<br>";	
}
?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
	<label>Username: </label><input type="text" name="username"><br><br>
	<label>Password: </label><input type="password" name="password"><br><br>
	<input type="submit" name="submit" value="LOG IN"><br>
</form>

</body>
</html>