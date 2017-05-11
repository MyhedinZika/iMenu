<?php
include "config.php";
$query = mysql_query("SELECT @rownum := @rownum + 1 AS urutan,i.*
	FROM ingredient i, 
	(SELECT @rownum := 0) r");
$data = array();
while ($r = mysql_fetch_assoc($query)) {
  $data[] = $r;
}
$i = 0;
foreach ($data as $key) {
  // add new button

  $data[$i]['button'] = '<div class="buttons"><button type="submit" ingredient_id="' . $data[$i]['ingredientId'] . '" class="btn btn-primary btnedit" ><i class="fa fa-edit"></i></button> 
							   <button type="submit" ingredient_id="' . $data[$i]['ingredientId'] . '" name_cust="' . $data[$i]['i_name'] . '" class="btn btn-primary btnhapus" ><i class="fa fa-remove"></i></button><div>';
  $i++;
}

$datax = array('data' => $data);
echo json_encode($datax);
?>