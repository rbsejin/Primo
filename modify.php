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

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

$sql = "SELECT * FROM user WHERE id = '$userId'";
$result = mysqli_query($conn, $sql);

if (!$row = mysqli_fetch_array($result)) {
    mysqli_close($conn);
    die();
}

$name = $row['name'];
$email = $row['email'];
$phoneNumber = $row['phone_number'];
$postcode = $row['postcode'];
$address = $row['address'];
$detailAddress = $row['detail_address'];
$extraAddress = $row['extra_address'];
?>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    function searchZipCode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if (data.userSelectedType === 'R') {
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if (data.buildingName !== '' && data.apartment === 'Y') {
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if (extraAddr !== '') {
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
                    document.getElementById("extraAddress").value = extraAddr;

                } else {
                    document.getElementById("extraAddress").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('postcode').value = data.zonecode;
                document.getElementById("address").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("detailAddress").value = "";
                document.getElementById("detailAddress").focus();
            }
        }).open();
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
                    <div class="col-md-2 form-group p_star">
                        <label>아이디</label>
                    </div>
                    <div class="col-md-8 form-group p_star">
                        <span>
                            <label id="id" name="id" value=""><?= $userId ?></label>
                        </span>
                    </div>
                    <div class="col-md-2 form-group p_star">
                        <label>이름</label>
                    </div>
                    <div class="col-md-2 form-group p_star">
                        <span>
                            <label id="name" name="name" value=""><?= $name ?></label>
                        </span>
                    </div>
                    <div class="col-md-4 form-group p_star">
                        <span>
                            <form class="row contact_form" action="pw_confirm.php" method="post" novalidate="novalidate">
                                <button type="submit" value="submit" class="genric-btn primary-border">
                                    비밀번호 변경
                                </button>
                                <input type="hidden" name="can_changed" value="true"/>
                            </form>
                        </span>
                    </div>
                    <form class="row contact_form" action="modify_ok.php" method="post" novalidate="novalidate">
                        <div class="col-md-8 form-group p_star">
                            <label>이메일</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                        </div>
                        <div class="col-md-8 form-group p_star">
                            <label>전화번호</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phone_number" maxlength="11" value="<?= $phoneNumber ?>">
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <label>주소</label>
                        </div>
                        <div class="col-md-8 form-group p_star">
                            <input type="text" class="form-control" id="postcode" name="postcode" placeholder="우편번호" value="<?= $postcode ?>" />
                        </div>
                        <div class="col-md-4 form-group p_star">
                            <a href="javascript:searchZipCode();" class="genric-btn primary-border">우편번호 검색</a>
                        </div>
                        <div class="col-md-8 form-group p_star">
                            <input type="text" class="form-control" id="address" name="address" placeholder="주소" value="<?= $address ?>" />
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="detailAddress" name="detailAddress" placeholder="상세주소" value="<?= $detailAddress ?>" />
                        </div>
                        <div class="col-md-5 form-group p_star">
                            <input type="text" class="form-control" id="extraAddress" name="extraAddress" placeholder="참고항목" value="<?= $extraAddress ?>" />
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <a class="btn_3" href="my_page.php">
                                취소
                            </a>
                            <button type="submit" value="submit" class="btn_3">
                                수정완료
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