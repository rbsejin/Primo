<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");

    // if (!$conn) {
    //     echo 'db에 연결하지 못했습니다.'. mysqli_connect_error();
    // } else {
    //     echo 'db에 접속했습니다!!!';
    // }


    $id = $_POST["id"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phone_number"];
    $postcode = $_POST["postcode"];
    $address = $_POST["address"];
    $detailAddress = $_POST["detailAddress"];
    $extraAddress = $_POST["extraAddress"];

    include"./password.php";
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (id, pass, name, email, phone_number, postcode, address, detail_address, extra_address) VALUES ('$id', '$hash', '$name', '$email', '$phoneNumber', '$postcode', '$address', '$detailAddress', '$extraAddress')";
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '회원가입 성공';
        echo "<meta http-equiv='refresh' content='0; url=login.php'>";
    } else {
        echo '회원가입 실패';
        error_log(mysqli_error($conn));
        echo "<meta http-equiv='refresh' content='0; url=join.php'>";
    }
?>
</body>
</html>

