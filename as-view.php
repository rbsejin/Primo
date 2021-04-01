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


    $view_num = $_GET['number'];
    $sql = "SELECT * FROM as_board WHERE number = $view_num";
    $result = mysqli_query($conn, $sql);
    ?>

    <div class="container my-3">
        <div class="row">
            <!-- 게시물 내용 출력 -->
            <div class="container my-1">
                <div class="row">
                    <?php if ($row = mysqli_fetch_array($result)) { ?>
                        <table class="table">
                            <thead>
                                <tr class="table-active">
                                    <th scope="col" style="width: 60%">제목: <?= $row['title'] ?> <br>
                                        작성자: <?= $row['userid'] ?></th>
                                    <th scope="col" style="width: 40%" class="text-right">조회 : <?= $row['view'] ?>
                                        <br> <?= $row['created'] ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <pre><?= $row['content'] ?></pre>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>

            <div class="col"></div>
            <div class="col-md-auto">
                <!-- 답글 작성은 로그인이 필요합니다. -->
                <div class="row">
                    <form action="as.php" method="post">
                        <button type="submit" class="btn btn-secondary">목록</button>
                    </form>
                    <!-- <?php if (isset($_SESSION['id'])) { ?>
                        <form action="#" method="post">
                            <input type="hidden" name="bdGroup" value="">
                            <input type="hidden" name="bdOrder" value="">
                            <input type="hidden" name="bdIndent" value="">
                            <button type="submit" class="btn btn-secondary">답글쓰기</button>
                        </form>
                        <?php } ?> -->
                    <?php if ($row['userid'] == $_SESSION['id']) { ?>
                        <form action="as-update.php" method="post">
                            <input type="hidden" name="bdGroup" value="">
                            <input type="hidden" name="bdOrder" value="">
                            <input type="hidden" name="bdIndent" value="">
                            <input type="hidden" name="number" value=<?= $row['number'] ?>>
                            <button type="submit" class="btn btn-secondary">수정</button>
                        </form>
                        <form action="as-delete.php" method="post">
                            <input type="hidden" name="bdGroup" value="">
                            <input type="hidden" name="bdOrder" value="">
                            <input type="hidden" name="bdIndent" value="">
                            <input type="hidden" name="number" value=<?= $row['number'] ?>>
                            <button type="submit" class="btn btn-secondary">삭제</button>
                        </form>
                    <?php } else {
                        $view = $row['view'] + 1;
                        $sql = "UPDATE as_board SET view = $view WHERE number = $view_num";
                        $result = mysqli_query($conn, $sql);
                    } ?>
                </div>
            </div>
        </div>
    </div>

    <!--================login_part end =================-->
</main>

<?php
include_once('footer.php');
?>

</html>