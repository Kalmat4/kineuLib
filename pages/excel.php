<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Подключение к базе данных MySQL
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'kineu__test';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if( !$conn ){	
    echo 'Ошибка: <br/>';
    echo mysqli_connect_error();
    exit();
}

// Создание нового Excel документа
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Выполнение запроса к базе данных

session_start();

$sql = $_SESSION['sqlReport'];
$result = mysqli_query($conn, $sql);

// Запись данных в Excel

$row = 1;
while ($queryContent = mysqli_fetch_assoc($result)){  
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

                //Заголовки
                $sheet->setCellValue("A1", "ID");
                $sheet->setCellValue("B1", "Дата добавления");
                $sheet->setCellValue("C1", "Название книги");
                $sheet->setCellValue("D1", "Год публикации");
                $sheet->setCellValue("E1", "Количество страниц");
                $sheet->setCellValue("F1", "Автор");
                $sheet->setCellValue("G1", "Соавтор");
                $sheet->setCellValue("H1", "Издательство");
                $sheet->setCellValue("I1", "Вид издания");
                $sheet->setCellValue("J1", "Аннотация");
                $sheet->setCellValue("K1", "Ключевые слова");
                $sheet->setCellValue("L1", "Формат файла");
                $sheet->setCellValue("M1", "Размер файла");
                $sheet->setCellValue("N1", "ISBN");
                $sheet->setCellValue("O1", "BBK");
                $sheet->setCellValue("P1", "UDK");
                $sheet->setCellValue("Q1", "Рубрика");
                $sheet->setCellValue("R1", "Факультет");
                $sheet->setCellValue("S1", "Кафедра");
                $sheet->setCellValue("T1", "Специальность");
                $sheet->setCellValue("U1", "Ссылка на скачивание");
                $sheet->setCellValue("V1", "Количество скачиваний");

                //Стандартные размеры
                $sheet->getColumnDimension("V")->setWidth(22);
                $sheet->getColumnDimension("U")->setWidth(21);
                $sheet->getColumnDimension("R")->setWidth(15);
                $sheet->getColumnDimension("T")->setWidth(15);
                $sheet->getColumnDimension("M")->setWidth(14);
                $sheet->getColumnDimension("L")->setWidth(14);
                $sheet->getColumnDimension("K")->setWidth(17);
                $sheet->getColumnDimension("J")->setWidth(100);
                $sheet->getColumnDimension("I")->setWidth(13);
                $sheet->getColumnDimension("H")->setWidth(14);
                $sheet->getColumnDimension("E")->setWidth(19);
                $sheet->getColumnDimension("D")->setWidth(16);
                $sheet->getColumnDimension("B")->setWidth(16);
                $sheet->getColumnDimension("C")->setWidth(50);

                //Жирный шрифт для заголовков
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("B1")->getFont()->setBold(true);
                $sheet->getStyle("C1")->getFont()->setBold(true);
                $sheet->getStyle("D1")->getFont()->setBold(true);
                $sheet->getStyle("E1")->getFont()->setBold(true);
                $sheet->getStyle("F1")->getFont()->setBold(true);
                $sheet->getStyle("G1")->getFont()->setBold(true);
                $sheet->getStyle("H1")->getFont()->setBold(true);
                $sheet->getStyle("I1")->getFont()->setBold(true);
                $sheet->getStyle("J1")->getFont()->setBold(true);
                $sheet->getStyle("K1")->getFont()->setBold(true);
                $sheet->getStyle("L1")->getFont()->setBold(true);
                $sheet->getStyle("M1")->getFont()->setBold(true);
                $sheet->getStyle("N1")->getFont()->setBold(true);
                $sheet->getStyle("O1")->getFont()->setBold(true);
                $sheet->getStyle("P1")->getFont()->setBold(true);
                $sheet->getStyle("Q1")->getFont()->setBold(true);
                $sheet->getStyle("R1")->getFont()->setBold(true);
                $sheet->getStyle("S1")->getFont()->setBold(true);
                $sheet->getStyle("T1")->getFont()->setBold(true);
                $sheet->getStyle("U1")->getFont()->setBold(true);
                $sheet->getStyle("V1")->getFont()->setBold(true);

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
                $sheet->setCellValue($M, $queryContent['size']);
                $sheet->setCellValue($N, $queryContent['isbn']);
                $sheet->setCellValue($O, $queryContent['bbk']);
                $sheet->setCellValue($P, $queryContent['udk']);
                $sheet->setCellValue($Q, $queryContent['rubric_id']);
                $sheet->setCellValue($A, $queryContent['id']);
                $sheet->setCellValue($R, $queryContent['faculty_id']);
                $sheet->setCellValue($S, $queryContent['department_id']);
                $sheet->setCellValue($T, $queryContent['spec_id']);
                $sheet->setCellValue($U, $queryContent['link']);
                $sheet->setCellValue($V, $queryContent['downloads']);
                $sheet->setCellValue($L, $queryContent['format']);
                
}

function RusEnding($n, $n1, $n2, $n5) {
    if($n >= 11 and $n <= 19) return $n5;
    $n = $n % 10;
    if($n == 1) return $n1;
    if($n >= 2 and $n <= 4) return $n2;
    return $n5;
  }

// Сохранение Excel файла
$writer = new Xlsx($spreadsheet);

$filename = date('Y-m-d') . ' Отчёт - ' . mysqli_num_rows($result) . RusEnding(mysqli_num_rows($result), " строка", " строки", " строк") . ".xlsx";

$writer->save($filename);


// Отправка файла пользователю для сохранения
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

readfile($filename);
unlink($filename); // Удаление временного файла

exit;
?>
