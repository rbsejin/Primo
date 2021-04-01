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
    $sql = "SELECT * FROM as_board WHERE number = $view_num";
    $result = mysqli_query($conn, $sql);
    ?>

    <?php if ($row = mysqli_fetch_array($result)) { ?>
        <form action="as-updateok.php" method="post">
            <!-- <input type="hidden" name="bdGroup" value=<%=bdGroup%>>
            <input type="hidden" name="bdOrder" value=<%=bdOrder%>>
            <input type="hidden" name="bdIndent" value=<%=bdIndent%>> -->
            <input type="text" name="bdTitle" class="form-control mt-4 mb-2" value="<?= $row['title'] ?>" required>
            <div class="form-group">
                <textarea class="form-control" rows="10" name="bdContent" required><?= $row['content'] ?></textarea>
            </div>
            <input type="hidden" name="number" value="<?= $row['number'] ?>" required>
            <div class="form-row float-right">
                <button type="submit" class="btn btn-secondary mb-3">수정하기</button>
            </div>
        </form>
    <?php } ?>

    <?php

    ?>

    <!--================login_part end =================-->
</main>

<?php
include_once('footer.php');
?>

</html>