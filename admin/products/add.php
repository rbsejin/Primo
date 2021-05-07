<?php
include_once('header.php');

include_once('../Item.php');

if (empty($_SESSION['id']) || $_SESSION['id'] != "admin") {
    echo "<script>alert('관리자로 로그인하세요.');window.location.replace('../../');;</script>";
}

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}
?>

<style>
    @import url('https://fonts.googleapis.com/css?family=Work+Sans:300,400');

    /* body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        overflow: hidden;
        font-family: 'Work Sans', sans-serif;
        background-color: #1a284f;
        color: white;
    } */

    .wrapper {
        /* padding: 20px 28px; */
        margin: 0;
        width: 400px;
        /* background-color: #273c75; */
        background-color: honeydew;
        /* border-radius: 30px; */
        display: flex;
        /* align-items: center; */
        flex-flow: row wrap;
        /* border: solid 2px white; */
    }

    h3.hash_tag {
        margin: 10px 14px 10px 0;
        font-weight: 300;
        font-size: 36px;
    }

    p.hash_tag {
        margin: 10px 10px;
        font-weight: 300;
        font-size: 14px;
        opacity: 0.8;
        letter-spacing: 1px;
    }

    input.hash_tag {
        border: none;
        /* border-radius: 12px; */
        /* padding: 16px 20px; */
        /* margin: 8px; */
        width: 100%;
        color: #666;
        font-family: 'Work Sans', sans-serif;
        font-size: 16px;
        outline: none;
    }

    .tag-container {
        display: flex;
        flex-flow: row wrap;
    }

    .tag {
        pointer-events: none;
        background-color: #242424;
        color: white;
        padding: 6px;
        margin: 5px;
    }

    .tag::after {
        pointer-events: all;
        display: inline-block;
        content: 'x';
        height: 20px;
        width: 20px;
        margin-left: 6px;
        text-align: center;
        color: #ccc;
        background-color: #111;
        cursor: pointer;
    }
</style>

<div class="properties__button">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a style="color: black;" class="nav-item nav-link" href="../orders.php"> 주문 </a>
            <a style="color: black;" class="nav-item nav-link" href="../products.php"> 제품 </a>
        </div>
    </nav>
    <br>
</div>

<main>
    <form id="add" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="col-lg-6">
            <div class="col-md-12">
                <h6>학교</h6>
            </div>
            <div class="col-md-12">
                <select name="school" form="add">
                    <?php
                    $options = array('선택', '운정중', '한빛중', '한빛고', '동패고');

                    $output = '';
                    for ($i = 0; $i < count($options); $i++) {
                        $output .= '<option>' . $options[$i] . '</option>';
                    }
                    echo $output;
                    ?>
                </select>
            </div>
            <br>
            <br>
            <br>
            <div class="col-md-12">
                <h6>품목명</h6>
                <input type="text" name="name" value="">
            </div>
            <br>
            <div class="col-md-12">
                <h6>성별</h6>
                <input type="radio" name="sex" id="man" value="M">
                <label for="man">남자</label>
                <input type="radio" name="sex" id="woman" value="W">
                <label for="woman">여자</label>
                <input type="radio" name="sex" id="command" value="C">
                <label for="command">공통</label>
            </div>
            <br>
            <div class="col-md-12">
                <h6>가격</h6>
                <input type="text" name="price" value="" maxlength="6">
            </div>
            <br>
            <div class="col-md-12">
                <h6>이미지</h6>
                <img class="preview" src="../../assets/img/gallery/market/default.jpg" height="180px">
            </div>
            <div class="col-md-12">
                변경할 이미지를 선택하세요: <br>
                <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
            </div>
            <br>
            <div class="col-md-12">
                <h6>사이즈 추가</h6>
            </div>
            <!-- <div style="border-style: groove; width: 405px; background-color: white;"> -->
            <div>
                <div id="sizes" class="hash_tag tag-container wrapper">
                    <!-- 여기에 사이즈 목록을 버튼으로 추가 -->
                </div>
                <div class="wrapper col-md-12">
                    <input style="background-color: honeydew;" type="text" id="size" class="hash_tag" onkeypress="javascipt:if(event.keyCode==13) { addSize() }">
                    <!-- <button type="button" onclick="addSize()">
                    추가
                </button> -->
                </div>
            </div>
            <br>
            <div id="size_div" style="display: none;">
                <h6>사이즈</h6>
                <table id="sizeTable" class="table table-bordered table-hover text-center" style="width: 300px;">
                    <thead>
                        <tr>
                            <th style="width: 100px">
                                사이즈
                            </th>
                            <th style="width: 100px;">
                                수량
                            </th>
                        </tr>
                    </thead>
                    <tbody id="sizeTbody">
                        <!-- 사이즈 행 추가 -->
                    </tbody>
                </table>
            </div>
            <!-- <div class="col-md-12" style="height: 100px; border: green;"> -->
            <!-- </div> -->
            <div class="col-md-12">
                <input type="button" value="추가" onclick="submitForm()">
            </div>
        </div>
    </form>
</main>

