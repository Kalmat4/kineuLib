<?php

require "pagesHead.php";

?>

<div class="template">

<?php
require "header.php";

?>

<div class="content">


<a href="adminForm.php" class="backBtn">Вернуться</a>

<h1 align="center">Статистика размещения материала библиотеки</h1>
<div class="simpleText">Выберите вариант сортировки, посмотрите на результат и скачайте в формате .xlsx (Excel документ)</div>
<?php 


?>
<form class="controls" method="POST">
    <div class="dateAdd">
        <label for="">Дата добавления</label>
        <span>от:</span><input type="date" class="halfInput" name="addStartDate" value='<?php if (isset($_POST['addStartDate'])){ echo $_POST['addStartDate'];}?>'><span>до:</span><input class="halfInput"  value='<?php if (isset($_POST['addEndDate'])){ echo $_POST['addEndDate'];}?>' type="date" name="addEndDate">
    </div>
    <div class="dateIzd">
        <label for="">Дата издания</label>
        <span>от:</span><input type="number" class="halfInput" value='<?php if (isset($_POST['izdStartDate'])){ echo $_POST['izdStartDate'];}?>' name="izdStartDate" min="0" max="2050"><span>до:</span><input class="halfInput" value='<?php if (isset($_POST['izdEndDate'])){ echo $_POST['izdEndDate'];}?>' min="0" max="2050" type="number" name="izdEndDate">
    </div>
    <div class="facultyField">
        <label for="faculty">Факультет: </label>
        <select name="faculty">
            <option value="0">Выберите факультет</option>
            <?php
            
            require 'connect.php';
            $link = $_SESSION['db'];

            $facultySQL = 'SELECT * FROM `faculty`';
            
            $facultyQuery = mysqli_query($link, $facultySQL);

            while($facultyContent = mysqli_fetch_assoc($facultyQuery)){?>
                <option value='<?=$facultyContent['id']?>'  <?php if ($_POST['faculty'] == $facultyContent['id']) :?> selected="selected"  <?php endif; ?>><?=$facultyContent['title']?></option>

            <?php } ?>
        </select>
    </div>
    <div class="departmentField">
        <label for="department">Кафедра: </label>
        <select name="department">
        <option value="0">Выберите кафедру</option>
            <?php

            require 'connect.php';
            $link = $_SESSION['db'];

            $departmentSQL = 'SELECT * FROM `department`';

            $departmentQuery = mysqli_query($link, $departmentSQL);

            while($departmentContent = mysqli_fetch_assoc($departmentQuery)){?>
                <option value='<?=$departmentContent['id']?>'   <?php if ($_POST['department'] == $departmentContent['id']) :?> selected="selected"  <?php endif; ?> ><?=$departmentContent['title']?></option>
            <?php } ?>
        </select>
    </div>
    <div class="specField">
        <label for="spec">Образовательная программа: </label>
        <select name="spec">
        <option value="0">Выберите Образовательную программу</option>
            <?php

            require 'connect.php';
            $link = $_SESSION['db'];

            $specSQL = 'SELECT * FROM `spec`';

            $specQuery = mysqli_query($link, $specSQL);

            while($specContent = mysqli_fetch_assoc($specQuery)){?>
                <option value='<?=$specContent['id']?>' <?php if ($_POST['spec'] == $specContent['id']) :?> selected="selected"  <?php endif; ?> ><?=$specContent['title']?></option>
           <?php }

            ?>
        </select>
    </div>

    <div class="editions">
        <?php

            require 'connect.php';
            $link = $_SESSION['db'];

            $editionSQL = 'SELECT * FROM `edition`';

            $editionQuery = mysqli_query($link, $editionSQL);

            $checkboxName = 'check';
            
            $j = 0;
            
            while($editionContent = mysqli_fetch_assoc($editionQuery)){
                $j++;
                $checkboxName = 'check' . $j;
                ?>
    
            <div class="checkBlock">
                <input type="checkbox" name="<?=$checkboxName?>" <?php if ($_POST[$checkboxName] == 'on'):?> checked <?php endif; ?>>
                <label for="<?=$checkboxName?>"><?=$editionContent['title']?></label>
            </div>
            
            <?php
            }
        ?>
        
    </div>

    <input type="submit" name="createReport" class="createBtn" value="Сформировать отчёт">
    <input type="submit" name="clear" class="createBtn" value="Сбросить">
    <input type="submit" name="createExcel" class="createBtn" value="Экспортировать отчёт в Excel">

</form>

