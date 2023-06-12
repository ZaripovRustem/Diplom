<?php
    //Проверяем вход
    session_start();
    if (!$_SESSION['user']) {
        header('Location: /');
    }
    //Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
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
    <h2>Пользователи</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Логин</th>
            <th>Администратор</th>
        </tr>

        <?php

        // Делаем выборку всех строк из таблицы "users"
        $users = mysqli_query($connect, "SELECT * FROM `users`");

        //Преобразовываем полученные данные в нормальный массив
        $users = mysqli_fetch_all($users);

        //Перебираем массив и рендерим HTML с данными из массива
        //Ключ 0 - id
        //Ключ 1 - fio
        //Ключ 2 - login
        //Ключ 3 - password
        //Ключ 4 - isadmin
        //print_r($users );

        foreach ($users as $user) {
            $isadmin = "";
            if($user[4]==1){
                $isadmin = "V";
            }
            ?>
            <tr>
                <td><?= $user[0] ?></td>
                <td><?= $user[1] ?></td>
                <td><?= $user[2] ?></td>
                <td><?= $isadmin ?></td>
                <td><a href="user_update.php?id=<?= $user[0] ?>">Изменить</a></td>
                <td><a style="color: red;" href="vendor/user_delete.php?id=<?= $user[0] ?>">Удалить</a></td>
                <td><a href="user_chat.php?id=<?= $user[0] ?>">Чат</a></td>
            </tr>
            <?php
        }
        ?>
    </table>

    <p>  </p>
    <form action="user_new.php" method="post">
        <button type="submit">Добавить нового пользователя</button>
    </form>

</div>

</body>
</html>


