<?php
include "../connect.php";

$userId = filterRequest("user_id");
$itemsId = filterRequest("items_id");

$data = array(
    "favorite_userid" => $userId,
    "favorite_itemid"=> $itemsId,
);

insertData("favorite",$data);

?>