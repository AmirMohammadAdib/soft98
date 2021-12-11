<?php 
include "../database/db.php";
$amount = $_GET['amount'];


$wallet = $conn->prepare('UPDATE users SET wallet=? WHERE email=?');
$wallet->bindValue(1, $amount);
$wallet->bindValue(2, $_SESSION['email']);
$wallet->execute();

?>