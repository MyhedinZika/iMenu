<?php
include('../includes/class.session.php');

$user = new SESSION();


$categoryId = $_POST['category_id'];


$user->deleteCategory($categoryId);

if (mysql_error()) {
  $result['error'] = mysql_error();
  $result['result'] = 0;
} else {
  $result['error'] = '';
  $result['result'] = 1;
}
echo json_encode($result);

?>