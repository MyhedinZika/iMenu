<?php

include('../includes/class.session.php');

$user = new SESSION();


$sizeId = $_POST['size_id'];
$size = $user->getSize($sizeId);

$array = array();

$array['size_id'] = $size['sizeId'];
$array['name'] = $size['name'];
$array['categoryIDFK'] = $size['CategoryIDFK'];

echo json_encode($array);

?>