<?php
//Подключаем файл для получения соединения к базе данных
require_once '../vendor/connect.php';
//Создаем переменные со значениями, которые были получены с $_POST
$id_user = $_POST['id_user'];
$answer = $_POST['answer'];
$isadmin = 0;
$tdate =  date("Y-m-d H:i:s");


//Делаем запрос на добавление строки
if(str_replace(" ", "", $answer) != ""){
    mysqli_query($connect, "INSERT INTO `chat` ( `iduser`, `isadmin`, `date`, `message`)
                        VALUES ('$id_user', '$isadmin', '$tdate', '$answer')");
}

//Переадресация на  страницу
header('Location: ../prepod_chat.php');