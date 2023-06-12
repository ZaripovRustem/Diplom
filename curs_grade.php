<?php
//Проверяем вход
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
//Подключаем файл для получения соединения к базе данных
require_once 'vendor/connect.php';
//Получаем ID
$id = $_GET['id'];
//Делаем выборку строки с полученным ID выше

//Делаем выборку строки с полученным ID выше
$curs = mysqli_query($connect, "SELECT * FROM `curs` WHERE `curs`.`id` = '$id'");
//Преобразовываем полученные данные в нормальный массив
$curs = mysqli_fetch_all($curs);

//Делаем выборку строки с полученным ID выше
$grades = mysqli_query($connect, "SELECT * FROM `users` 
                                        left join `grade` on `users`.`id` = `grade`.`iduser` and `grade`.`idcurs` = '$id' 
                                        left join `file` on `grade`.`idfile` = `file`.`id` 
                                        where `users`.`isadmin` = 0 
                                        order by `users`.`fio`");

//Преобразовывем полученные данные в нормальный массив
$grades = mysqli_fetch_all($grades);

//print_r($grades);
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

<link rel="stylesheet" href="assets/css/table.css">

<body>

<?php
require_once 'main_menu.php';
?>

<div class="main">
    <form action="vendor/curs_grade_save.php" method="post">
        <h2><?=$curs[0][1]?></h2>
        <input type="hidden" name="idcurs" value="<?= $curs[0][0] ?>">
        <table>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Дата выполнения</th>
                <th colspan="2">Файл с выполненым заданием</th>
                <th>Оценка</th>
            </tr>

            <?php
            $i = 0;
            foreach ($grades as $grade) {
                ?>
                <tr>
                    <td><?= $grade[0] ?></td>
                    <td><?= $grade[1] ?></td>
                    <td><?= $grade[9] ?></td>
                    <td><?= $grade[11] ?></td>
                    <td><a href="vendor/read_file.php?id=<?= $id ?> & idfile=<?= $grade[8] ?>">Загрузить</a></td>
                    <td>
                        <input type="number" step="1" min="1" max="5" name="<?= $grade[0] ?>" / value="<?= $grade[7] ?>">
                    </td>
                </tr>
                <?php
                $i = $i + 1;
            }
            ?>
        </table>
        <p>  </p>
        <button type="submit">Сохранить</button>
    </form>
</div>

</body>
</html>

