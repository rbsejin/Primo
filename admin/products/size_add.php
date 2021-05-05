<?php
$itemId = "";
$size = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['item_id'])) {
        $itemId = $_POST['item_id'];
    }

    if (!empty($_POST['size'])) {
        $size = $_POST['size'];
    }
}

// 사이즈 버튼 클릭했을 때 사이즈 추가
if ($size != "") {
    $sql = "INSERT INTO product (size, quantity, item_id) VALUES ($size, 0, $itemId)";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die();
    }
}

header('location: update.php');