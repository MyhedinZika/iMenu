<?php
include('../includes/class.session.php');

$user = new SESSION();


var_dump($_POST);
$product_id = $_POST['product_id'];
$name = $_POST['pname'];
//var_dump($_POST);
$crud=$_POST['crud'];

var_dump($_FILES);

$imgFile = $_FILES['image']['name'];
$tmp_dir = $_FILES['image']['tmp_name'];
$imgSize = $_FILES['image']['size'];

var_dump($_FILES);
if(!isset($_FILES["image"])){
    echo "ERROR: no image revived";
    die();
}
$categoryIDFK = $_POST['categoryIDFK'];

if (empty($name)) {
      $errMSG = "Please Enter Name.";
    } else if (empty($imgFile)) {
      $errMSG = "Please Select Image File.";
    } else {
      $upload_dir = __DIR__ . '/product_images/'; // upload directory 

      $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

      // valid image extensions
      $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

      // rename uploading image
      $userpic = rand(1000, 1000000) . "." . $imgExt;
      echo $userpic;

      // allow valid image file formats
      if (in_array($imgExt, $valid_extensions)) {
        // Check file size '5MB'
        if ($imgSize < 5000000) {
          move_uploaded_file($tmp_dir, $upload_dir . $userpic);
        } else {
          $errMSG = "Sorry, your file is too large.";
        }
      } else {
        $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      }
    }
    if (!isset($errMSG)) {

    	$user->addProduct($name,$userpic,$categoryIDFK);
   }

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
