<?php

include '../connect.php';

$userId = filterRequest('user_id');
$addreddId = filterRequest('address_id');
$ordersType = filterRequest('orders_type');
$priceDevlivery = filterRequest('price_delivery');
$ordrePrice = filterRequest('order_price');
$couponId = filterRequest('coupon_id');
$paymentMethod = filterRequest('payment_method');
$coupon_discount = filterRequest('coupon_discount');

if ($ordersType == '1') {
    $priceDevlivery = 0;
}

$totalprice = $priceDevlivery + $ordrePrice;
$now = date('Y-m-d H:i:s');

$subquery = "coupon_id = '$couponId' AND `expire_date` > '$now' AND `coupon_count` > 0";

$dis = getData('coupon', "$subquery", null, false);

if ($dis > 0) {
    $totalprice = $totalprice - ($totalprice * $coupon_discount) / 100;
    $stmt = $con->prepare('UPDATE `coupon` SET `coupon_count` = `coupon_count` - 1 WHERE `coupon_id` = :couponId');
    $stmt->bindParam(':couponId', $couponId, PDO::PARAM_INT); // Assuming $couponId is an integer
    $stmt->execute();
}

$data = [
    'user_id' => $userId,
    'orders_address' => $addreddId,
    'orders_type' => $ordersType,
    'orders_price_delivery' => $priceDevlivery,
    'orders_price' => $ordrePrice,
    'orders_coupon' => $couponId,
    'payment_type' => $paymentMethod,
    'order_totalprice' => $totalprice,
];

$count = insertData('orders', $data, false);

if ($count > 0) {
    $stmt = $con->prepare('SELECT MAX(id) FROM `orders`');
    $stmt->execute();
    $maxid = $stmt->fetchColumn();

    $data = ['card_orders' => $maxid];
    updateData('cart', $data, "`cart_userid` = '$userId' AND `card_orders` = 0");
} else {
    echo json_encode(['status' => 'error']);
}
