<!doctype html>
<html lang="zxx">

<?php
include_once('header.php');
?>

<?php
// item id를 구한다.
$itemId = 0;
if (isset($_GET['item_id'])) {
    $itemId = $_GET['item_id'];
} else {
    die();
}

// db에서 item정보를 가져온다.
$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");

if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

// item 데이터 가져온다.
$sql = "SELECT * FROM item WHERE id = $itemId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if (!$row) {
    die();
}

$school = $row['school'];
$name = $row['name'];
$price = $row['price'];
$productName = $school . ' ' . $name;

// product 데이터 가져온다.
$sql = "SELECT * FROM product WHERE item_id = '$itemId' ORDER BY size ";
$result = mysqli_query($conn, $sql);

$gallery1 = $row['image1'];
$gallery2 = $row['image2'];
$gallery3 = $row['image3'];
?>

<script>
    function isMovingToCart() {
        var selectedIndex  = document.getElementById("size_select").selectedIndex ;
        if (selectedIndex == 0) {
            alert("옵션을 선택해주세요.")
            return false;
        }

        document.getElementById("is_moving_to_cart").value = confirm("장바구니로 이동하시겠습니까?");
        return true;
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
                            <h2>제품 상세</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End-->
    <!--================Single Product Area =================-->
    <div class="product_image_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="product_img_slide owl-carousel">
                        <div class="single_product_img">
                            <img src="assets/img/gallery/<?= $gallery1 ?>" alt="#" class="img-fluid">
                        </div>
                        <div class="single_product_img">
                            <img src="assets/img/gallery/<?= $gallery2 ?>" alt="#" class="img-fluid">
                        </div>
                        <div class="single_product_img">
                            <img src="assets/img/gallery/<?= $gallery3 ?>" alt="#" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="single_product_text text-left">
                        <h3>

                        </h3>
                        <div class="card_area">
                            <table class="table">
                                <thead>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            <span>상품명</span>
                                        </th>
                                        <td>
                                            <span><?= $productName ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <span>가격</span>
                                        </th>
                                        <td>
                                            <span><?= $price ?>원</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <form action="add_to_cart.php" method="post" onsubmit="return isMovingToCart();">
                                <table class="table">
                                    <thead>
                                    </thead>
                                    <tr>
                                        <th scope="row">
                                            <span>사이즈</span>
                                        </th>
                                        <td>
                                            <select id="size_select" class="form-select" name="size" aria-label="Default select example">
                                                <option selected>-[필수] 옵션을 선택해 주세요-</option>
                                                <?php
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo "<option value={$row['size']}>{$row['size']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>


                                <div class="product_count_area">
                                    <p>수량</p>
                                    <div class="product_count d-inline-block">
                                        <span class="product_count_item inumber-decrement"> <i class="ti-minus"></i></span>
                                        <input class="product_count_item input-number" type="text" name="quantity" value="1" min="1" max="20">
                                        <span class="product_count_item number-increment"> <i class="ti-plus"></i></span>
                                    </div>
                                </div>

                                <div class="add_to_cart">
                                    <input id="is_moving_to_cart" type="hidden" name="is_moving_to_cart" value="">
                                    <input type="hidden" name="item_id" value="<?= $itemId ?>">
                                    <!-- <input class="btn_3" type="submit" value="바로 구매"> -->
                                    <input class="btn_3" type="submit" value="장바구니에 추가" onclick="isValid();">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->
    <!-- subscribe part here -->
    <section class="subscribe_part section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="subscribe_part_content">
                        <h2>Get promotions & updates!</h2>
                        <p>Seamlessly empower fully researched growth strategies and interoperable internal or “organic” sources credibly innovate granular internal .</p>
                        <div class="subscribe_form">
                            <input type="email" placeholder="Enter your mail">
                            <a href="#" class="btn_1">Subscribe</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- subscribe part end -->
</main>

<?php
include_once('footer.php');
?>

</html>