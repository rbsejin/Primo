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
  echo '다시 로그인해주세요.';
  die();
}

$userId = $_SESSION['id'];

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
  echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
  die();
}

$sql = "SELECT cart.id, cart.size, cart.quantity, cart.user_id, cart.item_id, item.image, item.school, item.name, item.sex, item.price FROM cart LEFT JOIN item ON item_id = item.id WHERE user_id = '$userId'";
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
              <h2>카트</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--================Cart Area =================-->
  <section class="cart_area section_padding">
    <div class="container">
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
                  <th scope="col">상품금액</th>
                  <th scope="col">사이즈</th>
                  <th scope="col">수량</th>
                  <th scope="col">결제 금액</th>
                  <th scope="col">선택</th>
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
                  $productName = $itemSchool . ' ' . $itemName;
                  $itemPrice = $row['price'];
                  $subTotal = $itemPrice * $quantity;
                  $totalPrice += $subTotal;
                ?>

                  <tr>
                    <td>
                      <div class="media">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="cart_ids[]" value="<?= $cartId ?>" onClick="selectItem(this)" checked>
                        </div>
                        <div class="d-flex">
                          <img src="assets/img/gallery/market/<?= $itemSchool . '/' . $itemImage ?>" alt="" />
                        </div>
                        <div class="media-body">
                          <p><?= "$productName" ?></p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <h5><?= $itemPrice ?>원</h5>
                    </td>
                    <td>
                      <select id="size_select<?= $cartId ?>" class="form-select" name="size<?= $cartId ?>" aria-label="Default select example">;

                        <?php
                        $list = '';
                        $sql = "SELECT * FROM product WHERE item_id = '$itemId' ORDER BY size ";
                        $sizeResult = mysqli_query($conn, $sql);

                        while ($sizeRow = mysqli_fetch_array($sizeResult)) {
                          $list = $list . "<option ";
                          if ($sizeRow['size'] == $size) {
                            $list = $list . "selected ";
                          }
                          $list = $list . "value={$sizeRow['size']}>{$sizeRow['size']}</option>";
                        }

                        echo $list;
                        ?>

                      </select>
                    </td>
                    <td>
                      <div class="product_count">
                        <!-- <span class="input-number-decrement"> <i class="ti-minus"></i></span> -->
                        <input id="quantity_edit<?= $cartId ?>" class="input-number" name="quantity<?= $cartId ?>" type="text" value="<?= $quantity ?>" min="1" max="20">
                        <!-- <span class="input-number-increment"> <i class="ti-plus"></i></span> -->
                      </div>
                    </td>
                    <td>
                      <h5><?= $subTotal ?>원</h5>
                    </td>
                    <td>
                      <div>
                        <input class="genric-btn default" type="submit" value="삭제" onclick="changeCartId(<?= $cartId ?>)" formaction="delete_from_cart.php">
                      </div>
                      <div style="margin-top: 10px;">   
                        <!-- <input name="size<?= $cartId ?>" type="hidden" value="<?= $size ?>">
                        <input name="quantity<?= $cartId ?>" type="hidden" value="<?= $quantity ?>"> -->
                        <input class="genric-btn default" type="submit" value="변경" onclick="changeCartId(<?= $cartId ?>)" formaction="update_cart.php">
                      </div>
                      <!-- </form> -->
                    </td>
                  </tr>
                <?php } ?>

                <input id="cart_id" name="cart_id" type="hidden" value="">
                
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <h5>총 결제금액</h5>
                  </td>
                  <td>
                    <h5><?= $totalPrice ?>원</h5>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- <form action="checkout.php" method="post"> -->
            <div class="checkout_btn_inner float-right">
              <button type="submit" class="btn_1" formaction="delete_from_cart_selected.php">선택 삭제</button>
              <button type="submit" class="btn_1">선택상품 주문</button>
              <button type="submit" class="btn_1" onclick="selectCheck()">전체상품 주문</button>
              <a class="btn_1" href="#">쇼핑 계속하기</a>
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