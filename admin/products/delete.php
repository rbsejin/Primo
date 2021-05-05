<?php
include_once('../Item.php');

$school = $_POST['school'];
$sex = $_POST['sex'];
$name = $_POST['name'];
$price = $_POST['price'];

$quantities = $_POST['quantities'];
$sizes = $_POST['sizes'];

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

$sql = "DELETE FROM item WHERE ";
$result = mysqli_query($conn, $sql);
