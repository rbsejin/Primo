<!doctype html>
<html lang="zxx">

<?php
include_once('header.php');
?>

<?php
include_once('User.php');
?>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

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

$cartIds = $_POST['cart_ids'];
$cartIdSql = "1 != 1";

foreach ($cartIds as $cartId) {
    $cartIdSql = "$cartIdSql OR cart.id = $cartId";
}

$sql = "SELECT cart.id, cart.size, cart.quantity, cart.user_id, cart.item_id, item.image, item.school, item.name, item.sex, item.price FROM cart LEFT JOIN item ON item_id = item.id WHERE user_id = '$userId' AND ($cartIdSql)";
$result = mysqli_query($conn, $sql);

$sql = "SELECT * FROM user WHERE id = '$userId'";
$userResult = mysqli_query($conn, $sql);
$user = User::fromBasicDb($conn, $userId);
?>

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
                document.getElementById("detailAddress").focus();
            }
        }).open();
    }

    function checkOut(name, amount, buyer_email, buyer_name, buyer_tel, buyer_addr, buyer_postcode) {
        if (!isValid()) {
            return false;
        }

        var IMP = window.IMP; // 생략가능
        IMP.init('imp65896340'); // 'iamport' 대신 부여받은 "가맹점 식별코드"를 사용

        IMP.request_pay({
            pg: 'inicis', // version 1.1.0부터 지원.
            pay_method: 'card',
            merchant_uid: 'merchant_' + new Date().getTime(),
            name: name,
            amount: amount,
            buyer_email: buyer_email,
            buyer_name: buyer_name,
            buyer_tel: buyer_tel,
            buyer_addr: buyer_addr,
            buyer_postcode: buyer_postcode,
            m_redirect_url: 'http://192.168.0.18/primo'
        }, function(rsp) {
            if (rsp.success) {
                var msg = '결제가 완료되었습니다.';
                msg += '고유ID : ' + rsp.imp_uid;
                msg += '상점 거래ID : ' + rsp.merchant_uid;
                msg += '결제 금액 : ' + rsp.paid_amount;
                msg += '카드 승인번호 : ' + rsp.apply_num;

                var frmData = document.frmData;
                frmData.action = "checkout_complete.php";
                frmData.submit();
            } else {
                var msg = '결제에 실패하였습니다.';
                msg += '에러내용 : ' + rsp.error_msg;
            }
            alert(msg);
        });
    }

    function isValid() {
        if (document.getElementById('privacyCheck').checked == false) {
            alert("개인정보제공에 동의하셔야 주문 가능합니다.")
            return false;
        }

        if (document.getElementById('payWay1').checked == false) {
            alert("결제방식을 선택해 주세요!");
            return false;
        }

        return true;
    }

    function fillDeliveryInfo() {
        document.getElementById('shipper_name').value = "<?= $user->name ?>";
        document.getElementById('shipper_number').value = "<?= $user->phoneNumber ?>";
        document.getElementById('postcode').value = "<?= $user->postcode ?>";
        document.getElementById('address').value = "<?= $user->address ?>";
        document.getElementById('detailAddress').value = "<?= $user->detailAddress ?>";
        document.getElementById('extraAddress').value = "<?= $user->extraAddress ?>";
    }

    function clearDeliveryInfo() {
        document.getElementById('shipper_name').value = "";
        document.getElementById('shipper_number').value = "";
        document.getElementById('postcode').value = "";
        document.getElementById('address').value = "";
        document.getElementById('detailAddress').value = "";
        document.getElementById('extraAddress').value = "";
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
                            <h2>결제</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================Checkout Area =================-->
    <section class="checkout_area section_padding">
        <form id="frmData" name="frmData" class="contact_form" action="#" method="post" novalidate="novalidate">
            <div class="container">
                <div class="cart_inner">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">상품정보</th>
                                    <th scope="col">상품금액</th>
                                    <th scope="col">수량</th>
                                    <th scope="col">결제 금액</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalPrice = 0;
                                $deliveryCharge = 2500;
                                $total_quantity = 0;
                                $item_name = "";

                                while ($row = mysqli_fetch_array($result)) {
                                    $cartId = $row['id'];
                                    $size = $row['size'];
                                    $quantity = $row['quantity'];
                                    $itemId = $row["item_id"];
                                    $itemImage = $row['image'];
                                    $itemSchool = $row['school'];
                                    $itemName = $row['name'];
                                    $productName = "$itemSchool $itemName $size";
                                    $itemPrice = $row['price'];
                                    $subTotal = $itemPrice * $quantity;
                                    $totalPrice += $subTotal;
                                    $total_quantity += $quantity;
                                    if ($item_name == "") {
                                        $item_name = $productName;
                                    } else {
                                        $item_name = "$item_name, $productName";
                                    }
                                ?>

                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="d-flex">
                                                    <img src="assets/img/gallery/market/<?= "$itemSchool/$itemImage" ?>" alt="" />
                                                </div>
                                                <div class="media-body">
                                                    <p><?= "$productName" ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $itemPrice ?>원</td>
                                        <td><?= $quantity ?></td>
                                        <td><?= $subTotal ?>원</td>
                                        <input class="form-check-input" type="checkbox" name="cart_ids[]" value="<?= $cartId ?>" onClick="selectItem(this)" checked>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="order_box">
                    <h2>주문</h2>
                    <ul class="list list_2">
                        <li>
                            <a href="#">상품금액
                                <span> <?= $totalPrice ?>원 </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">배송비
                                <span> <?= $deliveryCharge ?>원 </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">총 결제금액
                                <span> <?= $total_amount = $totalPrice + $deliveryCharge ?>원</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="billing_details" style="margin-top: 100px; margin-bottom: 100px;">
                    <h3>주문자 정보</h3>
                    <div class="row">
                        <div class="col-8">
                            <div class="col-md-2 form-group p_star">
                                <label for="name">이름</label>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="name" name="name" value="<?= $user->name ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="col-md-2 form-group p_star">
                                <label for="number">전화번호</label>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="number" name="number" value="<?= $user->phoneNumber ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="col-md-2 form-group p_star">
                                <label for="email">이메일</label>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="email" name="compemailany" value="<?= $user->email ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="billing_details">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>배송지 정보</h3>
                            <div class="row form-check">
                                <div class="col-lg-8">
                                    <div class="col-md-2 form-group p_star">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" onclick="fillDeliveryInfo();" checked>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            기본 배송지
                                        </label>
                                    </div>
                                    <div class="col-md-6 form-group p_star">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" onclick="clearDeliveryInfo();">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            새로운 배송지
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="col-md-2 form-group p_star">
                                        <label for="name">이름</label>
                                    </div>
                                    <div class="col-md-6 form-group p_star">
                                        <input type="text" class="form-control" id="shipper_name" name="shipper_name" value="<?= $user->name ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8"">
                                    <div class=" col-md-2 form-group p_star">
                                    <label for="number">전화번호</label>
                                </div>
                                <div class="col-md-6 form-group p_star">
                                    <input type="text" class="form-control" id="shipper_number" name="shipper_number" value="<?= $user->phoneNumber ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8"">
                                    <div class=" col-md-2 form-group p_star">
                                <label for="address">주소</label>
                            </div>
                            <div class="col-md-4 form-group p_star">
                                <input type="text" class="form-control" id="postcode" name="postcode" placeholder="우편번호" value="<?= $user->postcode ?>" />
                            </div>
                            <div class="col-md-4 form-group p_star">
                                <a href="javascript:searchZipCode();" class="genric-btn primary-border">우편번호 검색</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="address" name="address" placeholder="주소" value="<?= $user->address ?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group p_star">
                            <input type="text" class="form-control" id="detailAddress" name="detailAddress" placeholder="상세주소" value="<?= $user->detailAddress ?>" />
                        </div>
                        <div class="col-md-3 form-group p_star">
                            <input type="text" class="form-control" id="extraAddress" name="extraAddress" placeholder="참고항목" value="<?= $user->extraAddress ?>" />
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-2 form-group p_star">
                            <label for="number">개인정보 <br> 수집동의</label>
                        </div>
                        <div class="col-10 form-group p_star">
                            <span style="font-size:14px; line-height:26px;color:rgb(102,102,102)">
                                1. 개인정보 수집 항목 : <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;① 주문자정보 : 이름, 휴대폰번호, E-MAIL<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;② 배송지정보 : 이름, 전화번호, 휴대폰번호, 주소 <br>

                                2. 개인정보 동의 항목 : 이름, 주소, 전화번호, 휴대폰번호, E-MAIL <br>

                                3. 수집 목적 : 회원가입유무 확인 및 구매 내용에 대한 정확한 회신 <br>
                                4. 개인정보 보유 이용 기간 : 전자상거래 등에서의 소비자보호에 관한 법률 등에서 정한 보존기간 동안 고객님의 개인 정보를 보유합니다.<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 계약 또는 청약철회 등에 관한 기록 : 5년<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 대금결제 및 재화 등의 공급에 관한 기록 : 5년<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 소비자의 불만 또는 분쟁처리에 관한 기록 : 3년<br>
                                <input type="checkbox" name="use_rnd1" id="privacyCheck" class="check_style"><label for="privacyCheck" style="color:rgb(34,34,34);padding-left: 10px;" class="label_style"> 개인정보 수집 이용에 대한 내용을 확인 하였으며 이에 동의 합니다</label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                </div>
            </div>
            <div class="billing_details">
                <h3>결제방법선택</h3>
                <div class="row">
                    <div class="col-md-2 form-group p_star">
                        <input type="radio" name="gopaymethod" id="payWay1" value="iniciskakao">
                        <label for="payWay1">카카오페이</label>
                    </div>
                    <!-- <div class="col-md-2 form-group p_star">
                    <input type="radio" name="gopaymethod" id="payWay1" value="card"><label for="payWay1">Paypal</label>
                </div> -->
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col col-lg-2">
                    <a class="col genric-btn primary" href="#" onclick="">취소</a>
                </div>
                <div class="col col-lg-2">
                    <a class="col genric-btn danger" href="#" onclick="checkOut('<?= $productName ?>', <?= $total_amount ?>, 'rbsejin@gmail.com', '이교복', '010-2702-2346', '서울시 강서구', '07725');">결제</a>
                </div>
            </div>

            <?php
            $tid = "TC0ONETIME";
            $partner_order_id = "1001";
            $tax_free_amount = $total_amount / 10;
            ?>

            <div>
                <!-- CID -->
                <input type="hidden" name="tid" value="<?= $tid ?>"> 
                <!-- 주문번호 -->
                <input type="hidden" name="nOrderNo" value="<?= $partner_order_id ?>"> 
                <!-- 사이트 주문유저id -->
                <input type="hidden" name="nUserNo" value="<?= $userId ?>">   
                <!-- 상품명 -->
                <input type="hidden" name="aProdName" value="<?= $item_name ?>">               
                <!-- 수량 -->
                <input type="hidden" name="nQuantity" value="<?= $total_quantity ?>">                 
                <!-- 상품총액 -->
                <input type="hidden" name="nTotalPrice" value="<?= $total_amount ?>">         
                <!-- 비과세금액 -->
                <input type="hidden" name="nVat" value="<?= $tax_free_amount ?>">   
            </div>
        </form>
    </section>
    <!--================End Checkout Area =================-->
</main>>

<?php
include_once('footer.php');
?>

</html>