<?php
    session_start();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Watch shop | eCommers</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!--? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/logo.png" alt="">
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
                            <a href="index.php"><img src="assets/img/logo/logo.png" alt=""></a>
                        </div>
                        <!-- Main-menu -->
                        <div class="main-menu d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="#">교하프리모소개</a>
                                        <ul class="submenu">
                                            <li><a href="#">편한교복</a></li>
                                            <li><a href="#">좋은품질</a></li>
                                            <li><a href="#">착한서비스</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="#">라인업</a>
                                        <ul class="submenu">
                                            <li><a href="#">편한교복스타일</a></li>
                                            <li><a href="#">정장하복스타일</a></li>
                                            <li><a href="#">정장동복 스타일</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="#">마켓</a>
                                        <ul class="submenu">
                                            <li><a href="#">남학생복</a></li>
                                            <li><a href="#">여학생복</a></li>
                                            <li><a href="#">생활복</a></li>
                                            <li><a href="#">체육복</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="#">매장/고객센터</a>
                                        <ul class="submenu">
                                            <li><a href="#">공지사항</a></li>
                                            <li><a href="#">일정</a></li>
                                            <li><a href="#">자주묻는질문</a></li>
                                            <li><a href="#">AS문의</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="#">갤러리</a>
                                        <ul class="submenu">
                                            <li><a href="#">협찬</a></li>
                                            <li><a href="#">패션왕</a></li>
                                        </ul>
                                    </li>

                                    <!-- <li><a href="index.php">home</a></li>
                                    <li><a href="shop.html">shop</a></li>
                                    <li><a href="about.html">about</a></li>
                                    <li class="hot"><a href="#">Latest</a>
                                        <ul class="submenu">
                                            <li><a href="shop.html"> Product list</a></li>
                                            <li><a href="product_details.html"> Product Details</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="blog.html">Blog</a>
                                        <ul class="submenu">
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="blog-details.html">Blog Details</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Pages</a>
                                        <ul class="submenu">
                                            <li><a href="login.php">Login</a></li>
                                            <li><a href="cart.html">Cart</a></li>
                                            <li><a href="elements.html">Element</a></li>
                                            <li><a href="confirmation.html">Confirmation</a></li>
                                            <li><a href="checkout.html">Product Checkout</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html">Contact</a></li> -->
                                </ul>
                            </nav>
                        </div>
                        <!-- Header Right -->
                        <div class="header-right">
                            <ul>
                                <!-- <li>
                                    <div class="nav-search search-switch">
                                        <span class="flaticon-search"></span>
                                    </div>
                                </li> -->

                                <?php
                                    if (isset($_SESSION['id'])) {
                                        // 세션이 등록되어있습니다.
                                        // 로그아웃
                                        echo '<li> <a href="logout.php"><span>로그아웃</span></a></li>';
                                        echo '<li> <a href="#"><span class="flaticon-user"></span></a></li>';
                                    } else {
                                        // 세션이 등록되어 있지 않습니다.
                                        // 로그인 화면
                                        echo '<li> <a href="login.php"><span>로그인</span></a></li>';
                                    }
                                ?>
                                <!-- <li><a href="#"><span class="flaticon-shopping-cart"></span></a> </li> -->
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