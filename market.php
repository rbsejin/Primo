<!DOCTYPE html>
<html lang="en">
<?php
include_once('header.php');
?>

<main>
    <!-- Hero Area Start-->
    <div class="slider-area ">
        <div class="single-slider slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">

                            <h2>
                                <?php
                                if (isset($_GET['school']) && isset($_GET['sex'])) {
                                    if ($_GET['sex'] == 'W') {
                                        echo $_GET['school'] . '-여자';
                                    } else {
                                        echo $_GET['school'] . '-남자';
                                    }
                                } else {
                                    echo '마켓';
                                }
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End-->

    <section class="popular-items latest-padding">
        <div class="container">
            <div class="row product-btn justify-content-between mb-40">
                <div class="properties__button">
                    <!--Nav Button  -->
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link" href="market.php?sex=<?= $_GET['sex'] ?>&school=운정중"> 운정중 </a>
                            <a class="nav-item nav-link" href="market.php?sex=<?= $_GET['sex'] ?>&school=한빛중"> 한빛중 </a>
                            <a class="nav-item nav-link" href="market.php?sex=<?= $_GET['sex'] ?>&school=한빛고"> 한빛고 </a>
                            <a class="nav-item nav-link" href="market.php?sex=<?= $_GET['sex'] ?>&school=동패고"> 동패고 </a>
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

            <div class="tab-content" id="nav-tabContent">
                <!-- card one -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">

                        <?php
                        $conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");

                        if (!$conn) {
                            echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
                            die();
                        }

                        $sex = $_GET['sex'];
                        $school = $_GET['school'];

                        $sql = "SELECT * FROM item WHERE (item.sex = '$sex' OR item.sex = 'C') AND item.school = '$school'";
                        $result = mysqli_query($conn, $sql);

                        $list = '';

                        while ($row = mysqli_fetch_array($result)) {
                            $itemId = $row['id'];
                            $sql = "SELECT * FROM product LEFT JOIN item ON product.item_id = item.id WHERE item.id = '$itemId'";

                            $itemName = $row['name'];
                            $itemPrice = $row['price'];
                            $itemImage = $row['image'];

                            if ($itemImage == null) {
                                $itemImage = 'assets/img/gallery/market/default.jpg';
                            } else {
                                $itemImage = 'assets/img/gallery/market/' . $itemImage;
                            }

                            $list = $list .
                                "
                            <div class='col-xl-4 col-lg-4 col-md-6 col-sm-6'>
                                <div class='single-popular-items mb-50 text-center'>
                                    <div class='popular-img'>
                                        <img src=$itemImage height='400' alt=''>
                                    </div>
                                    <div class='popular-caption'>
                                        <h3><a href='product_details.php?item_id={$itemId}&sex={$sex}'> $itemName </a></h3>
                                        <span> $itemPrice 원</span>
                                    </div>
                                </div>
                            </div>
                            ";
                        }

                        echo $list;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include_once('footer.php');
?>

</html>