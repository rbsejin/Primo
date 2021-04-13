<?php
    $conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");

    session_start();
    $userId = $_SESSION["id"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phone_number"];
    $postcode = $_POST["postcode"];
    $address = $_POST["address"];
    $detailAddress = $_POST["detailAddress"];
    $extraAddress = $_POST["extraAddress"];

    $sql = "UPDATE user SET email = '$email' WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE user SET phone_number = '$phoneNumber' WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE user SET postcode = '$postcode' WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE user SET address = '$address' WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE user SET detail_address = '$detailAddress' WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);
  
    $sql = "UPDATE user SET extra_address = '$extraAddress' WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>alert('회원 정보를 수정했습니다.');</script>";
    } else {
        echo "<script>alert('회원 정보를 수정하지 못했습니다.');</script>";
    }
    echo "<meta http-equiv='refresh' content='0; url=modify.php'>";
