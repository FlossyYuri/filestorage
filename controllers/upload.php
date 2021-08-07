
<?php
$response = new stdClass();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

function base_url($atRoot = FALSE, $atCore = FALSE, $parse = FALSE)
{
  if (isset($_SERVER['HTTP_HOST'])) {
    $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
    $hostname = $_SERVER['HTTP_HOST'];
    $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

    $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
    $core = $core[0];

    $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
    $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
    $base_url = sprintf($tmplt, $http, $hostname, $end);
  } else $base_url = 'http://localhost/FileStorage';

  if ($parse) {
    $base_url = parse_url($base_url);
    if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
  }

  return $base_url;
}
// Check if image file is a actual image or fake image
if (isset($_POST["appname"]) && isset($_FILES["file"])) {
  $target_dir = "../uploads/" . $_POST["appname"] . '/';
  $date = new DateTime();
  $target_file = $target_dir . $date->getTimestamp() . '-' . basename($_FILES["file"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $fileExtensions = array("jpg", "mov", "mp3", "mp4", "msg", "nes", "otf", "jsp", "key", "kml", "lnk", "log", "pct", "pdb", "pdf", "pif", "pkg", "png", "pps", "ppt", "prf",  "sql", "svg", "swf", "sys",  "tif", "ttf", "txt", "wav", "wma", "wmv", "xll", "xls", "zip", "docx",  "pptx");
  // Check file size
  if ($_FILES["file"]["size"] > 2 * 1000 * 1024) {
    http_response_code(400);
    $response->msg = "Sorry, your file is too large. max is 2mb!";
    $uploadOk = 0;
  } else if (
    !in_array($imageFileType, $fileExtensions)
  ) {
    http_response_code(400);
    $response->msg = "Sorry,format not allowed.";
    $uploadOk = 0;
  } else if ($uploadOk == 1) {
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
      http_response_code(201);
      $response->url = base_url(true) . '/uploads/' . $_POST["appname"] . '/' . htmlspecialchars($date->getTimestamp() . '-' . basename($_FILES["file"]["name"]));
    } else {
      http_response_code(400);
      $response->msg = "Sorry, there was an error uploading your file.";
    }
  }
} else {
  http_response_code(400);
  $response->msg = "Please set appname and file";
}
header('Content-Type: application/json');
echo json_encode($response);
?>
