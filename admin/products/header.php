<!DOCTYPE html>
<html lang="en">

<!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            height: 500px;
            background-color: aqua;
        }

        .content {
            display: flex;
            flex-grow: 1;
        }

        .main_title {
            display: flex;
            flex-direction: row;
        }

        ul {
            list-style: none;
        }

        ul.menu {
            list-style: none;
            margin: 0px;
            padding: 0px;
        }

        li.item {
            margin: 0px;
            margin-right: 15px;
            padding: 0px;
            float: left;
        }

        table {
            clear: left;
        }

        nav {
            flex-basis: 150px;

            background-color: tan;
        }

        main {
            flex-grow: 1;
            background-color: antiquewhite;
        }

        header {
            background-color: blue;
        }

        footer {
            background-color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>관리자 페이지</h1>
        </header>
        <section class="content"> -->



<?php
session_start();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>교하 프리모 학생복</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="../../site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.ico">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- CSS here -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../assets/css/flaticon.css">
    <link rel="stylesheet" href="../../assets/css/slicknav.css">
    <link rel="stylesheet" href="../../assets/css/animate.min.css">
    <link rel="stylesheet" href="../../assets/css/magnific-popup.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../../assets/css/slick.css">
    <link rel="stylesheet" href="../../assets/css/nice-select.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body>
    <!--? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="../../assets/img/logo/logo.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="menu-wrapper">
                        <!-- Logo -->
                        <div class="logo">
                            <a href="../../index.php"><img src="../../assets/img/logo/logo.png" alt=""></a>
                        </div>
                        <!-- Main-menu -->
                        <div class="main-menu d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="about.php">교하프리모소개</a>
                                        <!-- <ul class="submenu">
                                            <li><a href="#">편한교복</a></li>
                                            <li><a href="#">좋은품질</a></li>
                                            <li><a href="#">착한서비스</a></li>
                                        </ul> -->
                                    </li>

                                    <!-- <li><a href="#">라인업</a>
                                        <ul class="submenu">
                                            <li><a href="#">편한교복스타일</a></li>
                                            <li><a href="#">정장하복스타일</a></li>
                                            <li><a href="#">정장동복스타일</a></li>
                                        </ul>
                                    </li> -->

                                    <li><a href="#">마켓</a>
                                        <ul class="submenu">
                                            <li><a href="../../market.php?sex=W&school=한빛고">여학생복</a></li>
                                            <li><a href="../../market.php?sex=M&school=한빛고">남학생복</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="#">고객센터</a>
                                        <ul class="submenu">
                                            <!-- <li><a href="#">공지사항</a></li> -->
                                            <li><a href="../../as.php">AS문의</a></li>
                                        </ul>
                                    </li>

                                    <!-- <li><a href="#">갤러리</a>
                                        <ul class="submenu">
                                            <li><a href="#">협찬</a></li>
                                            <li><a href="#">패션왕</a></li>
                                        </ul>
                                    </li> -->

                                    <?php
                                    if (isset($_SESSION['id'])) {
                                        if ($_SESSION['id'] == "admin") {
                                    ?>
                                            <li><a href="../../admin/orders.php" .php">관리</a>
                                                <ul class="submenu">
                                                    <li><a href="../../admin/orders.php">주문</a></li>
                                                    <li><a href="../../admin/products.php">제품</a></li>
                                                </ul>
                                            </li>
                                    <?php }
                                    } ?>
                                </ul>
                            </nav>
                        </div>
                        <!-- Header Right -->
                        <div class="header-right">
                            <ul>
                                <?php
                                if (isset($_SESSION['id'])) {
                                    // 세션이 등록되어있습니다.
                                    // 로그아웃
                                    echo '<li> <a href="../../modify_pass.php"><span>';
                                    echo $_SESSION['id'] . '님';
                                    echo '</span></a></li>';
                                    echo '<li> <a href="../../logout.php"><span>로그아웃</span></a></li>';
                                    echo '<li> <a href="../../my_page.php"><span class="flaticon-user"></span></a></li>';
                                    echo '<li><a href="../../cart.php"><span class="flaticon-shopping-cart"></span></a> </li>';
                                } else {
                                    // 세션이 등록되어 있지 않습니다.
                                    // 로그인 화면
                                    echo '<li> <a href="../../login.php"><span>로그인</span></a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>