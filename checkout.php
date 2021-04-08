<!doctype html>
<html lang="zxx">

<?php
include_once('header.php');
?>

<?php
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
?>

<main>
    <!-- Hero Area Start-->
    <div class="slider-area ">
        <div class="single-slider slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>결제</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================Checkout Area =================-->
    <section class="cart_area section_padding">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">상품정보</th>
                                <th scope="col">상품금액</th>
                                <th scope="col">수량</th>
                                <th scope="col">결제 금액</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalPrice = 0;

                            while ($row = mysqli_fetch_array($result)) {
                                $cartId = $row['id'];
                                $size = $row['size'];
                                $quantity = $row['quantity'];
                                $itemId = $row["item_id"];
                                $itemImage = $row['image'];
                                $itemSchool = $row['school'];
                                $itemName = $row['name'];
                                $productName = "$itemSchool $itemName $size";
                                $itemPrice = $row['price'];
                                $subTotal = $itemPrice * $quantity;
                                $totalPrice += $subTotal;
                            ?>
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="assets/img/gallery/market/<?= "$itemSchool/$itemImage" ?>" alt="" />
                                            </div>
                                            <div class="media-body">
                                                <p><?= "$productName" ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $itemPrice ?>원</td>
                                    <td><?= $quantity ?></td>
                                    <td><?= $itemPrice * $quantity ?>원</td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <h5>총 결제금액</h5>
                                </td>
                                <td><?= $totalPrice ?>원</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <form action="checkout.php" method="post">
                        <div class="checkout_btn_inner float-right">
                            <a class="btn_1" href="#">선택상품 주문</a>
                            <button type="submit" class="btn_1">전체상품 주문</button>
                            <a class="btn_1" href="#">쇼핑 계속하기</a>
                        </div>
                    </form> -->
                </div>
            </div>
    </section>
    <!--================End Cart Area =================-->
</main>>

<?php
include_once('footer.php');
?>

</html>