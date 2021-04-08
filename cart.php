<!doctype html>
<html lang="zxx">

<script>
  function changeOnSubmit(cartId) {
    document.getElementById("quantity" + String(cartId)).value = document.getElementById("quantity_edit" + String(cartId)).value;
    document.getElementById("size" + String(cartId)).value = document.getElementById("size_select" + String(cartId)).value;
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
          <table class="table">
            <thead>
              <tr>
                <th scope="col">상품정보</th>
                <th scope="col">상품금액</th>
                <th scope="col">사이즈</th>
                <th scope="col">수량</th>
                <th scope="col">결제 금액</th>
                <th scope="col">선택</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $list = '';
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

                $list = $list . '<tr>
                <td>
                  <div class="media">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" checked>
                    </div>
                    <div class="d-flex">
                      <img src="assets/img/gallery/market/' . $itemSchool . '/' . $itemImage . '" alt="" />
                    </div>
                    <div class="media-body">
                      <p>' . "$productName" . '</p>
                    </div>
                  </div>
                </td>
                <td>
                  <h5>' . $itemPrice . '원</h5>
                </td>
                <td>
                  <select id="size_select' . $cartId . '" class="form-select" name="size" aria-label="Default select example">';

                $sql = "SELECT * FROM product WHERE item_id = '$itemId' ORDER BY size ";
                $sizeResult = mysqli_query($conn, $sql);

                while ($sizeRow = mysqli_fetch_array($sizeResult)) {
                  $list = $list . "<option ";
                  if ($sizeRow['size'] == $size) {
                    $list = $list . "selected ";
                  }
                  $list = $list . "value={$sizeRow['size']}>{$sizeRow['size']}</option>";
                }

                $list = $list .
                  '</select>
                </td>
                <td>
                  <div class="product_count">
                    <!-- <span class="input-number-decrement"> <i class="ti-minus"></i></span> -->
                    <input id="quantity_edit' . $cartId . '" class="input-number" type="text" value="' . $quantity . '" min="1" max="20">
                    <!-- <span class="input-number-increment"> <i class="ti-plus"></i></span> -->
                  </div>
                </td>
                <td>
                  <h5>' . $subTotal . '원</h5>
                </td>
                <td>
                  <form action="delete_from_cart.php" method="post">
                    <div>
                      <input name="cart_id" type="hidden" value="' . $cartId . '">
                      <input class="genric-btn default" type="submit" value="삭제">
                    </div>
                  </form>
                  <form action="update_cart.php" method="post" onsubmit="changeOnSubmit(' . $cartId . ')">
                    <div>
                      <input name="cart_id" type="hidden" value="' . $cartId . '">
                      <input id="size' . $cartId . '" name="size" type="hidden" value="' . $size . '">
                      <input id="quantity' . $cartId . '" name="quantity" type="hidden" value="' . $quantity . '">
                      <input class="genric-btn default" type="submit" value="변경">
                    </div>
                  </form>
                </td>
              </tr>';
              }
              echo $list;
              ?>
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
                </td </tr>
            </tbody>
          </table>
          <div class="checkout_btn_inner float-right">
            <a class="btn_1" href="#">선택상품 주문</a>
            <a class="btn_1" href="#">전체상품 주문</a>
            <a class="btn_1" href="#">쇼핑 계속하기</a>
          </div>
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