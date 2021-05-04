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

$PHP_SELP = 'my_page.php';

$LIST_SIZE = 2;
$MORE_PAGE = 2;
$BLOCK_COUNT = 5;

$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'] ? intval($_GET['page']) : 1;
}

//$sql = "SELECT CEIL( COUNT(*)/$LIST_SIZE ) FROM purchase_list WHERE user_id = '$userId'";
$sql = "SELECT CEIL( COUNT(*)/$LIST_SIZE ) FROM pay_info WHERE user_id = '$userId'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
$page_count = $row[0];

$start_page = max($page - $MORE_PAGE - max($MORE_PAGE - $page_count + $page, 0), 1);
$end_page = min($page + $MORE_PAGE + max($MORE_PAGE - $page + 1, 0), $page_count);

$prev_page = max($start_page - $MORE_PAGE - 1, 1);
$next_page = min($end_page + $MORE_PAGE + 1, $page_count);

$offset = ($page - 1) * $LIST_SIZE;
//$sql = "SELECT * FROM purchase_list LEFT JOIN item ON purchase_list.item_id = item.id WHERE user_id = '$userId' ORDER BY created DESC LIMIT $offset, $LIST_SIZE";
$sql = "SELECT * FROM pay_info WHERE user_id = '$userId' ORDER BY id DESC LIMIT $offset, $LIST_SIZE";
$result = mysqli_query($conn, $sql);
?>


<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<!-- jQuery CDN --->
<script>
    function cancelPay() {
        jQuery.ajax({
            "url": "http://www.myservice.com/payments/cancel",
            "type": "POST",
            "contentType": "application/json",
            "data": JSON.stringify({
                "merchant_uid": "mid_" + new Date().getTime(), // 주문번호
                "cancel_request_amount": 2000, // 환불금액
                "reason": "테스트 결제 환불", // 환불사유
                "refund_holder": "홍길동", // [가상계좌 환불시 필수입력] 환불 수령계좌 예금주
                "refund_bank": "88", // [가상계좌 환불시 필수입력] 환불 수령계좌 은행코드(ex. KG이니시스의 경우 신한은행은 88번)
                "refund_account": "56211105948400" // [가상계좌 환불시 필수입력] 환불 수령계좌 번호
            }),
            "dataType": "json"
        });
    }
</script>

<main>
    <!-- Hero Area Start-->
    <div class="slider-area ">
        <div class="single-slider slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>마이 페이지</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--================Checkout Area =================-->
        <section class="section_padding">
            <div class="container">
                <div class="button-group-area" style="border: 1px solid gray; padding: 20px; text-align: center">
                    <span style="margin-right: 50px;">
                        <a style="color: unset;" href="modify_pass.php">내 정보 변경</a>
                    </span>
                    <span>
                        <a style="color: unset;" href="my_page.php">주문 목록</a>
                    </span>
                </div>
            </div>
            <br><br>
            <div class="container">
                <div class="cart_inner">
                    <h5>주문 목록</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">일시</th>
                                <th scope="col">상품정보</th>
                                <th scope="col">수량</th>
                                <th scope="col">상품금액</th>
                                <th scope="col">소계금액</th>
                                <th scope="col">상태</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $payId = $row['id'];
                                $itemTotalPrice = $row['item_price'];
                                $deliveryChange = $row['delivery_charge'];
                                $totalPrice = $row['total_price'];
                                $paytype = $row['paytype'];

                                $sql = "SELECT * FROM purchase_list LEFT JOIN item ON purchase_list.item_id = item.id WHERE user_id = '$userId' AND purchase_list.pay_id = $payId";
                                $result_ = mysqli_query($conn, $sql);
                                $itemCount = $result_->num_rows;
                                $isFirst = true;

                                while ($row_ = mysqli_fetch_array($result_)) {
                                    $size = $row_['size'];
                                    $quantity = $row_['quantity'];
                                    $created = $row_['created'];
                                    $state = $row_['state'];
                                    $subtotal = $row_['subtotal'];
                                    $itemSchool = $row_['school'];
                                    $itemName = $row_['name'];
                                    $itemPrice = $row_['price'];
                                    $itemImage = $row_['image'];
                                    $productName = "$itemSchool $itemName $size";
                            ?>
                                    <tr>
                                        <?php if ($isFirst) { ?>
                                            <td rowspan="<?= $itemCount ?>">
                                                <div>주문번호: <?= $payId ?></div>
                                                <div><?= $created ?></div>
                                            </td>
                                        <?php
                                            $isFirst = false;
                                        }
                                        ?>
                                        <td>
                                            <div class="media">
                                                <div class="d-flex">
                                                    <img src="assets/img/gallery/market/<?= "$itemImage" ?>" alt="" />
                                                </div>
                                                <div class="media-body">
                                                    <p><?= "$productName" ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td> <?= $quantity ?>개 </td>
                                        <td> <?= $itemPrice ?>원 </td>
                                        <td> <?= $subtotal ?>원 </td>
                                        <td> <?= $state ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>


                                    <!-- <td> <?= $itemTotalPrice ?>원 </td> -->
                                    <!-- <td> <?= $deliveryChange ?>원 </td> -->
                                    <td colspan="6" style="text-align:right; background-color: rgb(238,238,238);">
                                        <span>
                                            총 결제금액: <?= $totalPrice ?>원
                                        </span>
                                        <?php if ($state == "결제완료") { ?>
                                        <form action="order_cancel.php" method="post">
                                            <input type="hidden" name="pay_id" value="<?= $payId ?>" />
                                            <input class="genric-btn info-border" type="submit" value="주문취소"/>
                                        </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <nav class="blog-pagination justify-content-center d-flex">
                        <ul class="pagination">
                            <!-- <?php if ($page != 1) { ?> -->
                            <!-- <li class="page-item"> -->
                            <!-- <a href="<?= "$PHP_SELP?page=$prev_page" ?>" class="page-link" aria-label="Previous"> -->
                            <!-- 처음 -->
                            <!-- </a> -->
                            <!-- </li> -->
                            <!-- <?php } ?> -->
                            <?php if ($page != 1) { ?>
                                <li class="page-item">
                                    <a href="<?= "$PHP_SELP?page=" . max($page - 1, 1) ?>" class="page-link" aria-label="Previous">
                                        <i class="ti-angle-left"></i>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php
                            for ($i = $start_page; $i <= $end_page; $i++) {
                            ?>
                                <li class="page-item <?php if ($i == $page) echo 'active' ?>">
                                    <a href="<?= "$PHP_SELP?page=$i" ?>" class="page-link"><?= $i ?></a>
                                </li>
                            <?php } ?>
                            <?php if ($page != $page_count) { ?>
                                <li class="page-item">
                                    <a href="<?= "$PHP_SELP?page=" . min($page + 1, $page_count) ?>" class="page-link" aria-label="Next">
                                        <i class="ti-angle-right"></i>
                                    </a>
                                </li>
                            <?php } ?>
                            <!-- <?php if ($page != $page_count) { ?> -->
                            <!-- <li class="page-item"> -->
                            <!-- <a href="<?= "$PHP_SELP?page=$next_page" ?>" class="page-link" aria-label="Next"> -->
                            <!-- 끝 -->
                            <!-- </a> -->
                            <!-- </li> -->
                            <!-- <?php } ?> -->
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
        <!--================End Checkout Area =================-->


</main>

<?php
include_once('footer.php');
?>

</html>