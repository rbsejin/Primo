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

</html>