<?php
include_once('header.php');

include_once('Item.php');

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

$PHP_SELP = 'orders.php';

$LIST_SIZE = 5;
$MORE_PAGE = 2;
$BLOCK_COUNT = 5;

$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'] ? intval($_GET['page']) : 1;
}

// $sql = "SELECT CEIL( COUNT(*)/$LIST_SIZE ) FROM purchase_list";
$sql = "SELECT CEIL( COUNT(*)/$LIST_SIZE ) FROM pay_info";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
$page_count = $row[0];

$start_page = max($page - $MORE_PAGE - max($MORE_PAGE - $page_count + $page, 0), 1);
$end_page = min($page + $MORE_PAGE + max($MORE_PAGE - $page + 1, 0), $page_count);

$prev_page = max($start_page - $MORE_PAGE - 1, 1);
$next_page = min($end_page + $MORE_PAGE + 1, $page_count);

$offset = ($page - 1) * $LIST_SIZE;

// $sql = "SELECT purchase_list.id, purchase_list.size, purchase_list.quantity, purchase_list.created, purchase_list.state, purchase_list.subtotal, purchase_list.user_id, purchase_list.pay_id, item.image, item.school, item.name, item.sex, item.price FROM purchase_list LEFT JOIN item ON purchase_list.item_id = item.id ORDER BY created DESC LIMIT $offset, $LIST_SIZE";
$sql = "SELECT * FROM pay_info ORDER BY id DESC LIMIT $offset, $LIST_SIZE";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die();
}

?>

<div class="properties__button">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a style="color: black;" class="nav-item nav-link" href="orders.php"> 주문 </a>
            <a style="color: black;" class="nav-item nav-link" href="products.php"> 제품 </a>
        </div>
    </nav>
    <br>
</div>

<main>
    <form action="" method="post">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>일시</th>
                    <th>회원 아이디</th>
                    <th>상품 이미지</th>
                    <th>학교</th>
                    <th>품목명</th>
                    <th>상품금액</th>
                    <th>사이즈</th>
                    <th>수량</th>
                    <th>소계금액</th>
                    <th>상태</th>
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

                    $sql = "SELECT * FROM purchase_list LEFT JOIN item ON purchase_list.item_id = item.id  WHERE purchase_list.pay_id = $payId";
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
                        $userId = $row_['user_id'];
                ?>
                        <tr>
                            <?php if ($isFirst) { ?>
                                <td rowspan="<?= $itemCount ?>">
                                    <div>주문번호: <?= $payId ?></div>
                                    <div><?= $created ?></div>
                                </td>
                                <td rowspan="<?= $itemCount ?>"> <?= $userId ?></td>
                            <?php
                            }
                            ?>

                            <td>
                                <img src="../assets/img/gallery/market/<?= "$itemImage" ?>" alt="" height="100px" />
                            </td>
                            <td> <?= $itemSchool ?> </td>
                            <td> <?= $itemName ?> </td>
                            <td> <?= $itemPrice ?>원 </td>
                            <td> <?= $size ?></td>
                            <td> <?= $quantity ?>개 </td>
                            <td> <?= $subtotal ?>원 </td>
                            <?php if ($isFirst) { ?>
                                <td rowspan="<?= $itemCount ?>">
                                    <?= $state ?>
                                </td>
                            <?php
                                $isFirst = false;
                            }
                            ?>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="10" style="text-align:right; background-color: rgb(238,238,238);">
                            <span>
                                총 상품금액: <?= $itemTotalPrice ?>원 /
                                배송비: <?= $deliveryChange ?>원 /
                                총 결제금액: <?= $totalPrice ?>원
                            </span>
                            <?php if ($state == "결제완료") { ?>
                                <form action="order_cancel.php" method="post">
                                    <input type="hidden" name="pay_id" value="<?= $payId ?>" />
                                    <!-- <input class="genric-btn info-border" type="submit" value="주문취소" /> -->
                                </form>
                            <?php } ?>
                            <div>
                                <div class="float-right">
                                    <span style="margin-right: 10px;">
                                        <select id="state_select<?= $row['id'] ?>" onclick="change">
                                            <option value="선택">선택</option>
                                            <option value="취소">취소</option>
                                            <option value="결제완료">결제완료</option>
                                            <option value="발송중">발송중</option>
                                            <option value="배송완료">배송완료</option>
                                        </select>
                                    </span>
                                    <span>
                                        <input class="genric-btn default float-right" type='submit' value="변경" onclick="changePurchase(<?= $payId ?>)" formaction="orders/update_state.php">
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- <input id="purchase_id" name="purchase_id" type="hidden" value=""> -->
        <input id="pay_id" name="pay_id" type="hidden" value="">
        <input id="purchase_state" name="purchase_state" type="hidden" value="">
    </form>
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
</main>

<script>
    function changePurchase(payId) {
        // document.getElementById("purchase_id").value = purchaseId;
        document.getElementById("pay_id").value = payId;
        var state = document.getElementById("state_select" + payId).value;

        document.getElementById("purchase_state").value = state;

        if (state != "선택" && state != document.getElementById("state" + payId).innerText) {
            document.getElementById("purchase_state").value = state;
        } else {
            document.getElementById("purchase_state").value = "";
        }
    }
</script>

<?php
include_once('footer.php')
?>