<?php
include('../includes/class.session.php');

$user = new SESSION();


$sizeId = $_POST['size_id'];


$user->deleteSize($sizeId);

if (mysql_error()) {
  $result['error'] = mysql_error();
  $result['result'] = 0;
} else {
  $result['error'] = '';
  $result['result'] = 1;
}
echo json_encode($result);

?>