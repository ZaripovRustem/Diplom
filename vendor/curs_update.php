<?php
//Обновление информации о курсе

//Подключаем файл для получения соединения к базе данных
require_once '../vendor/connect.php';
//Создаем переменные со значениями, которые были получены с $_POST
$id = $_POST['id'];
$name = $_POST['name'];
$date = $_POST['date'];
$nameindb = $_POST['nameindb'];
$idfileold = $_POST['idfile'];

if($_FILES['file']['name'] == ""){
    // Файл не выбрали
    // Обновим таблицу, загруженный файл не трогаем, оставим как было
    mysqli_query($connect, "UPDATE `curs` SET `name` = '$name', `date` = '$date' WHERE `curs`.`id` = '$id'");
}else {
    // Файл выбрали
    $path = 'upload/' . date("YmdHis") . $_FILES['file']['name'];
    $namefile = $_FILES['file']['name'];
    // Загрузим файл из tmp в upload
    if (move_uploaded_file($_FILES['file']['tmp_name'], '../' . $path)) {
        // Запишем информацию о файлк в таблицу БД file
        mysqli_query($connect, "INSERT INTO `file` (`id`, `name`, `nameindb`) VALUES (NULL, '$namefile', '$path')");
        // Получим id последнего добавления
        $lastId = mysqli_insert_id($connect);
        // Обновим таблицу
        mysqli_query($connect, "UPDATE `curs` SET `name` = '$name', `date` = '$date', `idfile` = '$lastId' WHERE `curs`.`id` = '$id'");
        // Если до этого был загружен файл, то удалим его из БД и из upload
        if($nameindb != ""){
            mysqli_query($connect, "DELETE FROM `file` WHERE `file`.`id` = '$idfileold'");
            unlink('../' . $nameindb);
        }
    } else {
        //Загрузить не смогли
        //Тут можно вставить реакцию на ошибку загрузки файла
    }
}
//Переадресация на главную страницу
header('Location: ../profileadmincurs.php');
