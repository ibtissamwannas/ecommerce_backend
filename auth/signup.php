<?php
include "../connect.php";

$username = filterRequest("username");
$email = filterRequest("email");
$password = sha1($_POST["password"]);
$phone = filterRequest("phone");
$verifyCode = rand(10000,99999);

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? OR users_phone = ?");
$stmt->execute(array($email,$phone));
$count = $stmt->rowCount();
if($count>0){
    printFailure("phone or email already found");
}else{
    $data = array(
        "users_name"=>$username,
        "users_email"=>$email,
        "users_password"=>$password,
        "users_phone"=>$phone,
        "users_verify_code"=>$verifyCode,
    );
    sendEmail($email,"verifyCode","verify Code = $verifycode");
    insertData("users",$data);
}
?>