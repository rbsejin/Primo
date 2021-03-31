<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>
<?php

   

        // 원래 페이지로 이동
        session_start();

        if (!isset($_SESSION['id'])) {
            echo '세션이 등록되어 있지 않습니다.';
            die();
        } else {
            echo $_SESSION['city'].'세션이 등록되어 있습니다.';
            session_unset();
            print_r($_SESSION);

        }

        echo "로그인 아웃성공";
        echo "<meta http-equiv='refresh' content='0; url=index.php'>";
?>
</body>
</html>

