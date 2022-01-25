<?php

    session_start();

    include 'admin.php';
    include '../cfg.php';

    if (!isset($_SESSION['login'])){
        header('Location: ../index.php?page=zaloguj');
        exit();
    }

    if(!isset($_GET['page'])){
        $_GET['page']='panel'; 
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel Sklepu</title>
</head>
<body>
    <header>
        <div class="menu">          
            <?php
                if($_GET['page']!="Home"){
                    echo '
                    <a href="panel.php?page=Home">Home</a>
                    ';
                }
                echo '
                    <a href="panel.php">Panel panel</a>
                    <a href="panel.php">Panel Kategorii</a>
                    ';
            ?>
            <a href ="#" id="data"></a>
		    <a href ="#" id="time"></a>
		    <script src="../js/timedate.js" type="text/javascript"></script>

            
            <?php

            if(isset($_SESSION['login'])){
                echo '<div class="right-menu-item"><a href="panel.php?page=wyloguj">Wyloguj</a></div>';
            }
            else {
                echo '<div class="right-menu-item"><a href="panel.php?page=zaloguj">Zaloguj</a></div>';
            }
            
            ?>

        </div>
    </header>

    <section>
        <div class="content">

            <div class="panel-window">
                <h2><span>Panel Produktów</span></h2>
                <?php

                    echo 'Zalogowano jako użytkownik: '.$_SESSION['login'];
                    echo '
                    <form method="post" name="CreateForm" enctype="multipart/form-data" action="create_product.php">
                        <input style="margin-top: 20px;" type="submit" name="create" value="Dodaj nowy produkt" />
                    </form>
                    ';
                    echo '<h3 style="margin: 20px auto;">Lista dostępnych produktów:</h3>';
                    ListaProdukty($dblink);
                    
                ?>
            </div>

            <?php
                //---------------------------------------//
                //     2.4. Nawigacja poza panel panel     //
                //---------------------------------------//

                // Pierwszy warunek zprawdza czy istnieje zmienna page o wartości 'wyloguj', jeżeli tak, to użytkownik zostaje przekierowany
                // do podstrony wyloguj.php, która odpowiada za zniszczenie zmiennych sesji przypisanych do zalogowanego użytkownika
                // (wylogowanie z systemu).

                $strona = $_GET['page'];
                if($_GET['page'] == 'wyloguj'){
                    header('Location: wyloguj.php');
                    exit();
                }
                if($_GET['page'] == 'Główna'){
                    header('Location: ../index.php');
                    exit();
                }
            ?>
        </div>
    </section>


</body>
<script src="../js/onloadfunctionspanel.js" type="text/javascript"></script>
</html>
