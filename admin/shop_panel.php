<?php

    session_start();

    include 'admin.php';
    include '../cfg.php';

    if (!isset($_SESSION['login'])){
        header('Location: ../index.php?page=zaloguj');
        exit();
    }

    if(!isset($_GET['page'])){
        $_GET['page']='CMS'; 
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/custom.css">
    <title>Panel Sklepu</title>
</head>
<body>
    <header>
        <div class="menu">          
            <?php
                if($_GET['page']!="Główna"){
                    echo '
                    <a href="CMS.php?page=Home">Strona główna</a>
                    ';
                }
                echo '
                    <a href="CMS.php">Panel CMS</a>
                    <a href="product_panel.php">Panel Produktów</a>
                    ';
            ?>
            <a href ="#" id="data"></a>
		    <a href ="#" id="time"></a>
		    <script src="../js/timedate.js" type="text/javascript"></script>

            
            <?php

            if(isset($_SESSION['login'])){
                echo '<div class="right-menu-item"><a href="CMS.php?page=wyloguj">Wyloguj</a></div>';
            }
            else {
                echo '<div class="right-menu-item"><a href="CMS.php?page=zaloguj">Zaloguj</a></div>';
            }
            
            ?>

        </div>
    </header>

    <section>
        <div class="content">

            <div class="cms-window">
                <h2><span>Panel Kategorii</span></h2>
                <?php

                    echo 'Zalogowano jako użytkownik: '.$_SESSION['login'];
                    echo '
                    <form method="post" name="CreateForm" enctype="multipart/form-data" action="category_create.php">
                        <input class="btn btn-primary my-2" type="submit" name="create" value="Dodaj nową kategorię" />
                    </form>
                    ';
                    echo '<h3>Lista dostępnych kategorii głównych i podkategorii:</h3>';
                    ListaKategorie($dblink);
                    
                ?>
            </div>

            <?php
                //---------------------------------------//
                //     2.4. Nawigacja poza panel CMS     //
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

    <footer>
        <div class="footer">
            <table>
                <tr><td>Piotr Kowalski</td><td>numer indeksu: 156036</td></tr>
                <tr><td>Strona wykonana na potrzeby przedmiotu</td><td>Programowanie aplikacji WWW</td></tr>
            </table>
        </div>
    </footer>
</body>
<script src="../js/onloadfunctionsCMS.js" type="text/javascript"></script>
</html>
