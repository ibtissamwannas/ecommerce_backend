<?php
include '../connect.php';

$email = filterRequest("email");
$passwrd = sha1($_POST['password']);

$data = array("users_password"=>$passwrd);
updateData("users",$data,"users_email= $email");
?>