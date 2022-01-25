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
    <title>Panel Sklepu</title>
</head>
<body>
    <header>
        <div class="menu">          
            <?php
                if($_GET['page']!="Home"){
                    echo '
                    <a href="CMS.php?page=Home">Home</a>
                    ';
                }
                echo '
                    <a href="CMS.php">Panel CMS</a>
                    <a href="shop_panel.php">Panel Kategorii</a>
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
