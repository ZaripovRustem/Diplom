<?php
//Добавление курса
//Подключаем файл для получения соединения к базе данных
require_once '../vendor/connect.php';
//Создаем переменные со значениями, которые были получены с $_POST
$name = $_POST['name'];
$date = $_POST['date'];

if($_FILES['file']['name'] == ""){
    // Файл не выбрали
    // Обновим таблицу, загруженный файл не трогаем, оставим как было
    mysqli_query($connect,"INSERT INTO `curs` (`id`, `name`, `date`, `idfile`) VALUES (NULL, '$name', '$date', NULL)");
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
        mysqli_query($connect,"INSERT INTO `curs` (`id`, `name`, `date`, `idfile`) VALUES (NULL, '$name', '$date', $lastId)");
    } else {
        //Загрузить не смогли
        //Тут можно вставить реакцию на ошибку загрузки файла
    }
}
//Переадресация на главную страницу
header('Location: ../profileadmincurs.php');
