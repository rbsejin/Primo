<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
<?php
    $conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");

    $id = $_POST["id"];
    $password = $_POST["password"];

    // table에서 글 조회
    $sql = "SELECT * FROM user WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $array = mysqli_fetch_array($result);	
    $hash_password = $array['pass']; 	

    if (password_verify($password, $hash_password)) {
        // 원래 페이지로 이동
        session_start();
        $_SESSION['id'] = 'rbsejin';

        if (!isset($_SESSION['id'])) {
            echo '세션이 등록되어 있지 않습니다.';
        } else {
            echo $_SESSION['id'].'세션이 등록되어 있습니다.';
            print_r($_SESSION);
        }

        echo "로그인 성공";
        echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    } else {
        // 로그인 페이지로 이동
        echo "로그인 실패";
        echo "<meta http-equiv='refresh' content='0; url=login.php'>";
    }
?>
</body>
</html>

