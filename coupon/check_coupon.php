<?php

include '../connect.php';

$couponName = filterRequest('coupon_name');

$now = date('Y-m-d H:i:s');

$subquery = "coupon_name = '$couponName' AND `expire_date` > '$now' AND `coupon_count` > 0";

getData('coupon', "$subquery");
