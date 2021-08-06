
<?php
$target_dir = "../" . $_POST["appname"] . '/';
$date = new DateTime();
$target_file = $target_dir . $date->getTimestamp() . '-' . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
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
if (isset($_POST["appname"])) {
  $check = getimagesize($_FILES["file"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["file"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
  ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
      echo base_url(true) . $_POST["appname"] . '/' . htmlspecialchars($date->getTimestamp() . '-' . basename($_FILES["file"]["name"]));
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
?>
