<?php
//Проверяем вход
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
//Подключаем файл для получения соединения к базе данных
require_once 'vendor/connect.php';
//Создадим массив
$curs = [
    "name" => "Новый курс обучения",
    "date" => date("Y-m-d"),
];

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
require_once 'main_menu.php';
?>

<div class="main">
    <h2>Создание нового обучающего курса</h2>
    <form action="vendor/curs_new.php" method="post" enctype="multipart/form-data">
        <p>Наименование</p>
        <input type="text" name="name" value="<?= $curs['name'] ?>">
        <p>Дата сдачи</p>
        <input type="date" name="date" value="<?= $curs['date'] ?>">
        <p>Файл задания</p>
        <input type="file" name="file">
        <br>
        <br>
        <button type="submit">Сохранить</button>
    </form>
</div>

</body>
</html>

