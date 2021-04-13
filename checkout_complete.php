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

$payId = $_POST['pay_id'];

$sql = "SELECT * FROM pay_info WHERE id = '$payId'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    mysqli_close($conn);
    die();
}

$row = mysqli_fetch_array($result);
if (!$row) {
    mysqli_close($conn);
    die();
}

$recipient = $row['recipient'];
$postcode = $row['postcode'];
$address = $row['address'];
$detail_address = $row['detail_address'];
$extra_address = $row['extra_address'];
$item_price = $row['item_price'];
$delivery_charge = $row['delivery_charge'];
$total_price = $row['total_price'];
$paytype = $row['paytype'];
$user_id = $row['user_id'];

$sql = "SELECT purchase_list.id, purchase_list.size, purchase_list.quantity, purchase_list.created,
purchase_list.state, purchase_list.subtotal, purchase_list.user_id, purchase_list.item_id,
item.school, item.name, item.price, item.image FROM purchase_list LEFT JOIN item ON item_id = item.id WHERE pay_id = $payId";
$result = mysqli_query($conn, $sql);
if (!$result) {
    mysqli_close($conn);
    die();
}

// $cartIds = $_POST['cart_ids'];
// $cartIdSql = "1 != 1";

// foreach ($cartIds as $cartId) {
//     $cartIdSql = "$cartIdSql OR cart.id = $cartId";
// }

// $sql = "SELECT cart.id, cart.size, cart.quantity, cart.user_id, cart.item_id, item.image, item.school, item.name, item.sex, item.price FROM cart LEFT JOIN item ON item_id = item.id WHERE user_id = '$userId' AND ($cartIdSql)";
// $result = mysqli_query($conn, $sql);

// $totalPrice = 0;
// $total_quantity = 0;
// $deliveryCharge = 2500;
// $paytype = "카카오페이";

// while ($row = mysqli_fetch_array($result)) {
//     $size = $row['size'];
//     $quantity = $row['quantity'];
//     $itemId = $row["item_id"];
//     $itemImage = $row['image'];
//     $itemSchool = $row['school'];
//     $itemName = $row['name'];
//     $itemPrice = $row['price'];
//     $subtotal = $itemPrice * $quantity;
//     $totalPrice += $subtotal;
//     $total_quantity += $quantity;

//     $sql2 = "INSERT INTO purchase_list (size, quantity, state, subtotal, delivery_charge, total_payment_amount, paytype, user_id, item_id) VALUES ($size, $quantity, '결제완료', $subtotal, $deliveryCharge, $totalPrice, '$paytype', '$userId', $itemId)";
//     $result2 = mysqli_query($conn, $sql2);

//     if (!$result2) {
//         echo "<script>alert('실패');</script>";
//         die();
//     }
// }

// $result = mysqli_query($conn, $sql);

?>

<main>
    <!-- Hero Area Start-->
    <div class="slider-area ">
        <div class="single-slider slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>결제 완료</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================Checkout Area =================-->
    <section class="checkout_area section_padding">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <div>
                        <h2>항상 이용해주셔서 감사합니다.</h2>
                    </div>
                    <br><br><br>
                    <div>
                        <h3>
                            <span>배송지 정보</span>
                        </h3>
                        <div>
                            <ul>
                                <li>받는 분 : <?= $recipient ?></li>
                                <li>
                                    <div>
                                        <span>주소 : </span>
                                        <span><?= "($postcode) $address, $detail_address $extra_address" ?></span>
                                        <span></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <br><br><br>
                    <div>
                        <h3>
                            <span>주문상품</span>
                        </h3>
                        <div>

                        </div>
                    </div>
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
                            $deliveryCharge = 2500;
                            $total_quantity = 0;
                            $item_name = "";

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
                                $subtotal = $itemPrice * $quantity;
                                $totalPrice += $subtotal;
                                $total_quantity += $quantity;
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
                                    <td><?= $subtotal ?>원</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div>
                        <h3>
                            <span>결제정보</span>
                        </h3>
                    </div>
                    <div class="order_box">
                        <h2>주문</h2>
                        <ul class="list list_2">
                            <li>
                                <a href="#">상품금액
                                    <span> <?= $totalPrice ?>원 </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">배송비
                                    <span> <?= $deliveryCharge ?>원 </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">총 결제금액
                                    <span> <?= $total_amount = $totalPrice + $deliveryCharge ?>원</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <br>
                    <div>
                        <span>결제수단: </span>
                        <span>카카오 페이 </span>
                        <span><?= $total_amount ?>원 </span>
                    </div>
                </div>
                <br><br>
                <div class="row justify-content-md-center">
                    <div class="col col-lg-2">
                        <a class="col genric-btn danger" href="#" onclick="">마이페이지</a>
                    </div>
                    <div class="col col-lg-2">
                        <a class="col genric-btn primary" href="index.php">메인으로 이동</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->
</main>

<?php
include_once('footer.php');
?>

</html>