<script>
    const fileInput = document.querySelector('input[type="file"]');
    const preview = document.querySelector('img.preview');
    const reader = new FileReader();

    fileInput.addEventListener('change', function(e) {
        const selectedFile = fileInput.files[0];
        if (selectedFile) {
            reader.addEventListener('load', function(event) {
                if (event.type === "load") {
                    preview.src = reader.result;
                }
            });
            reader.readAsDataURL(selectedFile);
        }
    });

    function addSize() {
        var sizeText = document.getElementById("size").value;
        var size = parseInt(sizeText);
        if (isNaN(size)) {
            alert("숫자만 입력하세요.");
            return false;
        }

        // // 사이즈 버튼 추가
        // var buttonHtml = "<span id='" + size + "'><span>" + size + "</span><button type='button' onClick='removeSize(" + sizeText + ")'>x</button></span>";
        // $("#sizes").append(buttonHtml);

        // 테이블 헤더 보이기
        document.getElementById("size_div").style.display = "block";

        // 테이블에 사이즈 추가
        var trHtml = "<tr id='table" + size + "' class='size_row'>" +
            "<td>" +
            size +
            "<input type='hidden' form='add' name='sizes[]' value='" + size + "'>" +
            "</td>" +
            "<td>" +
            "<input type='number' form='add' name='quantities[]' value='0' min=0 style='width: 100px;'>" +
            "</td>" +
            "</tr>";

        $("#sizeTbody").append(trHtml);

        // document.getElementById("size").value = "";

        return true;
    }

    function removeSize(size) {
        // 사이즈 버튼 제거
        $('span').remove('#' + size);

        // 테이블에서 사이즈 행 제거
        $('tr').remove('#table' + size);

        // 행이 하나도 없으면 테이블 헤더 숨기기
        var table = document.getElementById("sizeTable");
        var tbodyRowCount = table.tBodies[0].rows.length;
        if (tbodyRowCount == 0) {
            document.getElementById("size_div").style.display = "none";
        }
    }

    function submitForm() {
        document.getElementById("add").submit();
    }

    // 해시태그
    let input, hashtagArray, container, t;

    input = document.querySelector('#size');
    container = document.querySelector('.tag-container');
    var tableBody = document.getElementById("sizeTbody");
    hashtagArray = [];

    input.addEventListener('keyup', () => {
        if (event.which == 13 && input.value.length > 0) {
            var text = document.createTextNode(input.value);

            var p = document.createElement('p');
            container.appendChild(p);
            p.appendChild(text);
            p.classList.add('tag');
            input.value = '';

            let deleteTags = document.querySelectorAll('.tag');
            let deleteRows = document.querySelectorAll('.size_row');

            for (let i = 0; i < deleteTags.length; i++) {
                deleteTags[i].addEventListener('click', () => {
                    try {
                        container.removeChild(deleteTags[i]);
                        tableBody.removeChild(deleteRows[i]);
                    } catch (error) {
                        console.log(error.name + ": " + error.message);
                    }

                    // 행이 하나도 없으면 테이블 헤더 숨기기
                    var table = document.getElementById("sizeTable");
                    var tbodyRowCount = table.tBodies[0].rows.length;
                    if (tbodyRowCount == 0) {
                        document.getElementById("size_div").style.display = "none";
                    }
                });
            }
        }
    });
</script>

<?php
include_once('footer.php')
?>

<?php
// Form 필수 입력 검증
$school = "";
$sex = "";
$name = "";
$price = "";

$quantities = [];
$sizes = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['school']) || $_POST['school'] == "선택") {
        echo "<script>alert('학교를 선택하세요.');</script>";
        die();
    } else {
        $school = $_POST['school'];
    }

    if (empty($_POST['name'])) {
        echo "<script>alert('품목을 입력하세요.');</script>";
        die();
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['sex'])) {
        echo "<script>alert('성별을 선택하세요.');</script>";
        die();
    } else {
        $sex = $_POST['sex'];
    }

    if (empty($_POST['price'])) {
        echo "<script>alert('가격을 입력하세요.');</script>";
        die();
    } else {
        $price = $_POST['price'];
    }

    if (!empty($_POST['quantities'])) {
        $quantities = $_POST['quantities'];
    }

    if (!empty($_POST['sizes'])) {
        $sizes = $_POST['sizes'];
    }

    $target_dir = "../../assets/img/gallery/market/";
    $fileName = basename($_FILES["fileToUpload"]["name"]);

    if (empty($fileName)) {
        echo "<script>alert('이미지 파일을 추가해주세요.');</script>";
        die();
    }

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
            echo "<script>alert('File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "<script>alert('File is not an image.";
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
        echo "<script>alert('Sorry, your file is too large.');</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.');</script>";
        // if everything is ok, try to upload file
    } else {
        $temp = $_FILES["fileToUpload"]["tmp_name"];
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // echo "<script>alert('The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.');</script>";

            // insert item
            $itemId = Item::insertToDb($conn, $school, $name, $sex, $price, $fileName);
            if ($itemId) {
                // insert product
                if (count($sizes) == count($quantities)) {
                    for ($i = 0; $i < count($sizes); $i++) {
                        $size = $sizes[$i];
                        $quantity = $quantities[$i];

                        $sql = "INSERT INTO product (size, quantity, item_id) VALUES ($size, $quantity, $itemId)";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            echo "<script>alert('사이즈-수량을 추가했습니다.');</script>";
                        } else {
                            echo "<script>alert('사이즈-수량을 추가하지 못했습니다.');</script>";
                        }
                    }
                }

                echo "<script>alert('제품을 추가했습니다.'); window.location.replace('../products.php');</script>";
            } else {
                echo "<script>alert('제품을 추가하지 못했습니다.');</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    }
}

?>