<?php
include "../connect.php";

$userId = filterRequest("user_id");

getAllData("myfavorite","favorite_userid = ?" , array($userId));

?>