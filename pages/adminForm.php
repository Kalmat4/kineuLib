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
   
    <div class="table-wrap">
            <table>
                <tr>
                    <?php
                        require 'connect.php';
                        error_reporting(0);
                        $link = $_SESSION['db'];
                        $sql = mysqli_query($link, "SELECT * FROM `materials`");
                        $contentPlus = mysqli_fetch_assoc($sql);
                        
                            echo "<th class='th'>ID</th>";
                            if (strlen($contentPlus['date']) > 1){
                                echo "<th class='th'>Дата</th>";   
                            }
                            if (strlen($contentPlus['book__name']) > 1){
                                echo "<th class='th'>Название книги</th>";   
                            }
                            echo "<th class='th'></th>";   

                        
                    
                    ?>
                </tr>
                <?php
                        $pagesPerTime = 20;
                        $page = ""; 
                        $queryStr = $_SERVER["QUERY_STRING"];
                                    
                        $page = str_replace("page-", "", $queryStr);

                        $products = mysqli_num_rows($sql);
                                    
                        $page__count = floor($products / $pagesPerTime); 
                        
                        function getInfo($sqlText){ 
                            $pagesPerTime = 20;
                            $page = ""; 
                            $queryStr = $_SERVER["QUERY_STRING"];
                                        
                            $page = str_replace("page-", "", $queryStr);
        
                            $products = mysqli_num_rows($sqlText);
                                        
                            $page__count = floor($products / $pagesPerTime); 
        
                                        
                            $page__counter = 1;

                            $i = 1;
                            while($content = mysqli_fetch_assoc($sqlText)){
                                
                                if($i >= (int)$page*$pagesPerTime && $i <= ((int)$page+1)*$pagesPerTime){
                                    echo "<tr>";
                                    echo "<td class='td'>{$i}</td>";
                                    if (strlen($content['date']) > 1){
                                        echo "<td class='td'>{$content['date']}</td>";   
                                    }
                                    if (strlen($content['book__name']) > 1){
                                        echo "<td class='td'>{$content['book__name']}</td>";   
                                    }
                                    echo "<td class='tdUnActive'><a href='adminEdit.php?bookId={$i}' class='btn editBtn'><img src='../images/edit.png' alt='Редактировать'></a><a href='#' class='btn delBtn'><img src='../images/del.png' alt='Удалить'></a></td>";
                                    echo "</tr>";  
                                    
                                }
                                $i++;
                                $page__counter++;
                                
                            }
                        }
                        getInfo($sql);
                            
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
        
</div>
<?php

require "footer.php";

?>