<?php

include '../connect.php';

$search = filterRequest('search');

getAllData('itemsview', "item_name LIKE '%$search%' OR item_name_ar LIKE '%$search%'");
