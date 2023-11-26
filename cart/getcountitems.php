<?php

include '../connect.php';

$userId = filterRequest('user_id');
$itemsId = filterRequest('items_id');

$stmt = $con->prepare("SELECT COUNT(cart.cart_userid) FROM cart where `cart_itemid` = $itemsId AND `cart_userid` = $userId AND `card_orders` = 0");

$stmt->execute();

$count = $stmt->rowCount();

$data = $stmt->fetchColumn();

if ($count > 0) {
    echo json_encode(['status' => 'success', 'data' => $data]);
} else {
    echo json_encode(['status' => 'success', 'data' => '0']);
}
