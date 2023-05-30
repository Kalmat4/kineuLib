<?php

require "pagesHead.php";

?>

<div class="template">

<?php
require "header.php";

?>

<div class="content">

    <span class="title">
        Панель администратора
    </span>
    <p class="simpleText">
        Это панель администратора библиотеки Костанайского Инженерно-Экономического Университета им. М.Дулатова. Здесь вы можете редактировать данные в базе данных книг бибилиотеки.
    </p>
    <div class="btns">
        <div class="adminBtn editBtn">
            <p>Изменить информацию о книге</p>
            <a href="adminEdit.php"><img src="../images/edit.png" alt=""></a>
        </div>
        <div class="adminBtn addBtn">
            <p>Добавить новую книгу</p>
            <a href=""><img src="../images/add.png" alt=""></a>
        </div>
        <div class="adminBtn delBtn">
            <p>Удалить книгу</p>
            <a href=""><img src="../images/del.png" alt=""></a>
        </div>
    </div>

</div>
<?php

require "footer.php";

?>