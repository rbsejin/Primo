<!DOCTYPE html>
<html lang="en">

<?php
include "kakaoPay.php";

$kakaoPay = new KakaoPay();

session_start();
if (!isset($_SESSION['tid'])) {
    die();
}

$aInfo['tid'] = $_SESSION['tid'];
$_SESSION['tid'] = "";
$aInfo['nOrderNo'] = "1001";
$aInfo['nUserNo'] = $_SESSION['id'];
$aInfo['cPgToken'] = $_GET['pg_token'];

$aResult = $kakaoPay->approveRequest($aInfo);
// var_dump($aResult);
?>

<script src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
<script>
    $(document).ready(function() {
        opener.movePage();
        self.close();
    });
</script>

<!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <div class="content">
        <p>카카오페이 결제가 정상적으로 완료되었습니다.</p>
        <p>상품명: <?= $aResult['item_name'] ?></p>
        <p>결제일시: <?= $aResult['approved_at'] ?></p>
        <p>결제금액: <?= $aResult['amount']['total'] ?>원</p>
        <p>결제수단: <?= $aResult['payment_method_type'] ?></p>
    </div>
</body>

</html> -->

<!-- Array ( [aid] => A2883297157807639227 [tid] => T2883297114857357883 [cid] => TC0ONETIME [partner_order_id] => 1001 [partner_user_id] => rbsejin [payment_method_type] => MONEY [item_name] => 한빛고 와이셔츠 100 [quantity] => 1 [amount] => Array ( [total] => 60000 [tax_free] => 0 [vat] => 6000 [point] => 0 [discount] => 0 ) [created_at] => 2021-04-09T21:45:24 [approved_at] => 2021-04-09T21:45:41 ) -->