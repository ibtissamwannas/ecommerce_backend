<?php

include '../connect.php';

$address_id = filterRequest('id');

deleteData('address', "id=$address_id");
