<?php
include "../connect.php";

$email = filterRequest("email");
$verifyCode = rand(10000,99999);

$data = array(
    "users_verify_code"=>$verifyCode
);

updateData("users",$data,"users_email = '$email'");

sendEmail($email,"verifyCode","verify Code = $verifyCode");



?>