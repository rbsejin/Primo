<!doctype html>
<html lang="zxx">

<script>
  function changeOnSubmit() {
    document.getElementById("quantity").value = document.getElementById("quantity_edit").value
    document.getElementById("size").value = document.getElementById("size_select").value
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

$sql = "SELECT cart.id, cart.quantity, product.id as product_id, product.size, item.id as item_id, item.school, item.name, item.price, item.image
FROM cart LEFT JOIN product ON product_id = product.id LEFT JOIN item ON item_id = item.id WHERE user_id = '$userId'";
$result = mysqli_query($conn, $sql);

// $sql = "SELECT * FROM cart  ORDER BY size ";
// $sizesResult = mysqli_query($conn, $sql);
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
                <th scope="col">제품</th>
                <th scope="col">가격</th>
                <th scope="col">사이즈</th>
                <th scope="col">수량</th>
                <th scope="col">총 가격</th>
                <th scope="col">선택</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $list = '';
              $totalPrice = 0;

              while ($row = mysqli_fetch_array($result)) {
                $cartId = $row['id'];
                $itemId = $row["item_id"];
                $school = $row['school'];
                $itemImage = $row['image'];
                $productId = $row['product_id'];
                $productName = $school . ' ' . $row['name'];
                $productPrice = $row['price'];
                $quantity = $row['quantity'];
                $size = $row['size'];
                $subTotal = $productPrice * $quantity;
                $totalPrice += $subTotal;

                $list = $list . '<tr>
                <td>
                  <div class="media">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" checked>
                    </div>
                    <div class="d-flex">
                      <img src="assets/img/gallery/market/' . $school . '/' . $itemImage . '" alt="" />
                    </div>
                    <div class="media-body">
                      <p>' . "$productName" . '</p>
                    </div>
                  </div>
                </td>
                <td>
                  <h5>' . $productPrice . '원</h5>
                </td>
                <td>
                  <select id="size_select" class="form-select" name="size" aria-label="Default select example">';

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
                    <input id="quantity_edit" class="input-number" type="text" value="' . $quantity . '" min="1" max="20">
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
                  <form action="update_cart.php" method="post" onsubmit="changeOnSubmit()">
                    <div>
                      <input name="cart_id" type="hidden" value="' . $cartId . '">
                      <input id="product_id" name="product_id" type="hidden" value="' . $productId . '">
                      <input id="quantity" name="quantity" type="hidden" value="' . $quantity . '">
                      <input id="size" name="size" name="size" type="hidden" value="' . $size . '">
                      <input class="genric-btn default" type="submit" value="변경">
                    </div>
                  </form>
                </td>
              </tr>';
              }
              echo $list;
              ?>

              <!-- <tr class="bottom_button">
                <td>
                  <a class="btn_1" href="update_cart.php">장바구니 업데이트</a>
                </td>
                <td></td>
                <td></td>
                <td></td>
              </tr> -->
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <h5>총 제품금액</h5>
                </td>
                <td>
                  <h5><?= $totalPrice ?>원</h5>
                </td </tr>
                <!-- <tr class="shipping_area">
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <h5>Shipping</h5>
                </td>
                <td>
                  <div class="shipping_box">
                    <ul class="list">
                      <li>
                        Flat Rate: $5.00
                        <input type="radio" aria-label="Radio button for following text input">
                      </li>
                    </ul>
                    <h6>
                      Calculate Shipping
                      <i class="fa fa-caret-down" aria-hidden="true"></i>
                    </h6>
                    <select class="shipping_select">
                      <option value="1">Bangladesh</option>
                      <option value="2">India</option>
                      <option value="4">Pakistan</option>
                    </select>
                    <select class="shipping_select section_bg">
                      <option value="1">Select a State</option>
                      <option value="2">Select a State</option>
                      <option value="4">Select a State</option>
                    </select>
                    <input class="post_code" type="text" placeholder="Postcode/Zipcode" />
                    <a class="btn_1" href="#">Update Details</a>
                  </div>
                </td>
              </tr> -->
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