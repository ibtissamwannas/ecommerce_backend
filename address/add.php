<?php

include '../connect.php';

$user_id = filterRequest('user_id');
$city = filterRequest('city');
$street = filterRequest('street');
$lat = filterRequest('lat');
$lon = filterRequest('lon');
$name = filterRequest('name');

$data = [
        'address_user_id' => $user_id,
        'city' => $city,
        'street' => $street,
        'lat' => $lat,
        'lon' => $lon,
        'name' => $name,
];
insertData('address', $data);
