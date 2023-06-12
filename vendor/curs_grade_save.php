<?php
//Сохранение оценок
//Подключаем файл для получения соединения к базе данных
require_once '../vendor/connect.php';
//print_r($_POST);

//Получаем ID
$curs_id = $_POST['idcurs'];
//Делаем выборку строки с полученным ID выше
$grades = mysqli_query($connect, "SELECT * FROM `users`
                                        left join `grade` on `users`.`id` = `grade`.`iduser` and `grade`.`idcurs` = '$curs_id'
                                        left join `file` on `grade`.`idfile` = `file`.`id`
                                        where `users`.`isadmin` = 0
                                        order by `users`.`fio`");
//Преобразовывем полученные данные в нормальный массив
$grades = mysqli_fetch_all($grades);

//Пройдемся по массиву
foreach ($grades as $grade) {
    $ocenca = $_POST[$grade[0]];
    if($grade[6] == ""){
        // В sql таблице grade нет записи по этому пользователю, вставим ее.
        //Делаем запрос на добавление
        mysqli_query($connect,"INSERT INTO `grade` (`idcurs`, `iduser`, `grade`, `idfile`, `date`)
                                     VALUES ('$curs_id', '$grade[0]', '$ocenca', NULL, NULL)");
    }else{
        // В sql таблице grade есть записи по этому пользователю, обновим ее.
        //Делаем запрос на добавление
        mysqli_query($connect, "UPDATE `grade` SET `grade`.`grade` = '$ocenca'
                                      WHERE `grade`.`idcurs` = '$curs_id' and `grade`.`iduser` = '$grade[0]' ");
    }
}
//Переадресация на главную страницу
header('Location: ../profileadmincurs.php');

