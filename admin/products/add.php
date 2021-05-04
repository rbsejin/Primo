<?php
include_once('../header.php');

include_once('../Item.php');

$conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
if (!$conn) {
    echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
    die();
}

mysqli_close($conn);
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
        background-color: white;
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

<main>
    <form id="add" action="insert.php" method="post" enctype="multipart/form-data">
        <div>
            <h6>학교</h6>
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
        <div>
            <h6>품목명</h6>
            <input type="text" name="name" value="">
        </div>
        <div>
            <h6>성별</h6>
            <input type="radio" name="sex" id="man" value="M">
            <label for="man">남자</label>
            <input type="radio" name="sex" id="woman" value="W">
            <label for="woman">여자</label>
            <input type="radio" name="sex" id="command" value="C">
            <label for="command">공통</label>
        </div>
        <div>
            <h6>가격</h6>
            <input type="text" name="price" value="" maxlength="6">
        </div>
        <div>
            <h6>이미지</h6>
            <img class="preview" src="../../assets/img/gallery/market/default.jpg" height="180px">
        </div>
        <div>
            변경할 이미지를 선택하세요:
            <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
        </div>
        <div>
            <h6>사이즈 추가</h6>
        </div>
        <!-- <div style="border-style: groove; width: 405px; background-color: white;"> -->
        <div>
            <div id="sizes" class="hash_tag tag-container wrapper">
                <!-- 여기에 사이즈 목록을 버튼으로 추가 -->
            </div>
            <div class="wrapper">
                <input type="text" id="size" class="hash_tag" onkeypress="javascipt:if(event.keyCode==13) { addSize() }">
                <!-- <button type="button" onclick="addSize()">
                    추가
                </button> -->
            </div>
        </div>
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
        <div style="height: 100px; border: green;">

        </div>
        <div>
            <input type="button" value="추가" onclick="submitForm()">
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
include_once('../footer.php')
?>