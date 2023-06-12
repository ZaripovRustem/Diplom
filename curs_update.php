<?php
//Проверяем вход
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
//Подключаем файл для получения соединения к базе данных
require_once 'vendor/connect.php';
//Получаем ID
$curs_id = $_GET['id'];
//Делаем выборку строки с полученным ID выше
$curs = mysqli_query($connect, "SELECT `curs`.`id` as `id`,
                                             `curs`.`name` as `name`,
                                             `curs`.`date` as `date`,
                                             `curs`.`idfile` as `idfile`,
                                             `file`.`name` as `namefile`,
                                             `file`.`nameindb` as `nameindb` FROM `curs` 
                                      left join `file` on `curs`.`idfile` = `file`.`id`
                                      where `curs`.`id` = '$curs_id'");
//Преобразовывем полученные данные в нормальный массив
$curs = mysqli_fetch_assoc($curs);
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
    <h2>Редактирование обучающего курса</h2>
    <form action="vendor/curs_update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $curs['id'] ?>">
        <input type="hidden" name="nameindb" value="<?= $curs['nameindb'] ?>">
        <input type="hidden" name="idfile" value="<?= $curs['idfile'] ?>">
        <p>Наименование</p>
        <input type="text" name="name" value="<?= $curs['name'] ?>">
        <p>Дата сдачи</p>
        <input type="date" name="date" value="<?= $curs['date'] ?>">
        <p>Загрузить файл задания</p>
        <input type="file" name="file">
        <br>
        <br>
        <button type="submit">Сохранить</button>
    </form>
</div>

</body>
</html>
