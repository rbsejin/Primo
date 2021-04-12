<?php
class KakaoPay
{
    private $cAdminKey          = '87d7e4465b8781828b2d6bd7817bd896';                      // 카카오 어드민 키
    private $cTestStoreKey      = 'TC0ONETIME';            // 상점 아이디 ( 테스트키 : TC0ONETIME )
    private $cStoreKey          = 'TC0ONETIME';                      // 상점 아이디
    private $cServiceUrl        = 'kapi.kakao.com';        // 서비스 URL
    private $cMonthStoreKey     = '';                      // 상점 아이디 ( 정기결제 )
    private $cTestMonthStoreKey = 'TCSUBSCRIP';            // 상점 아이디 ( 정기결제 테스트키 : TCSUBSCRIP )
    private $aPayPostUrl        = array();
    private $cApprovalUrl       = 'http://192.168.0.18/primo/kakao_success.php'; // 결제 성공 URL
    private $cFailUrl           = 'http://192.168.0.18/primo/kakao_fail.php'; // 결제 실패 URL
    private $cCancelUrl         = 'http://192.168.0.18/primo/kakao_cancel.php'; // 결제 취소 URL
    private $cHeaderInfo        = array();

    public function __construct($type = '')
    {
        $this->aPayPostUrl = array(
            'ready'    => 'https://kapi.kakao.com/v1/payment/ready',    // 결제 준비 요청
            'approval' => 'https://kapi.kakao.com/v1/payment/approve',  // 결제 승인 요청
        );
    }

    // 결제 코드 변경 하기
    public function setStoreKey($cType)
    {
        if ($cType != '') {
            $cType = strtoupper($cType);
            if ($cType == 'S') {
                $this->cStoreKey = $this->cStoreKey;
            } elseif ($cType == 'T') {
                $this->cStoreKey = $this->cMonthStoreKey;
            } elseif ($cType == 'TM') {
                $this->cStoreKey = $this->cTestMonthStoreKey;
            } else {
                $this->cStoreKey = $this->cTestStoreKey;
            }
        }
    }

    public function initCurl($aData)
    {
        $aPostData = '';

        foreach ($aData['sData'] as $sKey => $val) {
            $aPostData .= $aPostData == '' ? $sKey . '=' . urlencode($val) : '&' . $sKey . '=' . urlencode($val);
        }

        $curl = null;
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $aData['sUrl']);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->cHeaderInfo);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $aPostData);

        $gData = curl_exec($curl);

        curl_close($curl);

        return $gData;
    }

    /**
     *  결제 준비
     */

    function kakaoPayReady($aInfo)
    {
        $aResult = '';

        if (COUNT($aInfo) > 0 && is_array($aInfo)) {
            $this->cHeaderInfo = array(

                'POST /v1/payment/ready HTTP/1.1',
                'Host: ' . $this->cServiceUrl,
                'Authorization: KakaoAK ' . $this->cAdminKey,
                'Content-type: application/x-www-form-urlencoded;charset=utf-8'
            );

            $aPostData = array(
                'cid'              => $this->cStoreKey,           // 가맹점 코드. 10자.	O	String
                'partner_order_id' => $aInfo['nOrderNo'],          // 가맹점 주문번호. 최대 100자	O	String
                'partner_user_id'  => $aInfo['nUserNo'],          // 가맹점 회원 id. 최대 100자	O	String
                'item_name'        => $aInfo['aProdName'],        // 상품명. 최대 100자	O	String
                'quantity'         => $aInfo['nQuantity'],                          // 상품 수량	O	Integer
                'total_amount'     => $aInfo['nTotalPrice'],      // 상품 총액	O	Integer
                'tax_free_amount'  => 0,                          // 상품 비과세 금액	O	Integer
                'vat_amount'       => $aInfo['nVat'],              // 상품 부가세 금액(안보낼 경우 (상품총액 - 상품 비과세 금액)/11 : 소숫점이하 반올림)	X	Integer
                'approval_url'     => $this->cApprovalUrl,          // 결제 성공시 redirect url. 최대 255자	O	String
                'cancel_url'       => $this->cCancelUrl,          // 결제 취소시 redirect url. 최대 255자	O	String
                'fail_url'         => $this->cFailUrl,              // 결제 실패시 redirect url. 최대 255자	O	String
            );

            $aSendData = array(
                'sUrl'  => $this->aPayPostUrl['ready'],
                'sData' => $aPostData
            );

            $aResult = $this->initCurl($aSendData);
            $aResult = json_decode($aResult, true);
        }

        return $aResult;
    }

    /**
     * 결제 승인 요청
     */

    public function approveRequest($aInfo)
    {
        $aResult = '';

        if (COUNT($aInfo) > 0 && is_array($aInfo)) {
            $this->cHeaderInfo = array(
                'POST /v1/payment/approve HTTP/1.1',
                'Host: ' . $this->cServiceUrl,
                'Authorization: KakaoAK ' . $this->cAdminKey,
                'Content-type: application/x-www-form-urlencoded;charset=utf-8'
            );

            $aPostData = array(
                'cid'              => $this->cStoreKey,           // 가맹점 코드. 10자.	O	String
                'tid'              => $aInfo['tid'],              // 결제 고유번호
                'partner_order_id' => $aInfo['nOrderNo'],          // 가맹점 주문번호. 최대 100자	O	String
                'partner_user_id'  => $aInfo['nUserNo'],          // 가맹점 회원 id. 최대 100자	O	String
                'pg_token'         => $aInfo['cPgToken'],         // 결제 승인 요청 시 가져오는 값
            );

            $aSendData = array(
                'sUrl'  => $this->aPayPostUrl['approval'],
                'sData' => $aPostData
            );

            $aResult = $this->initCurl($aSendData);
            $aResult = json_decode($aResult, true);
        }

        return $aResult;
    }
}
