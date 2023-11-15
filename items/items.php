<?php

include '../connect.php';

$categoryId = filterRequest('id');

// getAllData("itemsview", "categories_id = $categoryId");

$userId = filterRequest('user_id');

$stmt = $con->prepare("SELECT itemsview.*, 1 as favorite,(item_price - (item_price * item_discount / 100))as itemspricedisscount FROM itemsview 
INNER JOIN favorite ON favorite.favorite_itemid = itemsview.item_id And favorite.favorite_userid = $userId
where categories_id = $categoryId
UNION ALL
SELECT * , 0 as favorite,(item_price - (item_price * item_discount / 100))as itemspricedisscount from itemsview
where categories_id = $categoryId
And item_id NOT IN (SELECT itemsview.item_id FROM itemsview 
INNER JOIN favorite on favorite.favorite_itemid = itemsview.item_id And favorite.favorite_userid = $userId)");

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();

if ($count > 0) {
    echo json_encode(['status' => 'success', 'data' => $data]);
} else {
    echo json_encode(['status' => 'failure']);
}
