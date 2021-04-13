<?php
$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");

session_start();
$userId = $_SESSION["id"];
$password = $_POST['password'];

include "./password.php";
$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE user SET pass = '$hash' WHERE id = '$userId'";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('비밀번호를 수정했습니다.');</script>";
} else {
    echo "<script>alert('비밀번호를 수정하지 못했습니다.');</script>";
}
echo "<meta http-equiv='refresh' content='0; url=my_page.php'>";
