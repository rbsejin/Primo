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

// DB 연결
$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

$itemId = $_POST['item_id'];
$size = $_POST['size'];
$quantity = $_POST['quantity'];

// 카트에 같은 제품이 있는지 확인한다.
$sql = "SELECT cart.id, cart.size, cart.quantity, cart.user_id, cart.item_id, item.image, item.school, item.name, item.sex, item.price FROM cart LEFT JOIN item ON item_id = item.id WHERE user_id = '$userId' AND cart.item_id = $itemId AND cart.size = $size";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "쿼리 오류";
    mysqli_close($conn);
    die();
}

$row = mysqli_fetch_array($result);

if ($row) {
    // 기존 제품에 수량을 추가한다.
    $cartId = $row['id'];
    $sql = "UPDATE cart SET quantity = quantity + " . $quantity . " WHERE id = $cartId";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "DB 수정 실패";
        mysqli_close($con);
        die();
    }
} else {
    // 카트에 새로운 제품을 추가한다.
    $sql = "INSERT INTO cart (size, quantity, user_id, item_id) VALUES ($size, $quantity, '$userId', $itemId)";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "DB 삽입 실패";
        mysqli_close($conn);
        die();
    }
}

mysqli_close($conn);

// 이전 페이지로 이동

$isMovingToCart = $_POST['is_moving_to_cart'];
if ($isMovingToCart == "true") {
    header('location: cart.php');
} else {
    header('location:' . $prevPage);
}
?>