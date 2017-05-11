<?php

include('../includes/class.session.php');

$user = new SESSION();


$userId = $_POST['user_id'];
$user = $user->getUser($userId);


$array = array();

$array['user_id'] = $user['userId'];
$array['Full_Name'] = $user['Full_Name'];
$array['Email'] = $user['Email'];
$array['Phone'] = $user['Phone'];
$array['isVerified'] = $user['isVerified'];
$array['userRole'] = $user['userRole'];


echo json_encode($array);

?>