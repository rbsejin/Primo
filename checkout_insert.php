<?php
session_start();
if (!isset($_SESSION['id'])) {
    echo '다시 로그인해주세요.';
    die();
}

$userId = $_SESSION['id'];

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

$cartIds = $_POST['cart_ids'];
$cartIdSql = "1 != 1";

foreach ($cartIds as $cartId) {
    $cartIdSql = "$cartIdSql OR cart.id = $cartId";
}

$sql = "SELECT cart.id, cart.size, cart.quantity, cart.user_id, cart.item_id, item.image, item.school, item.name, item.sex, item.price FROM cart LEFT JOIN item ON item_id = item.id WHERE user_id = '$userId' AND ($cartIdSql)";
$result = mysqli_query($conn, $sql);

$totalPrice = $_POST['totalPrice'];
$deliveryCharge = $_POST['deliveryCharge'];
$totalAmount = $_POST['total_amount'];
$total_quantity = 0;
$paytype = "카카오페이";
$purchaseIds = array();

$recipient = $_POST['name'];
$postcode = $_POST['postcode'];
$address = $_POST['address'];
$detailAddress = $_POST['detailAddress'];
$extraAddress = $_POST["extraAddress"];
// $totalAmount = $totalPrice + $deliveryCharge;

$sql = "INSERT INTO pay_info (recipient, postcode, address, detail_address, extra_address, item_price, delivery_charge, total_price, paytype, user_id)
VALUES ('$recipient', '$postcode', '$address', '$detailAddress', '$extraAddress', $totalPrice, $deliveryCharge, $totalAmount, '$paytype', '$userId')";
$result2 = mysqli_query($conn, $sql);
if (!$result2) {
    echo "<script>alert('실패');</script>";
    mysqli_close($conn);
    die();
}

$sql = "SELECT LAST_INSERT_ID() FROM pay_info";
$result2 = mysqli_query($conn, $sql);
$payId = 0;
if ($row2 = mysqli_fetch_row($result2)) {
    $payId = $row2[0];
}

while ($row = mysqli_fetch_array($result)) {
    $size = $row['size'];
    $quantity = $row['quantity'];
    $itemId = $row["item_id"];
    $itemImage = $row['image'];
    $itemSchool = $row['school'];
    $itemName = $row['name'];
    $itemPrice = $row['price'];
    $subtotal = $itemPrice * $quantity;

    $sql = "INSERT INTO purchase_list (size, quantity, state, subtotal, user_id, item_id, pay_id) VALUES ($size, $quantity, '결제완료', $subtotal, '$userId', $itemId, $payId)";
    $result2 = mysqli_query($conn, $sql);

    if (!$result2) {
        echo "<script>alert('실패');</script>";
        die();
    }

    $sql = "SELECT LAST_INSERT_ID() FROM purchase_list";
    $result2 = mysqli_query($conn, $sql);
    if ($row2 = mysqli_fetch_row($result2)) {
        array_push($purchaseIds, $row2[0]);
    }
}

foreach ($cartIds as $cartId) {
    $sql = "DELETE FROM cart WHERE id = '$cartId'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        assert("삭제 실패");
    }
}

?>

<form id="frmData" name="frmData" action="#" method="post">
    <input name="pay_id" value="<?= $payId ?>" />
</form>

<script>
    var frmData = document.frmData;
    frmData.action = "checkout_complete.php";
    frmData.submit();
</script>