<div class="fieldTable">
    <table class="statsTable">
        <tr>
            <th>ID</th>
            <th>Дата добавления</th>
            <th>Название книги</th>
            <th>Год публикации</th>
            <th>Количество страниц</th>
            <th>Автор</th>
            <th>Соавтор</th>
            <th>Издательство</th>
            <th>Вид издания</th>
            <th>Аннотация</th>
            <th>Ключевые слова</th>
            <th>Формат файла</th>
            <th>Размер файла</th>
            <th>ISBN</th>
            <th>BBK</th>
            <th>UDK</th>
            <th>Рубрика</th>
            <th>Факультет</th>
            <th>Кафедра</th>
            <th>Специальность</th>
            <th>Ссылка на скачивание</th>
            <th>Количество скачиваний</th>
        </tr>
        <?php      

            $mainSQL;
            $sortSql;

            $addDate;
            $izdDate;
            $facultyData;
            $departmentData;
            $specData;
            $editionData;
            
            if (isset($_POST['createReport'])){


                if ($_POST['addStartDate'] > $_POST['addEndDate']){
                    echo '<p class="status"> Ошибка! В поле дата добавления, начальная дата больше конечной даты</p><br>';
                }else if( strlen($_POST['addStartDate']) > 0 && strlen($_POST['addEndDate']) > 0 ){
                    $addDate = '`date` >= \'' . $_POST['addStartDate'] . '\' AND `date` <= \'' . $_POST['addEndDate'] . "'";
                }else{
                    $addDate = '';
                }


                if ($_POST['izdStartDate'] > $_POST['izdEndDate']){
                    echo '<p class="status"> Ошибка! В поле дата издания, начальная дата больше конечной даты</p><br>';
                }else if( strlen($_POST['izdStartDate']) > 0 && strlen($_POST['izdEndDate']) > 0 ){
                    $izdDate = '`pub_year` >= \'' . $_POST['izdStartDate'] . '\' AND `pub_year` <= \'' . $_POST['izdEndDate'] . "'";
                    if (!(strlen($_POST['addStartDate']) > 0 && strlen($_POST['addEndDate']) > 0 )){
                        $izdDelimeter = '';
                    }else{
                        $izdDelimeter = ' AND '; 
                    }
                }else{
                    $izdDate = '';
                    $izdDelimeter = '';
                }

                if ($_POST['faculty'] > 0){
                    $facultyData = '`faculty_id` = ' . $_POST['faculty'];
                    if (strlen($_POST['izdStartDate']) > 0 && strlen($_POST['izdEndDate']) > 0 ){
                        $facDelimeter = ' AND ';
                    }else{
                        $facDelimeter = '';
                    }
                }else{
                    $facultyData = '';
                    $facDelimeter = '';
                }

                if ($_POST['department'] > 0){
                    $departmentData = '`department_id` = ' . $_POST['department'];
                    if ($_POST['faculty'] > 0){
                        $depDelimeter = ' AND ';
                    }else{
                        $depDelimeter = '';
                    }
                }else{
                    $departmentData = '';
                    $depDelimeter = '';
                }

                if ($_POST['spec'] > 0){
                    $specData = '`spec_id` = ' . $_POST['spec'];
                    if ($_POST['department'] > 0){
                        $specDelimeter = ' AND ';
                    }else{
                        $specDelimeter = '';
                    }
                }else{
                    $specData = '';
                    $specDelimeter = '';
                }

                $checkEdition = false;
                $editionData = '`vid_izd_id` = ';
                $b = 1;
                for ($i=1;$i<=15;$i++){
                    $postName = 'check' . $i;

                    if ($_POST[$postName] == 'on'){
                        $checkEdition = true;
                        if ($_POST['spec'] > 0){
                            $editionDelimeter = ' AND ';
                        }else{
                            $editionDelimeter = '';
                        }
                        if ($b > 1){
                            $editionData .= ' or `vid_izd_id` = ';
                        }
                        $b++;
                        $editionData .= $i;
                    }
                }
                if ($checkEdition == false){
                    $editionData = '';
                }



                $sortSql = 'SELECT * FROM `materials` WHERE ' . $addDate . $izdDelimeter . $izdDate . $facDelimeter . $facultyData . $depDelimeter . $departmentData . $specDelimeter . $specData . $editionDelimeter . $editionData;
                if (strlen($sortSql) == 32){
                    $sortSql = 'SELECT * FROM `materials`';
                }
                $_SESSION['sortSQL'] = $sortSql;
            }else if (isset($_POST['clear'])){
                echo '<script>window.location.href = "stats.php";</script>';
                $_SESSION['sortSQL'] = '';
            }else if (isset($_POST['createExcel'])){
                
            }


            if (strlen($_SESSION['sortSQL']) > 1){
                $mainSQL = mysqli_query($link, $_SESSION['sortSQL']);
            }else{
                $mainSQL = mysqli_query($link, 'SELECT * FROM `materials`');
            }
            $rowsCount = mysqli_num_rows($mainSQL);
            
            echo "<b>Найдено строк: " . $rowsCount . "</b>";
            
            $pagesPerTime = 10;

            $page = ""; 

            $queryStr = $_SERVER["QUERY_STRING"];
                                            
            $page = str_replace("page-", "", $queryStr);

            $products = mysqli_num_rows($mainSQL);
                                            
            $page__count = floor($products / $pagesPerTime)+1; 
            
            function getInfo($sqlText){ 

                $pagesPerTime = 10;

                $page = ""; 

                $queryStr = $_SERVER["QUERY_STRING"];
                                                
                $page = str_replace("page-", "", $queryStr);
                
                $products = mysqli_num_rows($sqlText);
                                                
                $page__count = floor($products / $pagesPerTime); 

                $i = 1;
                while ($queryContent = mysqli_fetch_assoc($sqlText)){    
                    
                    if($i >= (int)$page*$pagesPerTime && $i <= ((int)$page+1)*$pagesPerTime){?>
                        <tr>   
                            <td> <?=$queryContent['id']?> </td>
                            <td> <?=$queryContent['date']?> </td>
                            <td> <?=$queryContent['book__name']?> </td>
                            <td> <?=$queryContent['pub_year']?> </td>
                            <td> <?=$queryContent['pages_count']?> </td>
                            <td> <?=$queryContent['author']?> </td>
                            <td> <?=$queryContent['co_author']?> </td>
                            <td> <?=$queryContent['izd']?> </td>
                            <td> <?=$queryContent['vid_izd_id']?> </td>
                            <td class='descriptStyle'> <?=$queryContent['description']?> </td>
                            <td> <?=$queryContent['keyWords']?> </td>
                            <td> <?=$queryContent['format']?> </td>
                            <td> <?=$queryContent['size']?> </td>
                            <td> <?=$queryContent['isbn']?> </td>
                            <td> <?=$queryContent['bbk']?> </td>
                            <td> <?=$queryContent['udk']?> </td>
                            <td> <?=$queryContent['rubric_id']?> </td>
                            <td> <?=$queryContent['faculty_id']?> </td>
                            <td> <?=$queryContent['department_id']?> </td>
                            <td> <?=$queryContent['spec_id']?> </td>
                            <td> <?=$queryContent['link']?> </td>
                            <td> <?=$queryContent['downloads']?> </td>
                            
                        </tr> 
                    <?php
                    }
                    $i++;
                            
                }
            
            }

            getInfo($mainSQL);

            
            
        ?>
    </table>

