<button onclick="cancelPay()">환불하기</button>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<!-- jQuery CDN --->
<script>
    function cancelPay() {
        jQuery.ajax({
            "url": "http://www.myservice.com/payments/cancel",
            "type": "POST",
            "contentType": "application/json",
            "data": JSON.stringify({
                "merchant_uid": "mid_" + new Date().getTime(), // 주문번호
                "cancel_request_amount": 2000, // 환불금액
                "reason": "테스트 결제 환불", // 환불사유
                "refund_holder": "홍길동", // [가상계좌 환불시 필수입력] 환불 수령계좌 예금주
                "refund_bank": "88", // [가상계좌 환불시 필수입력] 환불 수령계좌 은행코드(ex. KG이니시스의 경우 신한은행은 88번)
                "refund_account": "56211105948400" // [가상계좌 환불시 필수입력] 환불 수령계좌 번호
            }),
            "dataType": "json"
        });
    }
</script>