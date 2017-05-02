<?php
include('../includes/class.session.php');

$user = new SESSION();



$ingredientId = $_POST['ingredient_id'];
$name = $_POST['name'];

$crud=$_POST['crud'];


if($crud=='N'){
	//var_dump($_POST['name']);
	$user->addIngredient($name);
	if(mysql_error()){
		$result['error']=mysql_error();
		$result['result']=0;
	}else{
		$result['error']='';
		$result['result']=1;
	}
	

}else if($crud == 'E'){
	$user->editIngredient($ingredientId,$name);
	if(mysql_error()){
		$result['error']=mysql_error();
		$result['result']=0;
	}else{
		$result['error']='';
		$result['result']=1;
	}
}else{

	$result['error']='Invalid Order';
	$result['result']=0;
}
$result['crud']=$crud;
echo json_encode($result);


?>
