<?php
    session_start();
    if(array_key_exists('user', $_SESSION)){
        if ($_SESSION['user']['isadmin']) {
            header('Location: profileadmincurs.php');
        } else {
            header('Location: profilestudent.php');
        }
    }
?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Авторизация</title>
        <link rel="stylesheet" href="assets/css/main.css">
    </head>

    <body>
        <form action="vendor/signin.php" method="post">
            <label>Логин</label>
            <input type="text" name="login" placeholder="Введите свой логин">
            <label>Пароль</label>
            <input type="password" name="password" placeholder="Введите пароль">
            <button type="submit">Войти</button>
            <?php
                if(array_key_exists('message', $_SESSION)) {
                    if ($_SESSION['message']) {
                        echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
                        unset($_SESSION['message']);
                    }
                }
            ?>
        </form>
    </body>
</html>

