<?php
include('../includes/class.session.php');

$user = new SESSION();


$categoryId = $_POST['category_id'];
$name = $_POST['name'];

$crud = $_POST['crud'];


if ($crud == 'N') {
  $categoryCheck = $user->checkIfCategoryExists($name);
  if ($categoryCheck == false) {
    $user->addCategory($name);
    if (mysql_error()) {
      $result['error'] = mysql_error();
      $result['result'] = 0;
    } else {
      $result['error'] = '';
      $result['result'] = 1;
    }

  } else {
    $result['error'] = '';
    $result['result'] = 2;
  }


} else if ($crud == 'E') {
  $categoryCheck = $user->checkIfCategoryExists($name);
  if ($categoryCheck == false) {
    $user->editCategory($categoryId, $name);
    if (mysql_error()) {
      $result['error'] = mysql_error();
      $result['result'] = 0;
    } else {
      $result['error'] = '';
      $result['result'] = 1;
    }
  } else {
    $result['error'] = '';
    $result['result'] = 2;
  }


} else {

  $result['error'] = 'Invalid Order';
  $result['result'] = 0;
}
$result['crud'] = $crud;
echo json_encode($result);


?>
