<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body><?php 

$name= $_POST['name'];
// create passwordhash
$userpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);  
$email = $_POST['email'];
$fullname=$_POST['fullname'];

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
		
// var for identifying empty form		
$location = null;
$error = false;

// functions to check if the respective forms is empty and when redirect return the previous correct value
if (isset($_POST['name'])==false || $_POST['name']==NULL){
	$location = $location.'&named=1'.'&email='.$email.'&fullname='.$fullname; $error = true;}
if (isset($_POST['password'])==0 || $_POST['password']==NULL){
	$location .= '&pass=1';$error = true;}
if (isset($_POST['email'])==0 || $_POST['email']==NULL){
	$location .= '&emailed=1'.'&name='.$name.'&fullname='.$fullname;$error = true;}
if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
  $location .= '&emailformaterror=1&email='.$email.'&name='.$name;$error=true;}
if (isset($_POST['fullname'])==false || $_POST['fullname']==NULL){
  $location = $location.'&fullnamed=1&name='.$name; $error = true;}

// if there is error then the header will be run, else run the pdo code instead
if ($error == true) {
	header('Location: signup.php?'.$location);
	}
else {

// writing into the database
try {
    $database = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to insert data
    $sql = "INSERT INTO userid(username, password, email,name)
    VALUES ('$name','$userpassword','$email','$fullname')";

    // use exec() because no results are returned
    $database->exec($sql);
    echo "<script> 
    window.location.href='index.php';
    </script>";
    }

catch(PDOException $e)
    { // catch error 23000 which is not unique username and redirect with email form filled
   		if ($e -> getcode() == 23000) {
   		header('Location: signup.php?exist=1&email='.$email);	
   		}
   		else {
   			print($e->getMessage());
   			}
    
    }
}
$database = null;


  ?>

</body>
</html>