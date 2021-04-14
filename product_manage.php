<!doctype html>
<html lang="zxx">

<script>
  // function changeOnSubmit(cartId) {
  //   document.getElementById("quantity" + String(cartId)).value = document.getElementById("quantity_edit" + String(cartId)).value;
  //   document.getElementById("size" + String(cartId)).value = document.getElementById("size_select" + String(cartId)).value;
  // }

  function selectAll(selectAll) {
    const checkboxes = document.getElementsByName('cart_ids[]');

    checkboxes.forEach((checkbox) => {
      checkbox.checked = selectAll.checked;
    })
  }

  function selectCheck() {
    const check = document.getElementById("all_checked")
    check.checked = true;
    selectAll(check)
  }

  function selectItem(item) {
    if (item.checked) {
      const checkboxes = document.getElementsByName('cart_ids[]');
      var isCheckedAll = true;
      checkboxes.forEach((checkbox) => {
        if (!checkbox.checked) {
          isCheckedAll = false;
        }
      })

      document.getElementById("all_checked").checked = isCheckedAll;
    } else {
      document.getElementById("all_checked").checked = false;
    }
  }

  function changeCartId(cartId) {
    document.getElementById("cart_id").value = cartId;
  }
</script>

<?php
include_once('header.php');
?>

<?php
if (!isset($_SESSION['id'])) {
  '다시 로그인해주세요.';
  echo "<meta http-equiv='refresh' content='0; url=index.php'>";
}

$userId = $_SESSION['id'];

if ($userId != "admin") {
  echo "<meta http-equiv='refresh' content='0; url=index.php'>";
}

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
  echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
  die();
}

$PHP_SELP = 'product_manage.php';

$LIST_SIZE = 5;
$MORE_PAGE = 2;
$BLOCK_COUNT = 5;

$page = 1;
if (isset($_GET['page'])) {
  $page = $_GET['page'] ? intval($_GET['page']) : 1;
}

// $sex = "M";
// if (isset($_GET['sex'])) {
//   $sex = $_GET['sex'];
// }

$school = "한빛고";
if (isset($_GET['school'])) {
  $school = $_GET['school'];
}

$sexAndSchoolQuery = "WHERE item.school = '$school'";
// $sexAndSchoolQuery = "WHERE item.sex = '$sex' AND item.school = '$school'";

$sql = "SELECT CEIL( COUNT(*)/$LIST_SIZE ) FROM item " . $sexAndSchoolQuery;
// $sql = "SELECT CEIL( COUNT(*)/$LIST_SIZE ) FROM product LEFT JOIN item ON product.item_id = item.id " . $sexAndSchoolQuery;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
$page_count = $row[0];

$start_page = max($page - $MORE_PAGE - max($MORE_PAGE - $page_count + $page, 0), 1);
$end_page = min($page + $MORE_PAGE + max($MORE_PAGE - $page + 1, 0), $page_count);

$prev_page = max($start_page - $MORE_PAGE - 1, 1);
$next_page = min($end_page + $MORE_PAGE + 1, $page_count);

$offset = ($page - 1) * $LIST_SIZE;

