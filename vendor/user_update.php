<?php
//Обновление информации о пользователях

//Подключаем файл для получения соединения к базе данных
require_once '../vendor/connect.php';
//Создаем переменные со значениями, которые были получены с $_POST
$id = $_POST['id'];
$fio = $_POST['fio'];
$login = $_POST['login'];
$password = md5($_POST['password']);
$isadmin = 0;
if(isset($_POST['isadmin']))
{
    $isadmin = 1;
}

//Это для отладки
//print_r($_POST);
//print_r($password);

//Делаем запрос на изменение строки в таблице products
mysqli_query($connect, "UPDATE `users` SET `fio` = '$fio', `login` = '$login', `password` = '$password', `isadmin` = '$isadmin' 
                              WHERE `users`.`id` = '$id'");

//Переадресация на главную страницу
header('Location: ../profileadmin.php');
