
<form method="post" action="CallPaymentKakaoPay">
    <!--
        결제정보셋팅
      -->
    $partner_order_id = "1";
    $partner_user_id = "rbsejin"
    $item_name = "한빛고 와이셔츠 100"
    $quantity = 2
    $total_amount = 60000
    $tax_free_amount = 0

    <input type="hidden" name="partner_order_id" value="<?= $partner_order_id ?>"> <!-- 주문번호 -->
    <input type="hidden" name="partner_user_id" value="<?= $partner_user_id ?>"> <!-- 사이트 주문유저id -->
    <input type="hidden" name="item_name" value="<?= $item_name ?>"> <!-- 상품명 -->
    <input type="hidden" name="quantity" value="<?= $quantity ?>"> <!-- 수량 -->
    <input type="hidden" name="total_amount" value="<?= $total_amount ?>"> <!-- 상품총액 -->
    <input type="hidden" name="tax_free_amount" value="<?= $tax_free_amount ?>"> <!-- 비과세금액 -->

    <input type="submit" value="결제하기">
</form>

