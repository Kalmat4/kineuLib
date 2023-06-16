<?php

require "pagesHead.php";

?>

<div class="template">

<?php
require "header.php";

?>

<div class="content">

<h1 align="center">Статистика размещения материала библиотеки</h1>
<div class="simpleText">Выберите вариант сортировки, посмотрите на результат и скачайте в формате .xlsx (Excel документ)</div>


<?php
$postArray = [
    'pub_year',
    'date',
    'author',
    'faculty',
    'spec',
    'edition',
    'department'
];

$selectedPost = '';

for ($i=0;$i<=count($postArray);$i++){
    if (strlen($_POST[$postArray[$i]]) > 0){
        $selectedPost = $postArray[$i];
        $request = 'SELECT `' . $selectedPost . '` FROM `materials`'; 
        echo '<h1 class="statsTitle">' .  $_POST[$selectedPost] . '</h1>';
        
        require 'connect.php';
        $link = $_SESSION['db'];
        $sql = mysqli_query($link, $request);

        $content = mysqli_fetch_assoc($sql);
        echo "------- " . $content[$selectedPost] . " -------------";

        ?>

        
    <?php }else if ($i == count($postArray) && strlen($selectedPost) == 0){?>
        <form class="stats" method="POST">
            <input class="select pub_year" type="submit" method="POST" name="pub_year" value="Год публикации"/>
            <input class="select date" type="submit" method="POST" name="date" value="Дата загрузки"/>
            <input class="select author" type="submit" method="POST" name="author" value="Автор"/>
            <input class="select faculty" type="submit" method="POST" name="faculty" value="Факультет"/>
            <input class="select spec" type="submit" method="POST" name="spec" value="Кафедра"/>
            <input class="select edition" type="submit" method="POST" name="edition" value="Образовательная программа"/>
            <input class="select department" type="submit" method="POST" name="department" value="Кафедра"/>
        </form>
    <?php    
    }
}
?>
</div>
<?php

require "footer.php";

?>



