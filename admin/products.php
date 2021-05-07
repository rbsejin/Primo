<?php
include_once('header.php');

if (empty($_SESSION['id']) || $_SESSION['id'] != "admin") {
    echo "<script>alert('관리자로 로그인하세요.');window.location.replace('../');;</script>";
}

// DB 연결
$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

$PHP_SELP = 'products.php';

$LIST_SIZE = 5;
$MORE_PAGE = 2;
$BLOCK_COUNT = 5;

$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'] ? intval($_GET['page']) : 1;
}

$sql = "";
if (empty($_GET['school']) || $_GET['school'] == "전체") {
    $sql = "SELECT CEIL( COUNT(*)/$LIST_SIZE ) FROM item";
} else {
    $sql = "SELECT CEIL( COUNT(*)/$LIST_SIZE ) FROM item WHERE school = '{$_GET['school']}'";
}

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
$page_count = $row[0];

$start_page = max($page - $MORE_PAGE - max($MORE_PAGE - $page_count + $page, 0), 1);
$end_page = min($page + $MORE_PAGE + max($MORE_PAGE - $page + 1, 0), $page_count);

$prev_page = max($start_page - $MORE_PAGE - 1, 1);
$next_page = min($end_page + $MORE_PAGE + 1, $page_count);

$offset = ($page - 1) * $LIST_SIZE;

$getSchool = "";
if (empty($_GET['school']) || $_GET['school'] == "전체") {
    $sql = "SELECT * FROM item LIMIT $offset, $LIST_SIZE";
} else {
    $sql = "SELECT * FROM item WHERE school = '{$_GET['school']}' LIMIT $offset, $LIST_SIZE";
    $getSchool = "school={$_GET['school']}&";
}
$result = mysqli_query($conn, $sql);
?>

<div class="properties__button">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a style="color: black;" class="nav-item nav-link" href="orders.php"> 주문 </a>
            <a style="color: black;" class="nav-item nav-link" href="products.php"> 제품 </a>
        </div>
    </nav>
    <br>
</div>

<main>
    <!-- <div class="main_title">
        <div>
            <h1>제품</h1>
        </div>
    </div> -->
    <div>
        <nav class="nav nav-tabs" id="nav-tab" role="tablist">
            <a href="products.php"> 전체 </a>
            <a href="products.php?school=운정중"> 운정중 </a>
            <a href="products.php?school=한빛중"> 한빛중 </a>
            <a href="products.php?school=한빛고"> 한빛고 </a>
            <a href="products.php?school=동패고"> 동패고 </a>
        </nav>
    </div>
    <div class="properties__button">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a style="color: black;" class="nav-item nav-link" href="products.php"> 전체 </a>
                <a style="color: black;" class="nav-item nav-link" href="products.php?school=운정중"> 운정중 </a>
                <a style="color: black;" class="nav-item nav-link" href="products.php?school=한빛중"> 한빛중 </a>
                <a style="color: black;" class="nav-item nav-link" href="products.php?school=한빛고"> 한빛고 </a>
                <a style="color: black;" class="nav-item nav-link" href="products.php?school=동패고"> 동패고 </a>
            </div>
        </nav>
        <br>
    </div>
    <div>
        <table id="example-table-1" class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th hidden>ID</th>
                    <!-- <th>
                        <input type="checkbox">
                    </th> -->
                    <th>사진</th>
                    <th>제품</th>
                    <th>상태</th>
                    <th>재고</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    $itemId = $row['id'];
                    $itemSchool = $row['school'];
                    $itemName = $row['name'];
                    $itemSex = $row['sex'];
                    $itemPrice = $row['price'];
                    $itemImage = $row['image'];
                    $name = "$itemSchool $itemName";

                    // 총 재고 구한다.
                    $sql = "SELECT SUM(quantity) FROM product WHERE item_id = $itemId";
                    $result2 = mysqli_query($conn, $sql);
                    if ($result2) {
                        $row2 = mysqli_fetch_array($result2);
                        $qantity = $row2[0];
                    }
                ?>
                    <tr>
                        <td hidden>
                            <?= $itemId ?>
                        </td>
                        <!-- <td>
                            <input type="checkbox">
                        </td> -->
                        <td>
                            <img src="../assets/img/gallery/market/<?= "$itemImage" ?>" height="60px">
                        </td>
                        <td><?= $name ?></td>
                        <td>발주</td>
                        <td><?= $qantity ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div>
        <a class="genric-btn primary float-right" href="products/add.php">제품 추가</a>
    </div>
    <nav class="blog-pagination justify-content-center d-flex">
        <ul class="pagination">
            <?php if ($page != 1) { ?>
                <li class="page-item">
                    <a href="<?= "$PHP_SELP?{$getSchool}page=$prev_page" ?>" class="page-link" aria-label="Previous">
                        처음
                    </a>
                </li>
            <?php } ?>
            <?php if ($page != 1) { ?>
                <li class="page-item">
                    <a href="<?= "$PHP_SELP?{$getSchool}page=" . max($page - 1, 1) ?>" class="page-link" aria-label="Previous">
                        <i class="ti-angle-left"></i>
                    </a>
                </li>
            <?php } ?>
            <?php
            for ($i = $start_page; $i <= $end_page; $i++) {
            ?>
                <li class="page-item <?php if ($i == $page) echo 'active' ?>">
                    <a href="<?= "$PHP_SELP?{$getSchool}page=$i" ?>" class="page-link"><?= $i ?></a>
                </li>
            <?php } ?>
            <?php if ($page != $page_count) { ?>
                <li class="page-item">
                    <a href="<?= "$PHP_SELP?{$getSchool}page=" . min($page + 1, $page_count) ?>" class="page-link" aria-label="Next">
                        <i class="ti-angle-right"></i>
                    </a>
                </li>
            <?php } ?>
            <?php if ($page != $page_count) { ?>
                <li class="page-item">
                    <a href="<?= "$PHP_SELP?{$getSchool}page=$next_page" ?>" class="page-link" aria-label="Next">
                        끝
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</main>

<script>
    $("#example-table-1 tr").click(function() {
        var tr = $(this);
        var td = tr.children();

        var id = $.trim(td.eq(0).text());

        var path = "products/update.php";
        var params = {
            'item_id': id
        };
        var method = "post";

        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);

        for (var key in params) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.appendChild(hiddenField);
        }
        document.body.appendChild(form);
        form.submit();
    });
</script>

<?php
include_once('footer.php');
?>