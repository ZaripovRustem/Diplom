<?php
    $connect = mysqli_connect('localhost', 'root', 'mysql', 'teststudents');
    if (!$connect) {
        die('Ошибка подключения к базе данных.');
    }
?>