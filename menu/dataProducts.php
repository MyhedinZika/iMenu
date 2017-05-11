<?php
include "config.php";

$query = mysql_query("SELECT @rownum := @rownum + 1 AS urutan,i.*
	FROM product i, 
	(SELECT @rownum := 0) r");
$data = array();
while ($r = mysql_fetch_assoc($query)) {
  $data[] = $r;
}
$i = 0;
foreach ($data as $key) {
  // add new button
  $data[$i]['button'] = '<button type="submit" product_id="' . $data[$i]['productId'] . '" class="btn btn-primary btnedit" ><i class="fa fa-edit"></i></button> 
							   <button type="submit" product_id="' . $data[$i]['productId'] . '" product_name="' . $data[$i]['name'] . '" class="btn btn-primary btnhapus" ><i class="fa fa-remove"></i></button>';
  $i++;
}

$datax = array('data' => $data);
echo json_encode($datax);
?>