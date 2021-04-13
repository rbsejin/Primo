<!doctype html>
<html lang="zxx">


<?php
include_once('header.php');
?>

<?php
if (!isset($_SESSION['id'])) {
    echo '다시 로그인해주세요.';
    die();
}

$userId = $_SESSION['id'];

if (!isset($_POST['can_changed'])) {
    echo "<script>alert('잘못된 접근입니다.')</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
}

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

?>

<script>
    function isValid() {
        if (document.getElementById('password').value != document.getElementById('password2').value) {
            alert("비밀번호가 서로 다릅니다.");
            return false;
        }

        if (document.getElementById('password').value == "") {
            alert("비밀번호를 입력하지 않았습니다.");
            return false;
        }
        
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
                            <h2>마이 페이지</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--================Checkout Area =================-->
        <section class="section_padding">
            <div class="container">
                <div class="button-group-area" style="border: 1px solid gray; padding: 20px; text-align: center">
                    <span style="margin-right: 50px;">
                        <a style="color: unset;" href="modify_pass.php">내 정보 변경</a>
                    </span>
                    <span>
                        <a style="color: unset;" href="my_page.php">주문 조회</a>
                    </span>
                </div>
            </div>
            <br><br>
            <div class="container">
                <div class="col-lg-8 col-md-6">
                    <form class="row contact_form" action="pw_confirm_ok.php" method="post" novalidate="novalidate" onsubmit="return isValid();">
                        <div class="col-md-2 form-group ">
                            <label>아이디</label>
                        </div>
                        <div class="col-md-10 form-group ">
                            <span>
                                <label id="id" name="id" value=""><?= $userId ?></label>
                            </span>
                        </div>
                        <div class="col-md-8 form-group p_star">
                            <label>비밀번호</label>
                            <input type="password" class="form-control" id="password" name="password" value="">
                        </div>
                        <div class="col-md-8 form-group p_star">
                            <label>비밀번호 확인</label>
                            <input type="password" class="form-control" id="password2" name="password2" value="">
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <button type="submit" value="submit" class="btn_3">
                                변경하기
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!--================End Checkout Area =================-->


</main>

<?php
include_once('footer.php');
?>

</html>