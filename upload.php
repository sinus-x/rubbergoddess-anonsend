<?php
require_once("settings.php");

if (!isset($_POST["submit"])) {
	header("Location: /", TRUE, 307);
	die();
}

$valid = True;
$message2 = "You must have done something wrong.";

if (!isset($_FILES["uploadedFile"]) || $_FILES["uploadedFile"]["error"] !== UPLOAD_ERR_OK) {
	$valid = False;
	$message2 = "No file was uploaded.";
}

if ($_FILES["uploadedFile"]["size"] > FILESIZE * 1024 * 1024) {
	$valid = False;
	$message2 = "Your file is too big.";
}

if ($valid && !isset($_POST["channel"]) || !in_array($_POST["channel"], CHANNELS)) {
	$valid = False;
	$message2 = "Invalid channel.";
}

$filename = explode(".", $_FILES["uploadedFile"]["name"]);
$extension = strtolower(end($filename));

if ($valid && (!in_array($extension, ["jpg", "jpeg", "png"]) || !in_array($_FILES['uploadedFile']['type'], ["image/jpeg", "image/png"]))) {
	$valid = False;
	$message2 = "Unsupported file format.";
}

$newname = substr(md5(time() . $_FILES["uploadedFile"]["name"]), 0, NAMELENGTH) . "." . $extension;

if ($valid) {
	if (move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], "uploads/" . $newname)) {
		$valid = True;
	} else {
		$valid = False;
		$message2 = "Could not save file.";
	}
}

if ($valid) {
	$message1 = "Your file was successfully uploaded.";
	$message2 = "You can send it to your channel with <span class=\"inverse rounded\">" . PREFIX . "anonsend submit " . $_POST["channel"] . " " . $newname . "</span>";
	$classname = "success";
} else {
	$message1 = "An error occurred.";
	$classname = "error";
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0.0, minimum-scale=1.0, maximum-scale=1.0">
	<title><?= NAME ?></title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body class="upload">
	<div class="<?= $classname ?> box">
		<p><?= $message1 ?></p>
		<p><?= $message2 ?></p>
	</div>
	<a class="backlink" href="/">back</a>
</body>
</html>
