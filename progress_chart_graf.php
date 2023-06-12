<?php
//Проверяем вход
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}

//Подключаем файл для получения соединения к базе данных
require_once 'vendor/connect.php';

//Делаем выборку
$curs = mysqli_query($connect, "SELECT `curs`.`name`, SUM(`grade`.`grade`), COUNT(`grade`.`grade`), AVG(`grade`.`grade`), `curs`.`date` 
                                      FROM `curs` left join `grade` on `curs`.`id` = `grade`.`idcurs` 
                                      GROUP BY `curs`.`id`
                                      order by `curs`.`date`
                                      ");

//Преобразовываем полученные данные в нормальный массив
$curs = mysqli_fetch_all($curs);

//Для отладки
//print_r($curs);
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

<style>
    .chart .pipe {
        background: #eee none repeat scroll 0 0;
        box-shadow: 3px 3px 3px 0 rgb(200, 200, 200) inset;
    }
    .chart .pipe {
        margin-left: 200px;
        width: 50%;
        height: 10px;
        border-radius: 5px;
        margin-bottom: 1.2em;
    }
    .chart p {
        margin-left: 200px;
    }
    .chart .pipe > div {
        background: #dc3545 none repeat scroll 0 0;
        border-radius: 5px;
        height: 10px;
    }
    h2{
        margin-left: 200px;
    }
</style>

<?php
    $dx = 800; //ширина
    $dy = 400; //высота
    $arrow = 30; //стрелка
    $indent = 30; //отступ 
    $width = $indent+$dx+$arrow; //ширина общая
    $height = $indent+$dy+$arrow; //высота общая
    $stepY = (int)($dy / 5); // Шаг по Y
    $stepX = (int)(($dx - $indent) / 2); // Шаг по X
    if(count($curs)>1){
        $stepX = (int)(($dx - $indent) / (count($curs)-1)); // Шаг по X
    }
    $im = imagecreatetruecolor($width, $height); //создаем изображение 
    $white = imagecolorallocate($im, 255, 255, 255); //цвет фона
    imagefill($im, 0, 0, $white); //заполним фоном
    $col_line = imagecolorallocate($im, 0, 0, 255); //цвет осей координат
    $col_grafic = imagecolorallocate($im, 255, 0, 0); //цвет графика
    imagesetthickness($im, 5); // толщину линии
    imageline($im, $indent, 0, $indent, $height - $indent, $col_line); // ось У
    imageline($im, $indent, $height - $indent, $width, $height - $indent, $col_line); // ось X
    imageline($im, $indent, 0, $indent - $arrow / 3, $arrow / 3, $col_line); // стрелка
    imageline($im, $indent, 0, $indent + $arrow / 3, $arrow / 3, $col_line); // стрелка
    imageline($im, $width - $arrow / 3, $height - $indent - $arrow / 3, $width, $height - $indent, $col_line); // стрелка
    imageline($im, $width - $arrow / 3, $height - $indent + $arrow / 3, $width, $height - $indent, $col_line); // стрелка

    // Рисуем шкалу по Y
    for($i=1;$i<=5;$i++)
    {
        imagefilledellipse ($im , $indent, $height - $indent - $i*$stepY, 6, 6, $col_line);
        imagestring ($im, 5, 3, $height - $indent - $i*$stepY - 5, $i, $col_line);
    }

    // Рисуем шкалу по X и выводим график
    // Координаты точки
    $x0 = 0;
    $y0 = 0;
    for($i=1;$i<=count($curs);$i++)
    {
        // Координаты точки
        $x1 = (int) (($i-1)*$stepX);
        $y1 = (int) ($height - $indent - $curs[$i - 1][3] *  $stepY);
        // Выводим точки на оси X
        imagefilledellipse ($im, 2 * $indent + $x1, $height - $indent, 7, 7, $col_line);
        // Выводим даты курсов
        $d = (string)($curs[$i - 1][4]);
        $d = substr($d, -5);
        imagestring ($im, 2, $indent + $x1 + 10, $height - $indent +5, $d, $col_line);
        // Выведем точки на графике
        imagefilledellipse ($im, 2 * $indent + $x1, $y1, 10, 10, $col_grafic);
        // Выведем график
        if($i!=1){
            imageline ($im , 2 * $indent + $x0 , $y0 , 2 * $indent + $x1 , $y1 , $col_grafic);
        }
        $x0 = $x1;
        $y0 = $y1;
    }
    imagepng($im, '1.png');
    imagedestroy($im);
?>

<div class="chart">
    <h2>График изменения успеваемости</h2>
    <p><img src="1.png" width="<?= $width ?>" height="<?= $height ?>" alt="ris" ></p>
</div>

</body>
</html>
