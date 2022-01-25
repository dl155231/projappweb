<?php

session_start();

include 'admin.php';
include '../cfg.php';

if (!isset($_SESSION['login'])) {
    header('Location: ../index.php?page=zaloguj');
    exit();
}

if (!isset($_GET['page'])) {
    $_GET['page'] = 'panel';
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/custom.css">
    <title>Panel Sklepu</title>
</head>

<body>


    <?php
    include '../navbar.php';
    ?>
    <div class="container" id="content">


        <div class="content">

            <div class="">
                <h2><span>Panel Kategorii</span></h2>
                <?php

                echo 'Zalogowano jako użytkownik: ' . $_SESSION['login'];
                echo '
                    <form method="post" name="CategoryCreateForm" enctype="multipart/form-data" action="category_create.php">
                        <input class="btn btn-primary my-2" type="submit" name="create" value="Dodaj nową kategorię" />
                    </form>
                    ';
                echo '<h3>Lista dostępnych kategorii głównych i podkategorii:</h3>';
                CategoryList($dblink);

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
            if ($_GET['page'] == 'wyloguj') {
                header('Location: wyloguj.php');
                exit();
            }
            if ($_GET['page'] == 'Główna') {
                header('Location: ../index.php');
                exit();
            }
            ?>
        </div>

</body>

</html>