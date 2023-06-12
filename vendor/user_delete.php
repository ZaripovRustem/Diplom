<?php

//Удаление пользователя
//Подключаем файл для получения соединения к базе данных
require_once '../vendor/connect.php';
//Получаем ID продукта из адресной строки
$id = $_GET['id'];

//Делаем запрос на удаление строки из таблицы products
mysqli_query($connect, "DELETE FROM `users` WHERE `users`.`id` = '$id'");

//Переадресация на главную страницу
header('Location: ../profileadmin.php');
