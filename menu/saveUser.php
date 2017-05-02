<?php
include('../includes/class.session.php');

$user = new SESSION();



$userId = $_POST['user_id'];
$name = $_POST['name'];
//var_dump($_POST);
$crud=$_POST['crud'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$role = $_POST['role'];


//echo $categoryIDFK;

//echo ("test");

if($crud == 'E'){
	$userCheck = $user->checkIfUserExists($name, $email, $phone);
	if($userCheck == false){
	$user->editUser($userId,$name,$email, $phone, $role);
	
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
