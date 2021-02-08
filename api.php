<?php
require_once("settings.php");

if (!isset($_GET["apikey"]) || $_GET["apikey"] !== APIKEY) {
	header($_SERVER["SERVER_PROTOCOL"] . " 401 Unauthorised");
	echo "Invalid API key.";
	die();
}

if (!isset($_GET["action"]) || !in_array($_GET["action"], ["download", "delete", "list"])) {
	header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
	echo 'Bad "action" parameter.';
	die();
}

if (in_array($_GET["action"], ["download", "delete"]) && (!isset($_GET["file"]) || strpos($_GET["file"], "..") !== false || !file_exists("uploads/" . $_GET["file"]))) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	echo "Not found.";
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

	if ($result === false) header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
	die();
}

if ($_GET["action"] == "list") {
	$files = array_values(array_diff(scandir("uploads/"), [".", "..", ".htaccess"]));
	$result = [];
	foreach ($files as $file) $result[$file] = filemtime("uploads/" . $file);

	header("Content-Type: application/json; charset=utf-8");
	echo json_encode($result);
	die();
}
