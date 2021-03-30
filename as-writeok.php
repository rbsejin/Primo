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
    session_start();


    if (!isset($_SESSION['id'])) {
        echo '다시 로그인해주세요.';
        die();
    }

    $conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");

    $userid = $_SESSION["id"];
    $title = $_POST["bdTitle"];
    $content = $_POST["bdContent"];

    $sql = "INSERT INTO as_board (userid, title, content) VALUES ('$userid', '$title', '$content')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '글 등록';
    } else {
        echo '글을 등록하지 못했습니다.';
        error_log(mysqli_error($conn));
    }

    mysqli_close($conn);
    print "<hr/><a href='as-write.php'>글쓰기 페이지로 이동하기</a>";
?>
</body>
</html>

