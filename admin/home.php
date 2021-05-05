<?php
include_once('header.php');

include_once('Item.php');

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

$PHP_SELP = 'orders.php';

$LIST_SIZE = 5;
$MORE_PAGE = 2;
$BLOCK_COUNT = 5;

$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'] ? intval($_GET['page']) : 1;
}

$sql = "SELECT CEIL( COUNT(*)/$LIST_SIZE ) FROM purchase_list";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
$page_count = $row[0];

$start_page = max($page - $MORE_PAGE - max($MORE_PAGE - $page_count + $page, 0), 1);
$end_page = min($page + $MORE_PAGE + max($MORE_PAGE - $page + 1, 0), $page_count);

$prev_page = max($start_page - $MORE_PAGE - 1, 1);
$next_page = min($end_page + $MORE_PAGE + 1, $page_count);

$offset = ($page - 1) * $LIST_SIZE;

$sql = "SELECT purchase_list.id, purchase_list.size, purchase_list.quantity, purchase_list.created, purchase_list.state, purchase_list.subtotal, purchase_list.user_id, purchase_list.pay_id, item.image, item.school, item.name, item.sex, item.price FROM purchase_list LEFT JOIN item ON purchase_list.item_id = item.id ORDER BY created DESC LIMIT $offset, $LIST_SIZE";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die();
}

?>

<nav>
    <ul>
        <li>
            <a href="home.php">
                홈
            </a>
        </li>
        <li>
            <a href="orders.php">
                주문
            </a>
        </li>
        <li>
            <a href="products.php">
                제품
            </a>
        </li>
    </ul>
</nav>

<?php
include_once('footer.php')
?>