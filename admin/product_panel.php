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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Kostka Rubika to moje hobby</title>

  <link rel="stylesheet" type="text/css" href="/www/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/www/css/custom.css">

  <script src="/www/js/bootstrap.bundle.min.js"></script>
  <script src="/www/js/jquery-3.6.0.min.js"></script>
  <script src="/www/js/custom.js"></script>

</head>

<body>
  <?php include('../navbar.php'); ?>
  <div class="container" id="content">          
            


    <section>
        <div class="content">

            <div class="panel-window">
                <h2><span>Panel Produktów</span></h2>
                <?php

                    echo 'Zalogowano jako użytkownik: '.$_SESSION['login'];
                    echo '
                    <form method="post" name="CreateForm" enctype="multipart/form-data" action="product_create.php">
                        <input class="btn btn-primary" type="submit" name="create" value="Dodaj nowy produkt" />
                    </form>
                    ';
                    echo '<h3 style="margin: 20px auto;">Lista dostępnych produktów:</h3>';
                    ProductList($dblink);
                    
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
                if($_GET['page'] == 'Home'){
                    header('Location: ../index.php');
                    exit();
                }
            ?>
        </div>
    </section>


</body>
</html>
