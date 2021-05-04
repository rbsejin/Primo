<?php
include_once('../Item.php');

$school = $_POST['school'];
$sex = $_POST['sex'];
$name = $_POST['name'];
$price = $_POST['price'];

$quantities = $_POST['quantities'];
$sizes = $_POST['sizes'];

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
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
    $temp = $_FILES["fileToUpload"]["tmp_name"];
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";

        // insert item
        $itemId = Item::insertToDb($conn, $school, $name, $sex, $price, $fileName);
        if ($itemId) {
            echo "<br>제품을 추가했습니다.";

            // insert product
            if (count($sizes) == count($quantities)) {
                for ($i = 0; $i < count($sizes); $i++) {
                    $size = $sizes[$i];
                    $quantity = $quantities[$i];

                    $sql = "INSERT INTO product (size, quantity, item_id) VALUES ($size, $quantity, $itemId)";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        echo "<br>사이즈-수량을 추가했습니다.";
                    } else {
                        echo "<br>사이즈-수량을 추가하지 못했습니다.";
                    }
                }
            }
        } else {
            echo "<br>제품을 추가하지 못했습니다.";
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

mysqli_close($conn);
