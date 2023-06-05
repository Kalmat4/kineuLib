
<?php
ini_set('max_execution_time', 1200);
// ...

// Функция для обработки строки (вырезание фамилий и вставка в поле 'author')
function processString($string, $pdo) {
    $pattern = '/(?:Разработчик|Разработчики)\s+(\p{Lu}\p{Ll}+)/u';

    if (preg_match($pattern, $string, $matches)) {
        $author = $matches[1];

        // Обновление поля 'author' в базе данных
        $updateQuery = "UPDATE materials SET author=:author WHERE description=:originalString";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindValue(':author', $author);
        $stmt->bindValue(':originalString', $string);
        $stmt->execute();

        // Вырезание фамилии из описания
        $processedString = preg_replace($pattern, '', $string);

        // Вернуть обработанную строку
        return $processedString;
    }

    return $string;
}

// ...

// Установка соединения с базой данных
try {
    $dsn = "mysql:host=localhost;dbname=kineu__test;charset=cp1251";
    $pdo = new PDO($dsn, 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Выбор таблицы и полей
$tableName = 'materials';
$fieldName = 'description';

// Извлечение всех строк из выбранного поля
$selectQuery = "SELECT $fieldName FROM $tableName";
$result = $pdo->query($selectQuery);

// Проход по каждой строке и обработка
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $originalString = $row[$fieldName];
    $processedString = processString($originalString, $pdo);

    // Обновление каждой обработанной строки в базе данных
    $updateQuery = "UPDATE $tableName SET $fieldName=:processedString WHERE $fieldName=:originalString";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindValue(':processedString', $processedString);
    $stmt->bindValue(':originalString', $originalString);
    $stmt->execute();
}

// Закрытие соединения с базой данных
$pdo = null;

// ...
?>
