<?php

include '../connect.php';

$userId = filterRequest('user_id');

getAllData('notification', " `user_id` = '$userId' ORDER BY '$userId' DESC ");
