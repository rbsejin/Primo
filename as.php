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
                        $list = $list."<tr>
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
    <footer>
        <!-- Footer Start-->
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-6">
                        <div class="single-footer-caption mb-50">
                            <div class="single-footer-caption mb-30">
                                <!-- logo -->
                                <!-- <div class="footer-logo">
                                    <a href="index.php"><img src="assets/img/logo/logo2_footer.png" alt=""></a>
                                </div> -->
                                <div class="footer-tittle">
                                    <div class="footer-pera">
                                        <ul>
                                            <li>회사명: 교하 프리모 학생복</a></li>
                                            <li>대표: 이동화</a></li>
                                            <li>이메일: xxxxx@naver.com</a></li>
                                            <li>대표번호: 031) 000-0000</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <ul>
                                    <li><a href="#">이용약관</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-7">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <ul>
                                    <li><a href="#">개인정보취급방침</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-7">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <ul>
                                    <li><a href="#">찾아오시는 길</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer bottom -->
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-8 col-md-7">
                        <div class="footer-copy-right">
                            <p>
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                Copyright &copy;
                                <script>document.write(new Date().getFullYear());</script> All rights reserved | This
                                template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a
                                    href="https://colorlib.com" target="_blank">Colorlib</a>
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-4 col-md-5">
                        <div class="footer-copy-right f-right">
                            <!-- social -->
                            <div class="footer-social">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.facebook.com/sai4ull"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-behance"></i></a>
                                <a href="#"><i class="fas fa-globe"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End-->
    </footer>
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