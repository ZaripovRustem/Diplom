<?php
//Проверяем вход
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}

//Подключаем файл для получения соединения к базе данных
require_once 'vendor/connect.php';

//Делаем выборку
$curs = mysqli_query($connect, "SELECT `curs`.`name`, SUM(`grade`.`grade`), COUNT(`grade`.`grade`), AVG(`grade`.`grade`) 
                                      FROM `curs` left join `grade` on `curs`.`id` = `grade`.`idcurs` 
                                      GROUP BY `curs`.`id`
                                      order by `curs`.`name`
                                      ");

//Преобразовываем полученные данные в нормальный массив
$curs = mysqli_fetch_all($curs);

//Для отладки
//print_r($curs);
//?>

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

<link rel="stylesheet" href="assets/css/table.css">

<body>

<?php
require_once 'main_menu.php';
?>

<style>
    .chart .pipe {
        background: #eee none repeat scroll 0 0;
        box-shadow: 3px 3px 3px 0 rgb(200, 200, 200) inset;
    }
    .chart .pipe {
        margin-left: 200px;
        width: 50%;
        height: 10px;
        border-radius: 5px;
        margin-bottom: 1.2em;
    }
    .chart p {
        margin-left: 200px;
    }
    .chart .pipe > div {
        background: #dc3545 none repeat scroll 0 0;
        border-radius: 5px;
        height: 10px;
    }
    h2{
        margin-left: 200px;
    }
</style>

<div class="chart">
    <h2>Диаграмма успеваемости по обучающим курсам (средний балл)</h2>
    <br>
    <?php
    foreach ($curs as $cur) {
        $procent = ($cur[3] * 100) / 5;
        $procent_str = number_format( $cur[3], 1);
    ?>
        <p>
            <?= $cur[0] . '. Средняя оценка - ' . $procent_str ?>
        </p>

            <div class="pipe">
            <div style="width: <?= $procent ?>%"> </div>
        </div>
        <br>
    <?php
    }
    ?>
</div>

</body>
</html>

