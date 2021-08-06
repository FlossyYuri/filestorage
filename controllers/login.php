<?php
session_start();
$username = "admin";
$password = "admin";
if (isset($_POST["username"])) {
  if ($_POST["username"] == $username && $_POST["password"] == $password) {
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;

    header('Location: ../views/storage.php');
  } else {
    header('Location: ../');
  }
} else {
  header('Location: ../');
}
