<?php
$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

$itemId = 10;
$sql = "SELECT * FROM item WHERE id = 1";
echo $sql;

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);

mysqli_close($conn);
die();
?>