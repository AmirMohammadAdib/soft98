<?php 
include "../database/db.php";
$user = $_GET['user'];
$course = $_GET['course'];
$total = $_GET['total'];

$update = $conn->prepare('UPDATE basket SET status=1 WHERE user_id=? OR course_id=?');
$update->bindValue(1, $user);
$update->bindValue(2, $course);
$update->execute();

if (!isset($_POST['transid'])) {
    return;
}
$data = [
    'pin' => 'YourGatewayPinCode',
    'amount' => $total,
    'transid' => $_POST['transid']
];
$data = json_encode($data);
$ch = curl_init('https://panel.aqayepardakht.ir/api/verify');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data))
);
$result = curl_exec($ch);
curl_close($ch);
if ($result === "1") {
 // پرداخت با موفقیت انجام شده است
} elseif ($result === "0") {
 //    پرداخت انجام نشده است
}

header('location: ../index.php')

?>