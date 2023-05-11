<?php
include "../connect.php";


$email = filterRequest("email");
$password = sha1($_POST["password"]);

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? AND users_password = ?");
$stmt->execute(array($email,$password));
$count = $stmt->rowCount();
result($count,"none","email or password are not correct");
?>