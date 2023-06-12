<?php
// Подключакм библиотеку для работы с файлами Excel
require_once '../PHPExcel.php';
//Подключаем файл для получения соединения к базе данных
require_once '../vendor/connect.php';
//Делаем выборку из базы данных таблица curs
$curs = mysqli_query($connect, "SELECT `curs`.`id`,
                                             `curs`.`name`
                                      FROM `curs` 
                                      order by `name`");
//Преобразовываем полученные данные в нормальный массив
$curs = mysqli_fetch_all($curs);
//Делаем выборку из базы данных
$users = mysqli_query($connect, "SELECT `users`.`id`,
                                              `users`.`fio`
                                       FROM `users` 
                                       where `users`.`isadmin` = 0 
                                       order by `users`.`fio`");
//Преобразовываем полученные данные в нормальный массив
$users = mysqli_fetch_all($users);
//Посмотрим количество курсов
$count_curs = count($curs);
//Посмотрим количество студентов
$count_users = count($users);
//Создаем объект Excel
$objExcel = new PHPExcel();
//Выбираем первый лист в документе
$sheet = $objExcel->setActiveSheetIndex(0);
//Пишем заголовок
$sheet->setCellValueByColumnAndRow(1,1,'Общий журнал успеваемости по обучающим курсам.');
//Шрифт заголовка
$sheet->getStyleByColumnAndRow(1,1)->getFont()->setBold(true);
$sheet->getStyleByColumnAndRow(1,1)->getFont()->setSize(18);
//Заголовок по центру
$sheet->getStyleByColumnAndRow(1,1)->getAlignment()->setHorizontal('center');
//Объединим ячейки заголовка
$sheet->mergeCellsByColumnAndRow(1,1, $count_curs + 1, 1);
//Установим ширену первого столбца
$sheet->getColumnDimensionByColumn(1) ->setWidth(60);
//Выведем название первого столбца
$sheet->setCellValueByColumnAndRow(1,3,'ФИО студента');
//Выравнивание первой ячейки
$sheet->getStyleByColumnAndRow(1,3)->getAlignment()->setHorizontal('center');
$sheet->getStyleByColumnAndRow(1,3)->getAlignment()->setVertical('top');
//Шрифт первой ячейки таблицы
$sheet->getStyleByColumnAndRow(1,3)->getFont()->setBold(true);
$sheet->getStyleByColumnAndRow(1,3)->getFont()->setSize(14);
//Перенос по словам первой ячейки таблицы
$sheet->getStyleByColumnAndRow(1,3)->getAlignment()->setWrapText(true);
//Выведем шапку таблицы
for($i = 0; $i < $count_curs; $i++){
    //Ширена столбцов
    $sheet->getColumnDimensionByColumn($i+2) ->setWidth(25);
    //Значение
    $sheet->setCellValueByColumnAndRow($i+2,3, $curs[$i][1]);
    //Выравнивание
    $sheet->getStyleByColumnAndRow($i+2,3)->getAlignment()->setHorizontal('center');
    $sheet->getStyleByColumnAndRow($i+2,3)->getAlignment()->setVertical('top');
    //Шрифт шапки таблицы
    $sheet->getStyleByColumnAndRow($i+2,3)->getFont()->setBold(true);
    $sheet->getStyleByColumnAndRow($i+2,3)->getFont()->setSize(14);
    //Перенос по словам
    $sheet->getStyleByColumnAndRow($i+2,3)->getAlignment()->setWrapText(true);
}
//Выводим таблицу
for($j = 0; $j < $count_users; $j++){
    $sheet->setCellValueByColumnAndRow(1,$j + 4, $users[$j][1]);
    for($i = 0; $i < $count_curs; $i++) {
        // SQL запрос
        $idcurs = $curs[$i][0];
        $iduser = $users[$j][0];
        $grade = mysqli_query($connect, "SELECT `grade`.`grade`
                                               FROM `grade` 
                                               where (`grade`.`idcurs` = $idcurs) and (`grade`.`iduser` = $iduser)");
        //В нормальный массив
        $grade = mysqli_fetch_all($grade);
        //Подготовим выводимое значение
        $pr_grade = '';
        if(count($grade)>0){
            $pr_grade = $grade[0][0];
        }
        //Выводим значение
        $sheet->setCellValueByColumnAndRow($i + 2,$j + 4, $pr_grade);
        //Выравнивание по центру
        $sheet->getStyleByColumnAndRow($i + 2,$j + 4)->getAlignment()->setHorizontal('center');
    }
}
//Установим рамки таблицы
$border = array(
    'borders'=>array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);
$sheet->getStyleByColumnAndRow(1,3,1 + $count_curs, 3 + $count_users)->applyFromArray($border);
//Установим цвет таблицы
$bg = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_PATTERN_MEDIUMGRAY,
        'startcolor' => array('rgb' => '01B050'),
        'endcolor' => array('rgb' => 'f1ee3b'),
    )
);
$sheet->getStyleByColumnAndRow(1,3,1 + $count_curs, 3 + $count_users)->applyFromArray($bg);
//Сохраним файл
$objWriter = PHPExcel_IOFactory::createWriter($objExcel,'Excel5');
$objWriter->save('Report.xls');

//Качаем файл
$path = 'Report.xls';
$filename = 'Report.xls';
header("Content-Length: ".filesize($path));
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Type: application/x-force-download; name=\"".$filename."\"");
readfile($path);

//Переадресация на главную страницу
header('Location: ../report.php');
