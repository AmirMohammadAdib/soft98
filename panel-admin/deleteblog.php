<?php 
include "../database/db.php";

$id = $_GET['id'];

$delete = $conn->prepare('DELETE FROM blog WHERE id=?');
$delete->bindValue(1, $id);
$delete->execute();

header('location: add_blog.php');

?>