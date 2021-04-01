<!doctype html>
<html lang="zxx">
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
                            <h2>AS문의</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End-->
    <!--================login_part Area =================-->



    <?php
    $conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");

    // if (!$conn) {
    //     echo 'db에 연결하지 못했습니다.'. mysqli_connect_error();
    // } else {
    //     echo 'db에 접속했습니다.';
    // }


    $view_num = $_GET['number'];
    $sql = "SELECT * FROM as_board WHERE number = $view_num";
    $result = mysqli_query($conn, $sql);
    ?>

    <div class="container my-3">
        <div class="row">
            <!-- 게시물 내용 출력 -->
            <div class="container my-1">
                <div class="row">
                    <?php if ($row = mysqli_fetch_array($result)) { ?>
                        <table class="table">
                            <thead>
                                <tr class="table-active">
                                    <th scope="col" style="width: 60%">제목: <?= $row['title'] ?> <br>
                                        작성자: <?= $row['userid'] ?></th>
                                    <th scope="col" style="width: 40%" class="text-right">조회 : <?= $row['view'] ?>
                                        <br> <?= $row['created'] ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <pre><?= $row['content'] ?></pre>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>

            <div class="col"></div>
            <div class="col-md-auto">
                <!-- 답글 작성은 로그인이 필요합니다. -->
                <div class="row">
                    <form action="as.php" method="post">
                        <button type="submit" class="btn btn-secondary">목록</button>
                    </form>
                    <!-- <?php if (isset($_SESSION['id'])) { ?>
                        <form action="#" method="post">
                            <input type="hidden" name="bdGroup" value="">
                            <input type="hidden" name="bdOrder" value="">
                            <input type="hidden" name="bdIndent" value="">
                            <button type="submit" class="btn btn-secondary">답글쓰기</button>
                        </form>
                        <?php } ?> -->
                    <?php if ($row['userid'] == $_SESSION['id']) { ?>
                        <form action="as-update.php" method="post">
                            <input type="hidden" name="bdGroup" value="">
                            <input type="hidden" name="bdOrder" value="">
                            <input type="hidden" name="bdIndent" value="">
                            <input type="hidden" name="number" value=<?= $row['number'] ?>>
                            <button type="submit" class="btn btn-secondary">수정</button>
                        </form>
                        <form action="as-delete.php" method="post">
                            <input type="hidden" name="bdGroup" value="">
                            <input type="hidden" name="bdOrder" value="">
                            <input type="hidden" name="bdIndent" value="">
                            <input type="hidden" name="number" value=<?= $row['number'] ?>>
                            <button type="submit" class="btn btn-secondary">삭제</button>
                        </form>
                    <?php } else {
                        $view = $row['view'] + 1;
                        $sql = "UPDATE as_board SET view = $view WHERE number = $view_num";
                        $result = mysqli_query($conn, $sql);
                    } ?>
                </div>
            </div>
        </div>
    </div>

    <!--================login_part end =================-->
</main>

<?php
include_once('footer.php');
?>

<!--? Search model Begin -->
<div class="search-model-box">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-btn">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Searching key.....">
        </form>
    </div>
</div>
<!-- Search model end -->

<!-- JS here -->

<script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
<!-- Jquery, Popper, Bootstrap -->
<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="./assets/js/popper.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<!-- Jquery Mobile Menu -->
<script src="./assets/js/jquery.slicknav.min.js"></script>

<!-- Jquery Slick , Owl-Carousel Plugins -->
<script src="./assets/js/owl.carousel.min.js"></script>
<script src="./assets/js/slick.min.js"></script>

<!-- One Page, Animated-HeadLin -->
<script src="./assets/js/wow.min.js"></script>
<script src="./assets/js/animated.headline.js"></script>

<!-- Scroll up, nice-select, sticky -->
<script src="./assets/js/jquery.scrollUp.min.js"></script>
<script src="./assets/js/jquery.nice-select.min.js"></script>
<script src="./assets/js/jquery.sticky.js"></script>
<script src="./assets/js/jquery.magnific-popup.js"></script>

<!-- contact js -->
<script src="./assets/js/contact.js"></script>
<script src="./assets/js/jquery.form.js"></script>
<script src="./assets/js/jquery.validate.min.js"></script>
<script src="./assets/js/mail-script.js"></script>
<script src="./assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->
<script src="./assets/js/plugins.js"></script>
<script src="./assets/js/main.js"></script>

</body>

</html>