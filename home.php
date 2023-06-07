<?php
include "connect.php";

$alldata=array();

$categories = getAllData("categories",null,null,false);

$alldata['status'] = "success";
$alldata['categories'] = $categories;

echo json_encode($alldata);
?>