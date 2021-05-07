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

$itemId = "";
$addSize = "";
$removeSize = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['item_id'])) {
        $itemId = $_POST['item_id'];
    }

    if (!empty($_POST['add_size'])) {
        $addSize = $_POST['add_size'];
    }

    if (!empty($_POST['remove_size'])) {
        $removeSize = $_POST['remove_size'];
    }
}

// 사이즈 버튼 클릭했을 때 사이즈 추가
if ($addSize != "") {
    $sql = "INSERT INTO product (size, quantity, item_id) SELECT $addSize, 0, $itemId WHERE NOT EXISTS(SELECT * FROM product WHERE item_id = $itemId AND size = $addSize)";
    $result = mysqli_query($conn, $sql);
}

// 사이즈 삭제을 때 사이즈 삭제
if ($removeSize != "") {
    $sql = "DELETE FROM product WHERE size = $removeSize AND item_id = $itemId";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die();
    }
}

$item = Item::fromBasicDb($conn, $itemId);
if ($item == null) {
    mysqli_close($conn);
    die();
}
$sql = "SELECT * FROM product WHERE item_id = $itemId ORDER BY size ASC";
$result = mysqli_query($conn, $sql);

if (!$result) {
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
    <form id="update" action="upload.php" method="post" enctype="multipart/form-data">
        <div class="col-lg-6">
            <div class="col-md-12">
                <h6>학교</h6>
            </div>
            <div class="col-md-12">
                <!-- <input type="select" name="school" value="<?= $item->school ?>"> -->
                <select name="school" form="update">
                    <!-- <option value="운정중">운정중</option> -->
                    <?php
                    $options = array('운정중', '한빛중', '한빛고', '동패고');

                    $output = '';
                    for ($i = 0; $i < count($options); $i++) {
                        $output .= '<option ' . ($item->school == $options[$i] ? 'selected="selected"' : '') . '>' . $options[$i] . '</option>';
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
                <input type="text" name="name" value="<?= $item->name ?>">
            </div>
            <br>
            <div class="col-md-12">
                <h6>가격</h6>
                <input type="text" name="price" value="<?= $item->price ?>">
            </div>
            <br>
            <div class="col-md-12">
                <h6>이미지</h6>
                <img class="preview" src="../../assets/img/gallery/market/<?= "{$item->image}" ?>" height="180px">
            </div>
            <div class="col-md-12">
                변경할 이미지를 선택하세요: <br>
                <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
                <!-- <button>이미지 복구</button> -->
                <input type="hidden" name="item_id" value=<?= $item->id ?>>
            </div>
            <br>
            <div class="col-md-12">
                <h6>사이즈 추가</h6>
            </div>
            <div>
                <div id="sizes" class="hash_tag tag-container wrapper">
                    <!-- 여기에 사이즈 목록을 버튼으로 추가 -->
                    <?php
                    $productSizes = [];
                    while ($row = mysqli_fetch_array($result)) {
                        $productSize = $row['size'];
                    ?>
                        <p class="tag"><?= $productSize ?></p>
                    <?php } ?>
                </div>
                <div class="wrapper col-md-12">
                    <input type="text" id="size" class="hash_tag" style="background-color: honeydew;">
                    <!-- <input type="text" id="size" class="hash_tag" onkeypress="javascipt:if(event.keyCode==13) { addSize() }"> -->
                </div>
                <!-- <div>
                <input type="text" value="">
                <input type="submit" name_id value="사이즈추가" formaction="size_add.php">
                <input type="hidden" name="item_id" value="<?= $itemId ?>">
            </div> -->
            </div>
            <br>
            <div id="size_div">
                <h6>사이즈</h6>
                <table id="sizeTable" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>
                                사이즈
                            </th>
                            <th>
                                수량
                            </th>
                        </tr>
                    </thead>
                    <tbody id="sizeTbody">
                        <?php
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $productId = $row['id'];
                            $productSize = $row['size'];
                            $productQuantity = $row['quantity'];
                        ?>

                            <tr class="size_row">
                                <td>
                                    <input type="hidden" form="update" name="product_ids[]" value="<?= $productId ?>">
                                    <input type='text' form='update' name='sizes[]' value='<?= $productSize ?>'>
                                </td>
                                <td>
                                    <input type='number' form='update' name='quantities[]' value='<?= $productQuantity ?>' min=0 style='width: 100px;'>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <br>

            <div>
                <!-- <form action="delete.php">
                    <input class="genric-btn primary float-right" type="button" value="삭제">
                    <input type="hidden" name="item_id" value="<?= $itemId ?>">
                </form> -->
                <input class="genric-btn primary float-right" type="button" value="저장" onclick="submitForm()">
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

        return false;
    }

    var table = document.getElementById("sizeTable");

    function removeSize(size) {
        // 사이즈 버튼 제거
        $('span').remove('#' + size);

        // 테이블에서 사이즈 행 제거
        $('tr').remove('#table' + size);

        // 행이 하나도 없으면 테이블 헤더 숨기기
        hideTableHeader();
    }

    var tbodyRowCount = table.tBodies[0].rows.length;
    if (tbodyRowCount == 0) {
        document.getElementById("size_div").style.display = "none";
    }

    function submitForm() {
        document.getElementById("update").submit();
    }

    function submitFormDelete() {
        document.getElementById("delete").submit();
    }

    // 해시태그
    let input, hashtagArray, container, t;

    input = document.querySelector('#size');
    container = document.querySelector('.tag-container');
    var tableBody = document.getElementById("sizeTbody");
    hashtagArray = [];

    input.addEventListener('keyup', () => {
        if (event.which == 13 && input.value.length > 0) {
            // 사이즈 추가
            const form = document.createElement('form');
            form.method = "post";
            form.action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"

            params = {
                item_id: '<?= $itemId ?>',
                add_size: input.value
            };

            for (const key in params) {
                if (params.hasOwnProperty(key)) {
                    const hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.name = key;
                    hiddenField.value = params[key];
                    form.appendChild(hiddenField);
                }
            }
            document.body.appendChild(form);
            form.submit();
        }
    });


    // 이미 사이즈가 있는 버튼의 onClick 이벤트 추가
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
            hideTableHeader();

            //사이즈 삭제
            const form = document.createElement('form');
            form.method = "post";
            form.action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"

            params = {
                item_id: '<?= $itemId ?>',
                remove_size: deleteTags[i].innerHTML.toString()
            };

            for (const key in params) {
                if (params.hasOwnProperty(key)) {
                    const hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.name = key;
                    hiddenField.value = params[key];
                    form.appendChild(hiddenField);
                }
            }
            document.body.appendChild(form);
            form.submit();
        });
    }

    function hideTableHeader() {
        var tbodyRowCount = table.tBodies[0].rows.length;
        if (tbodyRowCount == 0) {
            document.getElementById("size_div").style.display = "none";
        }
    }
</script>

<?php
include_once('footer.php');
mysqli_close($conn);
?>