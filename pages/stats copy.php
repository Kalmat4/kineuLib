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
            <?php
            $columnNameArray = array();

            $mainSQL = "SELECT COLUMN_NAME 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = 'materials'";

            $query = mysqli_query($link, $mainSQL);

            while ($queryContent = mysqli_fetch_assoc($query)){
                if ($queryContent['COLUMN_NAME'] == 'description'){
                    echo "<th class='descriptStyle'>" . $queryContent['COLUMN_NAME'] . "</th>";
                    $columnNameArray[] = $queryContent['COLUMN_NAME'];
                }else{
                    echo "<th>" . $queryContent['COLUMN_NAME'] . "</th>";
                    $columnNameArray[] = $queryContent['COLUMN_NAME'];
                }
            }
            ?>
        </tr>
        <?php


            $mainSQL = mysqli_query($link, "SELECT * FROM `materials`");
            $pagesPerTime = 10;
            $page = ""; 
            $queryStr = $_SERVER["QUERY_STRING"];
                        
            $page = str_replace("page-", "", $queryStr);
        
            $products = mysqli_num_rows($mainSQL);
            
            $page__count = floor($products / $pagesPerTime); 
            
            function getInfo($sqlText){
                $pagesPerTime = 10;
                $page = ""; 
                $queryStr = $_SERVER["QUERY_STRING"];
                            
                $page = str_replace("page-", "", $queryStr);

                $products = mysqli_num_rows($sqlText);
                         
                $page__count = floor($products / $pagesPerTime); 
                $k = 0;
                while ($queryContent = mysqli_fetch_assoc($sqlText)){
                        
                        if($i >= (int)$page*$pagesPerTime && $i <= ((int)$page+1)*$pagesPerTime){             
                            echo "<tr>";
                            $k = 0;
                            for ($a = 0; $a<=21; $a++){ 
                                if ($columnNameArray[$k] == 'description'){
                                    echo "<td class='descriptStyle'>" . $queryContent[$columnNameArray[$k]] . "</td>";
                                    $k++;
                                }else{
                                    echo "<td>" . $queryContent[$columnNameArray[$k]] . "</td>";
                                    $k++;
                                }
                            }
                            echo "</tr>";
                        
                            $i++;
                            $page__counter++;
                        }
                        
                }

            }
            
            getInfo($mainSQL);
        ?>
    </table>
</div>



<?php


if (isset($_POST['createReport'])){
    if ($_POST['addStartDate'] > $_POST['addEndDate']){
        echo '<p class="status"> Ошибка! В поле дата добавления, начальная дата больше конечной даты</p><br>';
    }
    if ($_POST['izdStartDate'] > $_POST['izdEndDate']){
        echo '<p class="status"> Ошибка! В поле дата издания, начальная дата больше конечной даты</p><br>';
    }
}else if (isset($_POST['clear'])){
    echo '<script>window.location.href = "stats.php";</script>';
}

?>




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
</div>



<?php

require "footer.php";

?>


