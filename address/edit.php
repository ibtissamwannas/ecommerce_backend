<?php

include '../connect.php';

$address_id = filterRequest('id');
$city = filterRequest('city');
$street = filterRequest('street');
$lat = filterRequest('lat');
$lon = filterRequest('lon');
$name = filterRequest('name');

$data = [
    'city' => $city,
    'street' => $street,
    'lat' => $lat,
    'lon' => $lon,
    'name' => $name,
];

updateData('address', $data, "id=$address_id");
