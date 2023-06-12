<?php
//Проверяем вход
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
//Подключаем файл для получения соединения к базе данных
require_once 'vendor/connect.php';
//Получаем ID
$user_id = $_GET['id'];
//Делаем выборку строки с полученным ID выше
$user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id'");
//Преобразовывем полученные данные в нормальный массив
$user = mysqli_fetch_assoc($user);
//Загрузим чат
$chats = mysqli_query($connect, "SELECT * FROM `chat` WHERE `iduser` = '$user_id' order by `date`" );
//Преобразовываем полученные данные в нормальный массив
$chats = mysqli_fetch_all($chats);
//Заполним чат
$text = "";
foreach ($chats as $chat) {
    if($chat[1]){
        $text = "Преподаватель ".$chat[2]."\n".$chat[3]."\n\n".$text;
    }else{
        $text = $user['fio']." ".$chat[2]."\n".$chat[3]."\n\n".$text;
    }
}
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
    <h2><?= "Общение с пользователем - " .$user['fio'] ?></h2>
    <form action="vendor/user_chat.php" method="post">
        <input type="hidden" name="id_user" value="<?= $user_id ?>">
        <p><textarea name="comment" cols=80 rows=15 readonly><?= $text ?></textarea></p>
        <p>Ответ:</p>
        <p><textarea name="answer" cols=80 rows=2></textarea></p>
        <button type="submit">Отправить</button>
    </form>
</div>

</body>
</html>