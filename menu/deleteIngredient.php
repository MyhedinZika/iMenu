<?php
include('../includes/class.session.php');

$user = new SESSION();


$ingredient_id=$_POST['ingredient_id'];



$user->deleteIngredient($ingredient_id);

if(mysql_error()){
	$result['error']=mysql_error();
	$result['result']=0;
}else{
	$result['error']='';
	$result['result']=1;
}
echo json_encode($result);

?>