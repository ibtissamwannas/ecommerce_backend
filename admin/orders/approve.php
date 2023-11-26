<?php

include '../../connect.php';

$ordreId = filterRequest('order_id');
$userId = filterRequest('user_id');

$data = [
    'order_status' => 1,
];
updateData('orders', $data, "`id` = $ordreId AND `order_status` = 0");

insertNotify($userId, 'Success', 'The Order Has been Approved', "users$userId", 'none', 'orderRefresh');
