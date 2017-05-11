<?php

include('../includes/class.session.php');

$user = new SESSION();


$categoryId = $_POST['category_id'];
$category = $user->getCategory($categoryId);

$array = array();

$array['category_id'] = $category['categoryId'];
$array['name'] = $category['name'];

echo json_encode($array);

?>