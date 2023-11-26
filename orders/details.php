<?php

include '../connect.php';

$orderId = filterRequest('id');

getAllData('orderDetails', " `card_orders` = '$orderId' ");
