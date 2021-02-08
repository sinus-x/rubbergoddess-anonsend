<?php
include_once("settings.php");

if (!isset($_POST["submit"])) {
	header("Location: /", TRUE, 307);
	die();
}

$valid = True;
$message2 = "";

if (!isset($_FILES["uploadedFile"]) || $_FILES["uploadedFile"]["error"] != UPLOAD_ERR_OK) {
	$valid = False;
	$message2 = "You did not upload any file.";
}

if ($_FILES["uploadedFile"]["size"] > $filesize * 1024 * 1024) {
	$valid = False;
	$message2 = "Your file is too big.";
}

$filename = explode(".", $_FILES["uploadedFile"]["name"]);
$extension = strtolower(end($filename));

if (!in_array($extension, array("jpg", "jpeg", "png"))) {
	$valid = False;
	$message2 = "Unsupported file format.";
}

$newname = substr(md5(time() . $filename), 0, 8) . "." . $extension;

if ($valid) {
	if (move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], "uploads/" . $newname)) {
		$valid = True;
	} else {
		$valid = False;
		$message2 = "Could not save file.";
	}
}

if ($valid) {
	$message1 = "Your file was succesfully uploaded.";
	$message2 = "You can send it to your channel with <span class=\"inverse rounded\">" . $prefix . "anonsend submit (channel) " . $newname . "</span>.";
	$classname = "success";
} else {
	$message1 = "An error occured.";
	if (strlen($message2) == 0) $message2 = "You must have done something wrong.";
	$classname = "error";
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Rubbergoddess anonymous upload</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body class="upload">
	<div class="<?php echo $classname; ?> box">
		<p><?php echo $message1; ?></p>
		<p><?php echo $message2; ?></p>
	</div>
	<a class="backlink" href="/">back</a>
</body>
</html>
