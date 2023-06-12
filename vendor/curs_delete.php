<?php

//Удаление курса
//Подключаем файл для получения соединения к базе данных
require_once '../vendor/connect.php';
//Получаем ID продукта из адресной строки
$id = $_GET['id'];
//Делаем выборку строки с полученным ID
$curs = mysqli_query($connect, "SELECT `curs`.`id` as `id`, `curs`.`name` as `name`, `curs`.`date` as `date`, `curs`.`idfile` as `idfile`, `file`.`name` as `namefile`, `file`.`nameindb` as `nameindb` FROM `curs` left join `file` on `curs`.`idfile` = `file`.`id` where `curs`.`id` = '$id'");
//Преобразовывем полученные данные в нормальный массив
$curs = mysqli_fetch_assoc($curs);

//Делаем запрос на удаление строки из таблицы products
mysqli_query($connect, "DELETE FROM `curs` WHERE `curs`.`id` = '$id'");
//Удалим загруженный файл, если он есть, и вбазе и в каталоге update


if($curs["namefile"] != "") {
    $idfile = $curs["idfile"];
    $nameindb = $curs["nameindb"];
    mysqli_query($connect, "DELETE FROM `file` WHERE `file`.`id` = '$idfile'");
    unlink('../' . $nameindb);
}

//Переадресация на главную страницу
header('Location: ../profileadmincurs.php');

