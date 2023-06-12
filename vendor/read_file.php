<?php
//Чтение файла
//Подключаем файл для получения соединения к базе данных
require_once '../vendor/connect.php';
//Получаем ID файла
$idfile = $_GET['idfile'];
//print_r($_GET);
//Делаем выборку строки с полученным ID выше
if($idfile != ""){
    $read_file = mysqli_query($connect, "SELECT * FROM `file` WHERE `file`.`id` = '$idfile'");
    //Преобразовываем полученные данные в нормальный массив
    $read_file = mysqli_fetch_all($read_file);
    $path = '../' . $read_file[0][2];
    $filename = $read_file[0][1];
    //Качаем файл
    header("Content-Length: ".filesize($path));
    header("Content-Disposition: attachment; filename=".$filename);
    header("Content-Type: application/x-force-download; name=\"".$filename."\"");
    readfile($path);
}
//Переадресация на главную страницу
//header('Location: ../curs_grade.php?id='. $_GET['id']);

