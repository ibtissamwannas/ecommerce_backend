<?php

include '../connect.php';

$address_id = filterRequest('id');

deleteData('address', "address_id=$address_id");
