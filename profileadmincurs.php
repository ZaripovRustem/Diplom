<?php
//Проверяем вход
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
//Подключаем файл для получения соединения к базе данных
require_once 'vendor/connect.php';
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
    <h2>Обучающие курсы</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Наименование курса</th>
            <th>Срок сдачи</th>
            <th>Файл с заданием</th>
        </tr>

        <?php
        $curs = mysqli_query($connect, "SELECT * FROM `curs` left join `file` on `curs`.`idfile` = `file`.`id`");
        //Преобразовываем полученные данные в нормальный массив
        $curs = mysqli_fetch_all($curs);

        //Перебираем массив и рендерим HTML с данными из массива
        foreach ($curs as $cur) {
            ?>
            <tr>
                <td><?= $cur[0] ?></td>
                <td><?= $cur[1] ?></td>
                <td><?= $cur[2] ?></td>
                <td><?= $cur[5] ?></td>
                <td><a href="curs_update.php?id=<?= $cur[0] ?>">Изменить</a></td>
                <td><a style="color: red;" href="vendor/curs_delete.php?id=<?= $cur[0] ?>">Удалить</a></td>
                <td><a href="curs_grade.php?id=<?= $cur[0] ?>">Результаты по курсу</a></td>
            </tr>
            <?php
        }
        ?>
    </table>

    <p>  </p>
    <form action="curs_new.php" method="post">
        <button type="submit">Добавить новый курс</button>
    </form>

</div>

</body>
</html>


