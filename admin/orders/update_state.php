<?php
$pay_id = $_POST['pay_id'];
$state = $_POST['purchase_state'];

echo $pay_id;
echo "<br>";
echo $state;

// DB 연결
$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

// purchase_list의 상태를 변경한다.
if ($state != "") {
    $sql = "UPDATE purchase_list SET state = '$state' WHERE pay_id = $pay_id";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "쿼리 오류";
        die();
    }
}

if ($state == '취소') {
    // 주문취소인 경우 환불을 진행한다.
    $sql = "SELECT imp_uid, merchant_uid, paid_amount FROM pay_info WHERE id = $pay_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $imp_uid = $row['imp_uid'];
    $merchant_uid = $row['merchant_uid'];
    $paid_amount = $row['paid_amount'];

    require_once('../../iamport.php');

    $iamport = new Iamport('9298494788902599', '36cb682739262e0d09f7e51bb26c604a5974b6f0684a60ab705a8bddc7abc6d264dbf6df462a1202');

    #3. 주문취소
    $result = $iamport->cancel(array(
        'imp_uid'        => $imp_uid,         //merchant_uid에 우선한다
        'merchant_uid'    => $merchant_uid,     //imp_uid 또는 merchant_uid가 지정되어야 함
        'amount'         => $paid_amount,                    //amount가 생략되거나 0이면 전액취소. 금액지정이면 부분취소(PG사 정책별, 결제수단별로 부분취소가 불가능한 경우도 있음)
        'reason'        => '취소테스트',                //취소사유
        'refund_holder' => '', //'환불될 가상계좌 예금주', 		//이용 중인 PG사에서 가상계좌 환불 기능을 제공하는 경우. 일반적으로 특약 계약이 필요
        'refund_bank'    => '', //'환불될 가상계좌 은행코드',
        'refund_account' => '' //'환불될 가상계좌 번호'
    ));
    if ($result->success) {
        /**
         *	IamportPayment 를 가리킵니다. __get을 통해 API의 Payment Model의 값들을 모두 property처럼 접근할 수 있습니다.
         *	참고 : https://api.iamport.kr/#!/payments/cancelPayment 의 Response Model
         */
        $payment_data = $result->data;

        // echo '## 취소후 결제정보 출력 ##';
        // echo '결제상태 : '         . $payment_data->status;
        // echo '결제금액 : '         . $payment_data->amount;
        // echo '취소금액 : '         . $payment_data->cancel_amount;
        // echo '결제수단 : '         . $payment_data->pay_method;
        // echo '결제된 카드사명 : '     . $payment_data->card_name;
        // echo '결제(취소) 매출전표 링크 : '    . $payment_data->receipt_url;
        //등등 __get을 선언해 놓고 있어 API의 Payment Model의 값들을 모두 property처럼 접근할 수 있습니다.
    } else {
        error_log($result->error['code']);
        error_log($result->error['message']);
    }
}

header('location: ../orders.php');
