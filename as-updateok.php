<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AS문의</title>
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
    $number = $_POST["number"];

    $sql = "UPDATE as_board SET title = '$title' WHERE number = $number";
    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE as_board SET content = '$content' WHERE number = $number";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '글 수정';
    } else {
        echo '글을 수정하지 못했습니다.';
        error_log(mysqli_error($conn));
    }


    $sql = "SELECT number FROM as_board WHERE number = '$number' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $array = mysqli_fetch_array($result);	
    $view_num = $array['number']; 	

    mysqli_close($conn);
    echo "<meta http-equiv='refresh' content='0; url=as-view.php?number={$view_num}'>";
?>
</body>
</html>
