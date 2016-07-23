<?php
	require_once 'LightOpenID-master/openid.php';
	$openid= new LightOpenID("https://cleeque.herokuapp.com/nusnet.php");

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
	<title></title>
</head>
<body>
sadf
<h1>chj <a href='<?php echo $openid->authUrl()?>'>Login with NUS</a></h1>
</body>
</html>
