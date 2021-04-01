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
                            <h2>회원가입</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End-->
    <!--================login_part Area =================-->
    <!-- <section class="login_part section_padding ">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="login_part_text text-center">
                            <div class="login_part_text_iner">
  
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="login_part_form">
                            <div class="login_part_form_iner">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

    <section class="login_part section_padding ">
        <div class="container">
            <div class="col-lg-8 col-md-6">
                <h3>교하 프리모 회원가입을 진심을 환영합니다</h3>
                <form class="row contact_form" action="joinok.php" method="post" novalidate="novalidate">
                    <div class="col-md-12 form-group ">
                        <label>아이디</label>
                        <div>
                            <input type="text" class="form-control" id="id" name="id" value="">
                        </div>
                    </div>
                    <div class="col-md-12 form-group p_star">
                        <label>비밀번호</label>
                        <input type="password" class="form-control" id="password" name="password" value="">
                    </div>
                    <div class="col-md-12 form-group p_star">
                        <label>비밀번호 확인</label>
                        <input type="password" class="form-control" id="password2" name="password2" value="">
                    </div>
                    <div class="col-md-12 form-group p_star">
                        <label>이름</label>
                        <input type="text" class="form-control" id="name" name="name" value="">
                    </div>
                    <div class="col-md-12 form-group p_star">
                        <label>이메일</label>
                        <input type="email" class="form-control" id="email" name="email" value="">
                    </div>
                    <div class="col-md-12 form-group p_star">
                        <button type="submit" value="submit" class="btn_3">
                            가입하기
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>



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