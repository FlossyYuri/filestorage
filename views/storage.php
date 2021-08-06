<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
?>
  <h1>File Storage</h1>
  <?php
  if (isset($_POST["submitfile"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["newfile"]["name"]);
    move_uploaded_file($_FILES["newfile"]["tmp_name"], $target_file);
  }
  if (isset($_GET["delete"])) {
    if (file_exists("uploads/" . $_GET["delete"])) {
      unlink("uploads/" . $_GET["delete"]);
      echo "<div class='alert'>File is deleted successfully.</div>";
    }
  }
  $dirpath = "uploads/*";
  $files = array();
  $files = glob($dirpath);
  usort($files, function ($x, $y) {
    return filemtime($x) < filemtime($y);
  });
  echo "<div>";
  foreach ($files as $item) {
    echo "<div class='filethumb'>";
    //echo "<div>" . $item . "</div>";
    echo "<a href='" . $item . "' target='_blank'><div><img style='width: 100px; height:100px; object-fit:contain;' src='" . $item . "' /></div>";
    echo "<div>" . str_replace("uploads/", "", $item) . "</div></a>";
    echo "<a href='?filestorage&delete=" . str_replace("uploads/", "", $item) . "'><div style='color: red; margin-top: 20px; font-size: 10px;'><i class='fa fa-trash'></i> Delete</div></a>";
    echo "</div>";
  }
  if (count($files) == 0) {
  ?>
    <p>You have no file here. Try to begin uploading using the upload form at the bottom of this page.</p>
  <?php
  }
  echo "</div>";
  ?>
  <div class="uploadform">
    <form method="post" enctype="multipart/form-data">
      <label><i class="fa fa-file"></i> Upload new files</label>
      <input class="fileinput" name="newfile" type="file">
      <input name="submitfile" type="submit" value="Upload">
    </form>
  </div>

<?php } ?>