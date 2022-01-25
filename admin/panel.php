<?php

//-------------------------//
//     2. PLIK panel.PHP     //
//-------------------------//

//----------------------------------------------------------------------//
//     2.1. Plik panel.php - Strona dostępna tylko dla administratora     //
//----------------------------------------------------------------------//

// Rozpoczynamy sesję przeglądarki, dzięki temu możemy korzystać ze zmiennych sesji
// utworzonych w innych obszarach systemu niezależnie od tego gdzie się aktualnie znajdujemy

session_start();

include 'admin.php';
include '../cfg.php';

//-----------------------------------------//
//     2.2. Odpowiednie przekierowanie     //
//-----------------------------------------//

// Warunek blokujący dostęp do panelu panel użytkownikom niezalogowanym: 
// na przykład kiedy użytkownik postanowi wpisać ręcznie adres strony 'panel.php' bez wcześniejszego
// zalogowania się to warunek przekieruje użytkownika do formularza logowania.

if (!isset($_SESSION['login'])) {
    header('Location: ../index.php?page=zaloguj');
    exit();
}

// Warunek sprawdza czy istnieje zmienna GET 'page', jest to zmienna, której system używa 
// do przekierowań na inne podstrony, w przypadku poniżej jeżeli zmienna page nie istnieje- 
// system nie przekierowuje nas do podstrony lub innej części systemu wyświetlona 
// zostaje strona panelu panel

if (!isset($_GET['page'])) {
    $_GET['page'] = 'Panel';
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/custom.css">
    <title>Panel</title>
</head>

<body>
    <?php
    include '../navbar.php';
    ?>
    <div class="container" id="content">
        <div>
            <h2><span>Panel CMS</span></h2>
            <?php

            echo 'Zalogowano jako użytkownik: ' . $_SESSION['login'];
            echo '
                    <form method="post" name="CreateForm" enctype="multipart/form-data" action="page_create.php">
                        <input class="btn btn-success mt-2" type="submit" name="create" value="Dodaj nową stronę" />
                    </form>
                    ';
            echo '<h3 style="margin: 20px auto;">Lista dostępnych podstron:</h3>';
            SubpageList($dblink);

            ?>
        </div>
        <div>
            <h2><span>Panel Kategorii</span></h2>
            <?php

            echo '
                    <form method="post" name="CreateForm" enctype="multipart/form-data" action="category_create.php">
                    <input class="btn btn-success mt-2" type="submit" name="create" value="Dodaj nową kategorię" />
                    </form>
                    ';
            echo '<h3 style="margin: 20px auto;">Lista dostępnych kategorii głównych i podkategorii:</h3>';
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
        if ($_GET['page'] == 'Wyloguj') {
            header('Location: logout.php');
            exit();
        }
        if ($_GET['page'] == 'Home') {
            header('Location: ../index.php');
            exit();
        }
        ?>
    </div>
</body>

</html>