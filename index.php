<?php
include_once("settings.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= NAME ?></title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body class="index">
	<form class="box" action="upload.php" method="post" enctype="multipart/form-data">
		<p>Select file (JPEG or PNG, max <?= FILESIZE ?> MB)</p>
		<input type="file" name="uploadedFile" id="uploadedFile">
		<input type="submit" value="Upload" name="submit">
	</form>
</body>
</html>
