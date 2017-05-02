<?php
include('../includes/class.session.php');

$user = new SESSION();



$sizeId = $_POST['size_id'];
$name = $_POST['name'];
//var_dump($_POST);
$crud=$_POST['crud'];
$categoryIDFK = $_POST['categoryIDFK'];

//echo $categoryIDFK;

//echo ("test");

$checkSize = $user->checkIfSizeExists($name,$categoryIDFK);
if($crud=='N'){
	
//	echo $checkSize;
	if($checkSize == false){
	$user->addSize($name,$categoryIDFK);
	if(mysql_error()){
		$result['error']=mysql_error();
		$result['result']=0;
	}else{
		$result['error']='';
		$result['result']=1;
	}

	}

	
	else{
		$result['error']='';
		$result['result']=2;
	}
	

}else if($crud == 'E'){
	if($checkSize == false){
	$user->editSize($sizeId,$name,$categoryIDFK);
	if(mysql_error()){
		$result['error']=mysql_error();
		$result['result']=0;
	}else{
		$result['error']='';
		$result['result']=1;
	}
}
else{
		$result['error']='';
		$result['result']=2;
	}
}else{

	$result['error']='Invalid Order';
	$result['result']=0;
}
$result['crud']=$crud;
echo json_encode($result);


?>
