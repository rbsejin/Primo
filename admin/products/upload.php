<?php
include_once('../Item.php');

$school = $_POST['school'];
$itemId = $_POST['item_id'];
$name = $_POST['name'];
$price = $_POST['price'];

$productIds = $_POST['product_ids'];
$sizes = $_POST['sizes'];
$quantities = $_POST['quantities'];

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

$item = Item::fromBasicDb($conn, $itemId);
if ($item == null) {
    mysqli_close($conn);
    die();
}

$target_dir = "../../assets/img/gallery/market/";
$fileName = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $fileName;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = false;
    if ($_FILES["fileToUpload"]["tmp_name"] != "") {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    }
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
// if (file_exists($target_file)) {
//   echo "Sorry, file already exists.";
//   $uploadOk = 0;
// }

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";

        // 성공했다면 원본을 지운다.
        if ($item->image != $fileName) {
            @unlink("../../assets/img/gallery/market/{$item->image}");
        }

        // 파일 db 업데이트
        $sql = "UPDATE item SET image = '$fileName' WHERE id = {$item->id}";
        $result = mysqli_query($conn, $sql);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// DB-item table의 image를 변경한다.
$sql = "UPDATE item SET school = '{$school}' WHERE id = {$item->id}";
$result = mysqli_query($conn, $sql);

$sql = "UPDATE item SET name = '{$name}' WHERE id = {$item->id}";
$result = mysqli_query($conn, $sql);

$sql = "UPDATE item SET price = $price WHERE id = {$item->id}";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo '실패';
    mysqli_close($conn);
} else {
    // product table에서 사이즈-수량을 수정한다.
    for ($i = 0; $i < count($productIds); $i++) {
        $productId = $productIds[$i];
        $size = $sizes[$i];
        $sql = "UPDATE product SET size = $size WHERE id = {$productId}";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "사이즈 변경 실패";
        }

        $quantity = $quantities[$i];
        $sql = "UPDATE product SET quantity = $quantity WHERE id = {$productId}";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "수량 변경 실패";
        }
    }
}
