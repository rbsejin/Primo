<!doctype html>
<html lang="zxx">

<!-- 적용방법 1 -->

<!-- 적용방법 2 : cdn -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- 적용방법 3 -->
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
    $(document).ready(function() {
        var userInputId = getCookie("userInputId"); //저장된 쿠기값 가져오기
        $("input[name='id']").val(userInputId);

        if ($("input[name='id']").val() != "") { // 그 전에 ID를 저장해서 처음 페이지 로딩
            // 아이디 저장하기 체크되어있을 시,
            $("#idSaveCheck").attr("checked", true); // ID 저장하기를 체크 상태로 두기.
        }

        $("#idSaveCheck").change(function() { // 체크박스에 변화가 발생시
            if ($("#idSaveCheck").is(":checked")) { // ID 저장하기 체크했을 때,
                var userInputId = $("input[name='id']").val();
                setCookie("userInputId", userInputId, 7); // 7일 동안 쿠키 보관
            } else { // ID 저장하기 체크 해제 시,
                deleteCookie("userInputId");
            }
        });

        // ID 저장하기를 체크한 상태에서 ID를 입력하는 경우, 이럴 때도 쿠키 저장.
        $("input[name='id']").keyup(function() { // ID 입력 칸에 ID를 입력할 때,
            if ($("#idSaveCheck").is(":checked")) { // ID 저장하기를 체크한 상태라면,
                var userInputId = $("input[name='id']").val();
                setCookie("userInputId", userInputId, 7); // 7일 동안 쿠키 보관
            }
        });
    });

    function setCookie(cookieName, value, exdays) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var cookieValue = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toGMTString());
        document.cookie = cookieName + "=" + cookieValue;
    }

    function deleteCookie(cookieName) {
        var expireDate = new Date();
        expireDate.setDate(expireDate.getDate() - 1);
        document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
    }

    function getCookie(cookieName) {
        cookieName = cookieName + '=';
        var cookieData = document.cookie;
        var start = cookieData.indexOf(cookieName);
        var cookieValue = '';
        if (start != -1) {
            start += cookieName.length;
            var end = cookieData.indexOf(';', start);
            if (end == -1) end = cookieData.length;
            cookieValue = cookieData.substring(start, end);
        }
        return unescape(cookieValue);
    }
</script>

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
                                    <div class="creat_account d-flex align-items-center">
                                        <input type="checkbox" id="idSaveCheck" name="selector">
                                        <label for="idSaveCheck">아이디 저장</label>
                                    </div>
                                    <button type="submit" class="btn_3">로그인 </button>
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