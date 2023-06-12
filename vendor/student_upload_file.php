<?php
//Загрузка файла выполнения задания
//Подключаем файл для получения соединения к базе данных
require_once '../vendor/connect.php';

//Создаем переменные со значениями, которые были получены с $_POST
$id_curs = $_POST['id_curs'];
$id_file = $_POST['id_file'];
$id_user = $_POST['id_user'];
$id_user_s = $_POST['id_user_s'];
$fileindb = $_POST['fileindb'];

//Получим текущую дату
$tdate = date("Y-m-d");

if($_FILES['file']['name'] == ""){
    // Файл не выбрали, ничего не делаем
}else {
    // Файл выбрали
    // Назначим уникальное имя
    $path = 'upload/' . date("YmdHis") . $_FILES['file']['name'];
    $namefile = $_FILES['file']['name'];
    // Загрузим файл из tmp в upload
    if (move_uploaded_file($_FILES['file']['tmp_name'], '../' . $path)) {
        // Запишем информацию о файлк в таблицу БД file
        mysqli_query($connect, "INSERT INTO `file` (`id`, `name`, `nameindb`) VALUES (NULL, '$namefile', '$path')");
        // Получим id последнего добавления
        $lastId = mysqli_insert_id($connect);
        // Обновим таблицу
        if(trim($id_user) == ""){
            //Записи нет добавим
            mysqli_query($connect, "INSERT INTO `grade` (`idcurs`, `iduser`, `idfile`, `date`)
                                          VALUES ('$id_curs', '$id_user_s', '$lastId', '$tdate' )");
        }else{
            //Запись уже есть, обновим
            mysqli_query($connect, "UPDATE `grade` SET `idfile` = '$lastId',
                                                             `date` = '$tdate'
                                          WHERE (`idcurs` = '$id_curs') and (`iduser` = '$id_user_s') ");
        }
        // Если до этого был загружен файл, то удалим его из БД и из upload
        if(trim($id_file) != ""){
            mysqli_query($connect, "DELETE FROM `file` WHERE `file`.`id` = '$id_file'");
            unlink('../' . $fileindb);
        }
    } else {
        //Загрузить не смогли
        //Тут можно вставить реакцию на ошибку загрузки файла
    }
}
//Переадресация на главную страницу
header('Location: ../profilestudent.php');

