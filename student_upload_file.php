<?php
//Проверяем вход
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
//Подключаем файл для получения соединения к базе данных
require_once 'vendor/connect.php';
//Получаем ID
$id_curs = $_GET['idcurs'];
$id_file = $_GET['idfile'];
$id_user = $_GET['iduser'];
$id_user_s = $_SESSION['user']["id"];
$fileindb = $_GET['fileindb'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Преподаватель</title>
    <link rel="stylesheet" href="assets/css/work.css">
    <style>
        body {
            font-family: "Lato", sans-serif;
        }
    </style>
</head>

<style>
    button {
        font-size: 20px;
    }
    input {
        font-size: 20px;
    }
</style>

<body>

<?php
require_once 'main_menu_student.php';
?>

<div class="main">
    <h2>Загрузка файла выполненного задания</h2>
    <form action="vendor/student_upload_file.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_curs" value="<?= $id_curs ?>">
        <input type="hidden" name="id_file" value="<?= $id_file ?>">
        <input type="hidden" name="id_user" value="<?= $id_user ?>">
        <input type="hidden" name="id_user_s" value="<?= $id_user_s ?>">
        <input type="hidden" name="fileindb" value="<?= $fileindb ?>">
        <p>Загрузить файл</p>
        <input type="file" name="file">
        <br>
        <br>
        <button type="submit">Сохранить</button>
    </form>
</div>

</body>
</html>