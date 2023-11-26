<?php

include '../connect.php';

$userId = filterRequest('user_id');

getAllData('orderView', " `user_id` = '$userId' ");
