 <?php
    $title = 'request';
    include_once('inc/header.php');
?>

<?php
$name = $_POST["username"];
$email = $_POST["useremail"];
echo $name . '님의 이메일은' . $email . '입니다.'
?>