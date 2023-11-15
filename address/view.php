<?php

include '../connect.php';

$user_id = filterRequest('user_id');

getAllData('address', "user_id = $user_id");
