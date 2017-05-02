<?php
session_start();
require_once '../includes/class.session.php';
$user = new SESSION();

if (!$user->is_logged_in()) {
  $user->redirect('../pages/login.php');
}

if ($user->is_logged_in() != "") {
  $user->logout();
  $user->redirect('../pages/login.php');
}
?>