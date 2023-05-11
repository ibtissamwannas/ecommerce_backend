<?php
include "../connect.php";

$email = filterRequest("email");
$verifyCode = filterRequest("verifycode");

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = '$email' AND users_verify_code = '$verifyCode'");
$stmt->execute();
$count = $stmt->rowCount();

result($count,"none","none");


?>