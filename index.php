<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>
</head>
<body>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select files to upload:

    <input type="file" multiple = '' name="fileToUpload[]" id="fileToUpload"><br />
    <input type="submit" value="Upload File" name="submit">
<a href="signup.php">Sign Up</a>
<a href="login.php">Log in</a>
</form>
</body>
</html>