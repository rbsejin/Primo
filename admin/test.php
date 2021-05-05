<?php
$nameMsg = $emailMsg = $genderMsg = $websiteMsg = $favtopicMsg = $commentMsg = "";
$name = $email = $gender = $website = $favtopic = $comment = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 이름에 대한 필수 입력 검증
    if (empty($_POST["name"])) {
        $nameMsg = "이름을 입력해 주세요!";
    } else {
        $name = $_POST["name"];
    }

    // 성별에 대한 필수 입력 검증
    if (!isset($_POST["gender"]) || $_POST["gender"] == false) {
        $genderMsg = "성별을 선택해 주세요!";
    } else {
        $gender = $_POST["gender"];
    }

    $email = $_POST["email"];
    $website = $_POST["website"];

    // 관심 있는 분야에 대한 필수 입력 검증
    if (empty($_POST["favtopic"])) {
        $favtopicMsg = "하나 이상 골라주세요!";
    } else {
        $favtopic = $_POST["favtopic"];
    }

    $comment = $_POST["comment"];
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    <p class="alert">* : 필수 입력 사항</p>

    이름 : <input type="text" name="name"><span class="alert"> * <?php echo $nameMsg ?></span><br>

    성별 :
    <input type="radio" name="gender" value="female">여자
    <input type="radio" name="gender" value="male">남자 <span class="alert"> * <?php echo $genderMsg ?></span><br>

    이메일 : <input type="text" name="email"><br>

    홈페이지 : <input type="text" name="website"><br>

    관심 있는 분야 :
    <input type="checkbox" name="favtopic[]" value="movie"> 영화
    <input type="checkbox" name="favtopic[]" value="music"> 음악
    <input type="checkbox" name="favtopic[]" value="game"> 게임
    <input type="checkbox" name="favtopic[]" value="coding"> 코딩

    <span class="alert"> * <?php echo $favtopicMsg ?></span><br>

    기타 : <textarea name="comment"></textarea><br>

    <input type="submit" value="전송">

</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h2>입력된 회원 정보</h2>";
    echo "이름 : " . $name . "<br>";
    echo "성별 : " . $gender . "<br>";
    echo "이메일 : " . $email . "<br>";
    echo "홈페이지 : " . $website . "<br>";
    echo "관심 있는 분야 : ";

    if (!empty($favtopic)) {
        foreach ($favtopic as $value) {
            echo $value . " ";
        }
    }

    echo "<br>기타 : " . $comment;
}
?>