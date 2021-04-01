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
                            <h2>로그인</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End-->
    <!--================login_part Area =================-->
    <section class="login_part section_padding ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_text text-center">
                        <div class="login_part_text_iner">
                            <h2>처음이신가요?</h2>
                            <p>회원으로 가입하시면 다양한 정보와 혜택을 누릴 수 있습니다.</p>
                            <a href="join.php" class="btn_3">회원가입</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_form">
                        <div class="login_part_form_iner">
                            <h3>환영합니다!<br>
                                로그인하시면 더 편리하게 이용하실 수 있습니다.</h3>
                            <form class="row contact_form" action="loginok.php" method="post" novalidate="novalidate">
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="id" name="id" value="" placeholder="아이디를 입력하세요.">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="비밀번호를 입력하세요.">
                                </div>
                                <div class="col-md-12 form-group">
                                    <!-- <div class="creat_account d-flex align-items-center">
                                            <input type="checkbox" id="f-option" name="selector">
                                            <label for="f-option">아이디 저장</label>
                                        </div> -->
                                    <button type="submit" value="submit" class="btn_3">
                                        로그인
                                    </button>
                                    <!-- <a class="lost_pass" href="#">아이디 찾기</a> <br>
                                        <a class="lost_pass" href="#">비밀번호 찾기</a> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================login_part end =================-->
</main>

<?php
include_once('footer.php');
?>

</html>