<?php

include '../connect.php';

$userId = filterRequest('user_id');

$data = getAllData('cartview', "cart_userid = $userId", null, false);

$stmt = $con->prepare("SELECT cart_userid, SUM(countitems) as totalCount, SUM(itemsprice) as totalprice
FROM `cartview`
where cart_userid = $userId
GROUP BY cart_userid;");
$stmt->execute();
$count = $stmt->fetch(PDO::FETCH_ASSOC);
$count['totalCount'] = (int) $count['totalCount'];

echo json_encode([
'status' => 'success',
'dataCart' => $data,
'countprice' => $count,
]);
