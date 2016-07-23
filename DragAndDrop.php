<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
	<title>Drag and Drop</title>
	<link type="text/css" rel="stylesheet" href="style.css"></link>
	<!---Fonts-->
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>

	
</head>
<body>
	<form class="dragAndDrop" method="post" action="upload2.php" enctype="multipart/form-data">
		<div class="inputBox">
			<input type="file" class="uploadBox" id="uploadBox" name="fileToUpload" style="display:none" />
			<label for='uploadBox' id="chooseFileButton"><strong>Choose a file</strong></label> <label>or drag and drop it here.</label>
			<button id="uploadButton" type="submit">Upload</button>
		</div>
		<div class="inputUpload">Uploading&hellip;</div>
		<div class="inputError">Error uploading!</div>
	</form>

</body>
</html>