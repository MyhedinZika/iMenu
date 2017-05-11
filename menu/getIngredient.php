<?php

include('../includes/class.session.php');

$user = new SESSION();


$ingredient_id = $_POST['ingredient_id'];
$ingredient = $user->getIngredient($ingredient_id);

$array = array();

$array['ingredient_id'] = $ingredient['ingredientId'];
$array['i_name'] = $ingredient['i_name'];

echo json_encode($array);

?>