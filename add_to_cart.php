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

// 카트에 추가할 제품을 조회한다.
$sql = "SELECT *, product.id AS product_id FROM product LEFT JOIN item ON product.item_id = item.id WHERE item.id = $itemId AND size = $size";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
if (!$row) {
    mysqli_close($conn);
    die();
}

// 제품의 정보를 변수에 대입한다.
$productId = $row['product_id'];
$productPrice = $row['price'];
$school = $row['school'];
$name = $row['name'];
$productName = $productName = $school . ' ' . $name;
$itemImage = $row['image'];

// 제품이 카트의 목록에 있는지 확인한다.
$sql = "SELECT * FROM cart WHERE user_id = '$userId' AND product_id = $productId";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_array($result)) {
    // 제품이 카트에 있으면 수량만 증가
    $sql = "UPDATE cart SET quantity = quantity + " . $quantity . " WHERE user_id = '$userId' AND product_id = $productId";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "DB 수정 실패";
        mysqli_close($conn);
        die();
    }
} else {
    // 제품이 카트에 없으면 새로 추가
    $sql = "INSERT INTO cart (product_id, quantity, user_id) VALUES ($productId, $quantity, '$userId')";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "DB 삽입 실패";
        mysqli_close($con);
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
