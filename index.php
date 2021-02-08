<?php
include_once("settings.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0.0, minimum-scale=1.0, maximum-scale=1.0">
	<title><?= NAME ?></title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body class="index">
	<form class="box" action="upload.php" method="post" enctype="multipart/form-data">
		<p>Select file (JPEG or PNG, max <?= FILESIZE ?> MB)</p>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?= FILESIZE * 1024 * 1024 ?>" />
		<input type="file" name="uploadedFile" id="uploadedFile" />
		<select name="channel">
			<option disabled selected value>-- select channel --</option>
			<?php foreach (CHANNELS as $channel) echo "<option value='$channel'>$channel</option>" ?>
		</select>
		<input type="submit" value="Upload" name="submit" />
	</form>
</body>
</html>
