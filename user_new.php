<?php
//Проверяем вход
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
//Подключаем файл для получения соединения к базе данных
require_once 'vendor/connect.php';
//Создадим массив
$user = [
    "fio" => "",
    "login" => "",
    "password" => "",
    "isadmin" => 0
]
;?>

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
    <h2>Создание нового пользователя</h2>
    <form action="vendor/user_new.php" method="post">
        <p>ФИО</p>
        <input type="text" name="fio" value="<?= $user['fio'] ?>">
        <p>Логин</p>
        <input type="text" name="login" value="<?= $user['login'] ?>">
        <p>Пароль</p>
        <input type="password" name="password" value="<?= $user['password'] ?>">
        <p>Это администратор</p>
        <?php if ($user['isadmin']==1):?>
            <input id="isadmin" class="switch" name="isadmin" type="checkbox" value=1 checked />
        <?php endif; ?>
        <?php if ($user['isadmin']==0):?>
            <input id="isadmin" class="switch" name="isadmin" type="checkbox" value=1/>
        <?php endif; ?>
        <br>
        <br>
        <button type="submit">Сохранить</button>
    </form>
</div>

</body>
</html>