$sql = "SELECT * FROM item " . $sexAndSchoolQuery . " LIMIT $offset, $LIST_SIZE";
// $sql = "SELECT * FROM item LEFT JOIN product ON item.id = product.item_id " . $sexAndSchoolQuery . " LIMIT $offset, $LIST_SIZE";
// $sql = "SELECT cart.id, cart.size, cart.quantity, cart.user_id, cart.item_id, item.image, item.school, item.name, item.sex, item.price FROM cart LEFT JOIN item ON item_id = item.id WHERE user_id = '$userId'";
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
              <h2>상품관리</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--================Cart Area =================-->
  <section class="cart_area section_padding">
    <div class="container">
      <div class="row product-btn justify-content-between mb-40">
        <div class="properties__button">
          <!--Nav Button  -->
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link" style="color: unset;" href="<?= $PHP_SELP ?>?school=운정중"> 운정중 </a>
              <a class="nav-item nav-link" style="color: unset;" href="<?= $PHP_SELP ?>?school=한빛중"> 한빛중 </a>
              <a class="nav-item nav-link" style="color: unset;" href="<?= $PHP_SELP ?>?school=한빛고"> 한빛고 </a>
              <a class="nav-item nav-link" style="color: unset;" href="<?= $PHP_SELP ?>?school=동패고"> 동패고 </a>
            </div>
          </nav>
          <!--End Nav Button  -->
        </div>
        <!-- Grid and List view -->
        <div class="grid-list-view">
        </div>
        <!-- Select items -->
        <!-- <div class="select-this">
                    <form action="#">
                        <div class="select-itms">
                            <select name="select" id="select1">
                                <option value="">40 per page</option>
                                <option value="">50 per page</option>
                                <option value="">60 per page</option>
                                <option value="">70 per page</option>
                            </select>
                        </div>
                    </form>
                </div> -->
      </div>
      <div class="cart_inner">
        <div class="table-responsive">
          <form action="checkout.php" name="form" method="post">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">
                    <div class="form-check">
                      <input id="all_checked" class="form-check-input" type="checkbox" value="" onclick="selectAll(this)" checked>상품정보
                    </div>
                  </th>
                  <!-- <th scope="col">사이즈</th>
                  <th scope="col">수량</th>
                  <th scope="col">결제 금액</th> -->
                  <th scope="col">학교</th>
                  <th scope="col">상품명</th>
                  <th scope="col">상품금액</th>
                  <th scope="col">선택</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $totalPrice = 0;

                while ($row = mysqli_fetch_array($result)) {
                  // $cartId = $row['id'];
                  // $size = $row['size'];
                  // $quantity = $row['quantity'];
                  $itemId = $row["id"];
                  $itemImage = $row['image'];
                  $itemSchool = $row['school'];
                  $itemName = $row['name'];
                  // $productName = $itemSchool . ' ' . $itemName;
                  $itemPrice = $row['price'];
                  // $subTotal = $itemPrice * $quantity;
                  // $totalPrice += $subTotal;
                ?>

                  <tr>
                    <td>
                      <div class="media">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="cart_ids[]" value="<?= $itemId ?>" onClick="selectItem(this)" checked>
                        </div>
                        <div class="d-flex">
                          <img src="assets/img/gallery/market/<?= $itemSchool . '/' . $itemImage ?>" alt="" />
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="media-body">
                        <label> <?= "$itemSchool" ?> </label>
                      </div>
                    </td>
                    <td>
                      <div class="media-body">
                        <input type="text" name="name" value="<?= "$itemName" ?>" </p>
                      </div>
                    </td>
                    <td>
                      <input type="text" name="itemPrice" value="<?= $itemPrice ?>" />
                    </td>
                    <td>
                      <div>
                        <input class="genric-btn default" type="submit" value="삭제" onclick="changeCartId(<?= $cartId ?>)" formaction="delete_from_cart.php">
                      </div>
                      <div style="margin-top: 10px;">
                        <input class="genric-btn default" type="submit" value="변경" onclick="changeCartId(<?= $cartId ?>)" formaction="update_cart.php">
                      </div>
                    </td>
                  </tr>
                <?php } ?>

                <input id="cart_id" name="cart_id" type="hidden" value="">
                <!-- 
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr> -->
              </tbody>
            </table>

            <nav class="blog-pagination justify-content-center d-flex">
              <ul class="pagination">
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
              </ul>
            </nav>
            <br><br>
            <!-- <form action="checkout.php" method="post"> -->
            <div class="checkout_btn_inner float-right">
              <button type="submit" class="btn_1" formaction="delete_from_cart_selected.php">선택 삭제</button>
              <!-- <button type="submit" class="btn_1">선택 변경</button> -->
              <!-- <button type="submit" class="btn_1" onclick="selectCheck()">전체상품 주문</button> -->
              <a class="btn_1" href="market.php?sex=M&school=한빛고">상품 추가</a>
            </div>
          </form>
        </div>
      </div>
  </section>
  <!--================End Cart Area =================-->
</main>>

<?php
mysqli_close($conn);
?>

<?php
include_once('footer.php');
?>

</html>