<!doctype html>
<html lang="zxx">
<?php
include_once('header.php');
?>

<main>
    <!-- Hero Area Start-->
    <div class="slider-area ">
        <div class="single-slider slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>AS문의</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End-->
    <!--================login_part Area =================-->



    <?php
    $conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");

    // if (!$conn) {
    //     echo 'db에 연결하지 못했습니다.'. mysqli_connect_error();
    // } else {
    //     echo 'db에 접속했습니다.';
    // }


    $view_num = $_POST['number'];
    $sql = "DELETE FROM as_board WHERE number = $view_num";
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
    echo "<meta http-equiv='refresh' content='0; url=as.php'>";
    ?>

    <!--================login_part end =================-->
</main>

<?php
include_once('footer.php');
?>

</html>