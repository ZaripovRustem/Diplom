<?php
//Новый пользователь

//Подключаем файл для получения соединения к базе данных
require_once '../vendor/connect.php';
//Создаем переменные со значениями, которые были получены с $_POST
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

//Делаем запрос на добавление
mysqli_query($connect,"INSERT INTO `users` (`id`, `fio`, `login`, `password`, `isadmin`) VALUES (NULL, '$fio', '$login', '$password', '$isadmin')");

//Переадресация на главную страницу
header('Location: ../profileadmin.php');