</div>
<div class="navigation__menu">
                

                <?php 
                    $addClassPrev = "";
                    $pagesVarPrev = "page-" . (string)((int)$page - 1);
                    $addClassNext = "";
                    $pagesVarNext = "page-" . (string)((int)$page + 1);
                    if ((string)((int)$page - 1) < 0){
                        $addClassPrev = "disable";
                    }
                    if ((string)((int)$page + 1) >= $page__count){
                        $addClassNext = "disable";
                    }
                    
                    echo "<style>";
                    echo "." . $queryStr . "{";
                        echo "background-color: var(--backgroundColor);color:#fff;}";
                    echo "</style>";
                    
                    if (!($addClassNext == "disable" && $addClassPrev == "disable")):
                ?>
                <a href="?<?=$pagesVarPrev?>" class=" <?=$addClassPrev ?>">
                    <button class="nav__btn__arrows <?=$pagesVarPrev ?>" method="GET" name="page" >
                        <img src="../images/arrow.png" alt="" class="pagination__arrow__img pagination__prev__arrow">
                    </button>
                </a>
                <?php
                for ($p = (int)$page-1;$p < (int)$page+2; $p++ ):
                        if ($p == -1){
                            $p += 1;
                        }
                            $pagesVar = "page-" . $p;
                            if ($p != $page__count):?>
                        
                                <a href="?page-<?php echo $p;?>"  >
                                    <button class="nav__btn <?=$pagesVar ?>" method="GET" name="page">
                                        <?php echo $p + 1?>
                                    </button>
                                </a>
                            <?php else:?>
                                <a href="?page-0" >
                                    <button class="nav__btn page-0" method="GET" name="page">
                                        1
                                    </button>
                                </a>
                            <?php endif;?>
                        

                <?php endfor;?>

                
                <a href="" class="disable">
                    <button class="nav__btn">
                        ...
                    </button>
                </a>  


                <a href="<?="?page-" . ($page__count - 1)?>">
                    <button class="nav__btn <?="page-" . ($page__count - 1) ?>" method="GET" name="page" >
                        <?=$page__count?>
                    </button>
                </a>   


                
                <a href="?<?=$pagesVarNext?>"  class=" <?=$addClassNext ?>">
                    <button class="nav__btn__arrows <?=$pagesVarNext ?>" method="GET" name="page" >
                        <img src="../images/arrow.png" alt="" class="pagination__arrow__img pagination__next__arrow">
                    </button>
                </a>
                <?php endif;?>
</div>




<?php

require "footer.php";

?>


