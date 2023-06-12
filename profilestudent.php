<?php
//Проверяем вход
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
//Подключаем файл для получения соединения к базе данных
require_once 'vendor/connect.php';
//Пользователь
$id_user = $_SESSION['user']["id"];
$fio = $_SESSION['user']["fio"];

//Делаем выборку строки с полученным ID выше
$curs = mysqli_query($connect, "SELECT * FROM `curs`
                                        left join `file` as `f1` on (`f1`.`id` = `curs`.`idfile`)
                                        left join `grade` on ((`grade`.`idcurs` = `curs`.`id`) and (`grade`.`iduser` = '$id_user'))
                                        left join `file` as `f2` on (`f2`.`id` = `grade`.`idfile`)
                                        ");
//Преобразовываем полученные данные в нормальный массив
$curs = mysqli_fetch_all($curs);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Студент</title>
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
require_once 'main_menu_student.php';
?>

<div class="main">
    <h2>Обучающие курсы</h2>
    <h2>Студент: <?= $fio ?></h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Наименование курса</th>
            <th>Срок сдачи</th>
            <th colspan="2">Файл с заданием</th>
            <th colspan="2">Файл с выполненным заданием</th>
            <th>Оценка</th>
        </tr>

        <?php
        //Перебираем массив и рендерим HTML с данными из массива
        foreach ($curs as $cur) {
        ?>
            <tr>
                <td><?= $cur[0] ?></td>
                <td><?= $cur[1] ?></td>
                <td><?= $cur[2] ?></td>
                <td><?= $cur[5] ?></td>
                <td><a href="vendor/student_read_file.php?idfile=<?= $cur[3] ?>">Скачать</a></td>
                <td><?= $cur[13] ?></td>
                <td><a href="student_upload_file.php?idcurs=<?=$cur[0] ?> & idfile=<?= $cur[10] ?> & iduser=<?= $cur[8] ?> & fileindb=<?= $cur[14] ?>">Загрузить</a></td>
                <td><?= $cur[9] ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>

</body>
</html>
