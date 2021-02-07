<?php
include_once("private.php");

if (!isset($_GET["apikey"]) || $_GET["apikey"] !== $apikey) {
	header('HTTP/1.0 401 Unauthorised');
	echo "Invalid API key.";
	die();
}

if (!isset($_GET["file"]) || strpos($_GET["file"], "..") !== false || !file_exists("uploads/" . $_GET["file"])) {
	header("HTTP/1.0 404 Not Found");
	echo "Not found.";
	die();
}

if (!isset($_GET["action"]) || !in_array($_GET["action"], array("download", "delete"))) {
	header("HTTP/1.0 400 Bad Request");
	echo "Bad \"action\" parameter.";
	die();
}

$filename = "uploads/" . $_GET["file"];

if ($_GET["action"] == "download") {
	$finfo = finfo_open(FILEINFO_MIME_TYPE);

	header("Content-Type: " . finfo_file($finfo, $filename));
	finfo_close($finfo);

	header("Content-Disposition: attachment; filename=" . basename($filename));

	header("Expires: 0");
	header("Cache-Control: must-revalidate");
	header("Pragma: public");

	header("Content-Length: " . filesize($filename));

	ob_clean();
	flush();
	readfile($filename);
	die();
}

if ($_GET["action"] == "delete") {
	$result = unlink($filename);

	if ($result === false) header("HTTP/1.0 500 Internal Server Error");
	die();
}

?>
