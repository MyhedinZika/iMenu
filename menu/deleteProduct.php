<?php
include('../includes/class.session.php');

$user = new SESSION();


$productId=$_POST['product_id'];



$user->deleteProduct($productId);

if(mysql_error()){
	$result['error']=mysql_error();
	$result['result']=0;
}else{
	$result['error']='';
	$result['result']=1;
}
echo json_encode($result);

?>