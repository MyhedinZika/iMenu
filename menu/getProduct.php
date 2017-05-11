<?php

include('../includes/class.session.php');

$user = new SESSION();


$productId = $_POST['product_id'];
$product = $user->getProduct($productId);

$array = array();

$array['product_id'] = $product['productId'];
$array['name'] = $product['name'];
$array['photo'] = $product['photo'];
$array['categoryIDFK'] = $product['categoryIdFK'];

echo json_encode($array);

?>