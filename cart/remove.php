<?php

include '../connect.php';

$userId = filterRequest('user_id');
$itemsId = filterRequest('items_id');

$subquery = "SELECT id FROM `cart` WHERE `cart_itemid` = $itemsId AND `cart_userid` = $userId LIMIT 1";
$idResult = $con->query($subquery);
$row = $idResult->fetch(PDO::FETCH_ASSOC);
$id = $row['id'];

// Check if an ID was found before attempting deletion
if ($id) {
    deleteData('cart', "id = $id");
} else {
    echo json_encode(['status' => 'failure']);
}
