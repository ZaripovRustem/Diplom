<?php
//Проверяем вход
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
//Подключаем файл для получения соединения к базе данных
require_once 'vendor/connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Преподаватель</title>
    <link rel="stylesheet" href="assets/css/work.css">
    <style>
        body {
            font-family: "Lato", sans-serif;
        }
    </style>
</head>

<link rel="stylesheet" href="assets/css/table.css">

<body>

<?php
require_once 'main_menu.php';
?>

<div class="main">
    <h2>Отчеты</h2>
    <p>  </p>
    <form action="progress_chart.php" method="post">
        <button type="submit">Диаграмма успеваемости по курсам</button>
    </form>
    <p>  </p>
    <form action="progress_chart_graf.php" method="post">
        <button type="submit">График успеваемости по курсам</button>
    </form>
    <p>  </p>
    <form action="vendor/jurnal_chart.php" method="post">
        <button type="submit">Журнал успеваемости (Excel) </button>
    </form>
</div>
</body>
</html>
