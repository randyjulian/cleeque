<?php
	require_once 'LightOpenID-master/openid.php';
	$openid= new LightOpenID("localhost/Orbitals_Local_Server/nusnet.php");

	$openid->identity = 'https://openid.nus.edu.sg/';
	$openid->required = array(
		'contact/email',
		'namePerson/friendly',
		'namePerson');
	$openid->returnUrl = 'http://localhost/Orbitals_Local_Server/nusnetlogin.php';

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
