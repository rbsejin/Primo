<?php

// 이전 페이지 정보 저장
//$prevPage = $_SERVER['HTTP_REFERER'];

// 관리자 아이디 확인
session_start();
if (!isset($_SESSION['id'])) {
    echo '다시 로그인해주세요.';
    die();
}

$userId = $_SESSION['id'];

// DB연결
$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

// post: item_id 가져오기
$itemId = $_POST['item_id'];
$school = $_POST['school'];

// DB에서 item_id 삭제
$sql = "DELETE FROM item WHERE id = $itemId";
$result = mysqli_query($conn, $sql);
if (!$result) {
    mysqli_close($conn);
    die();
}

// DB 종료
mysqli_close($conn);

// 이전 페이지로 이동
$prevPage = "location: product_manage.php?school=$school";
header($prevPage);

?>