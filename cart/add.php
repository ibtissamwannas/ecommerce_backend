<?php

include '../connect.php';

$userId = filterRequest('user_id');
$itemsId = filterRequest('items_id');

$count = getData('cart', "cart_itemid = '$itemsId' AND cart_userid = '$userId' AND `card_orders` = 0", null, false);

$data = [
    'cart_itemid' => $itemsId,
    'cart_userid' => $userId,
];
insertData('cart', $data);
