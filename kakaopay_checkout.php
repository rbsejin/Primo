<?php
include "kakaoPay.php";

$kakaoPay = new KakaoPay();
$aResult = $kakaoPay->kakaoPayReady($_POST);

session_start();
$_SESSION['tid'] = $aResult['tid'];

$url = $aResult['next_redirect_pc_url'];
header("location: $url");
