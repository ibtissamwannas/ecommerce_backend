<?php
include "../connect.php";

$email = filterRequest("email");
$verifyCode = rand(10000,99999);

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ?");
$stmt->execute(array($email));
$count = $stmt->rowCount();
result($count,"none","Email not found");

if($count>0){
    $data = array("users_verify_code" => $verifyCode);
    updateData("users",$data,"users_email = '$email'",false);
    sendEmail($email,"verifrification code","verify Code = $verifyCode");
}
?>