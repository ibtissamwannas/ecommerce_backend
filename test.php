<?php
include "./connect.php";
//
// $table = "users";

// $data = array(
//     "users_name"=>"sam",
//     "users_email"=>"sam@gmail.com",
//     "users_phone"=>"71116962",
//     "users_verify_code"=>"3242522",
// );
// $count = insertData($table, $data);


//
// $to = "ibtissamwannas21@gmail.com";
// $title = "hi";
// $body = "I am ibtissam";
// $header = "from: support@ibtissamwannas.com"."\n"."cc: ibtissam123@gmail.com";

// mail($to,$title,$body,$header);


//
// sendEmail("ibtissamwannas21@gmail.com","hi","from function");

getAllData(
    "users","1 = 1"
);
?>