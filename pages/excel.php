<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Подключение к базе данных MySQL
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'kineu__test';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Ошибка подключения к базе данных: ' . $conn->connect_error);
}

// Создание нового Excel документа
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Выполнение запроса к базе данных
$sql = 'SELECT * FROM `materials`';
$result = $conn->query($sql);

// Запись данных в Excel

$row = 1;
while ($queryContent = $result->fetch_assoc()){  
    $row++;

                    $A = 'A' . $row;
                    $B = 'B' . $row;
                    $C = 'C' . $row;
                    $D = 'D' . $row;
                    $E = 'E' . $row;
                    $F = 'F' . $row;
                    $G = 'G' . $row;
                    $H = 'H' . $row;
                    $I = 'I' . $row;
                    $J = 'J' . $row;
                    $K = 'K' . $row;
                    $L = 'L' . $row;
                    $M = 'M' . $row;
                    $N = 'N' . $row;
                    $O = 'O' . $row;
                    $P = 'P' . $row;
                    $Q = 'Q' . $row;
                    $R = 'R' . $row;
                    $S = 'S' . $row;
                    $T = 'T' . $row;
                    $U = 'U' . $row;
                    $V = 'V' . $row;

                    $sheet->setCellValue($A, $queryContent['id']);
                    $sheet->setCellValue($B, $queryContent['date']);
                    $sheet->setCellValue($C, $queryContent['book__name']);
                    $sheet->setCellValue($D, $queryContent['pub_year']);
                    $sheet->setCellValue($E, $queryContent['pages_count']);
                    $sheet->setCellValue($F, $queryContent['author']);
                    $sheet->setCellValue($G, $queryContent['co_author']);
                    $sheet->setCellValue($H, $queryContent['izd']);
                    $sheet->setCellValue($I, $queryContent['vid_izd_id']);
                    $sheet->setCellValue($J, $queryContent['description']);
                    $sheet->setCellValue($K, $queryContent['keyWords']);
                    $sheet->setCellValue($L, $queryContent['format']);
                    $sheet->setCellValue($M, $queryContent['size']);
                    $sheet->setCellValue($N, $queryContent['isbn']);
                    $sheet->setCellValue($O, $queryContent['bbk']);
                    $sheet->setCellValue($P, $queryContent['udk']);
                    $sheet->setCellValue($Q, $queryContent['rubric_id']);
                    $sheet->setCellValue($R, $queryContent['faculty_id']);
                    $sheet->setCellValue($S, $queryContent['department_id']);
                    $sheet->setCellValue($T, $queryContent['spec_id']);
                    $sheet->setCellValue($U, $queryContent['link']);
                    $sheet->setCellValue($V, $queryContent['downloads']);
              
}

// Сохранение Excel файла
$writer = new Xlsx($spreadsheet);
$filename = 'данные.xlsx';
$writer->save($filename);

// Закрытие соединения с базой данных
$conn->close();

// Отправка файла пользователю для сохранения
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

readfile($filename);
unlink($filename); // Удаление временного файла

exit;
?>
