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

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" class="text-center">제목</th>
                <th scope="col" class="text-center">글쓴이</th>
                <th scope="col" class="text-center">작성일</th>
                <th scope="col" class="text-center">조회수</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");

            // if (!$conn) {
            //     echo 'db에 연결하지 못했습니다.'. mysqli_connect_error();
            // } else {
            //     echo 'db에 접속했습니다!!!';
            // }

            // table에서 글 조회
            $sql = "SELECT * FROM as_board ORDER BY created DESC";
            $result = mysqli_query($conn, $sql);
            $list = '';

            while ($row = mysqli_fetch_array($result)) {
                // $list = $list."<li>{$row['number']}: <a href=\"view.php?number={$row['number']}\">{$row['title']}</a></li>";
                $list = $list . "<tr>
                        <td style='width:60%' class='text-left'> <a href=\"as-view.php?number={$row['number']}\" style='color:black'>{$row['title']}</a> </td>
                        <td style='width:10%' class='text-center'> {$row['userid']} </td>
                        <td style='width:20%' class='text-center'> {$row['created']} </td>
                        <td style='width:10%' class='text-center'> {$row['view']} </td>
                        </tr>";
            }
            echo $list;
            ?>
        </tbody>
    </table>

    <form action="as-write.php" method="post">
        <!-- 새글의 계층 정보 -->
        <!-- <input type="hidden" name="bdGroup" value="-1">
            <input type="hidden" name="bdOrder" value="0">
            <input type="hidden" name="bdIndent" value="0"> -->
        <div class="form-row float-right">
            <button type="submit" class="btn btn-secondary mb-3">새글쓰기</button>
        </div>
    </form>

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