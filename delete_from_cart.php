<!-- 카트에 제품을 추가한다. -->
<?php
// 이전 페이지 정보 저장
$prevPage = $_SERVER['HTTP_REFERER'];

// 로그인 세션확인
session_start();
if (!isset($_SESSION['id'])) {
    echo '다시 로그인해주세요.';
    die();
}

$userId = $_SESSION['id'];
$cartId = $_POST['cart_id'];

// DB 연결
$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

$sql = "DELETE FROM cart WHERE id = $cartId";
$result = mysqli_query($conn, $sql);
if (!$result) {
    mysqli_close($conn);
    die();
}

mysqli_close($conn);

// 이전 페이지로 이동

header('location:' . $prevPage);
?>