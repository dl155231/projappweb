<?php

//-------------------------//
//     2. PLIK CMS.PHP     //
//-------------------------//

//----------------------------------------------------------------------//
//     2.1. Plik CMS.php - Strona dostępna tylko dla administratora     //
//----------------------------------------------------------------------//

// Rozpoczynamy sesję przeglądarki, dzięki temu możemy korzystać ze zmiennych sesji
// utworzonych w innych obszarach systemu niezależnie od tego gdzie się aktualnie znajdujemy

session_start();

include 'admin.php';
include '../cfg.php';

//-----------------------------------------//
//     2.2. Odpowiednie przekierowanie     //
//-----------------------------------------//

// Warunek blokujący dostęp do panelu CMS użytkownikom niezalogowanym: 
// na przykład kiedy użytkownik postanowi wpisać ręcznie adres strony 'CMS.php' bez wcześniejszego
// zalogowania się to warunek przekieruje użytkownika do formularza logowania.

if (!isset($_SESSION['login'])) {
    header('Location: ../index.php?page=zaloguj');
    exit();
}

// Warunek sprawdza czy istnieje zmienna GET 'page', jest to zmienna, której system używa 
// do przekierowań na inne podstrony, w przypadku poniżej jeżeli zmienna page nie istnieje- 
// system nie przekierowuje nas do podstrony lub innej części systemu wyświetlona 
// zostaje strona panelu CMS

if (!isset($_GET['page'])) {
    $_GET['page'] = 'CMS';
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/custom.css">
    <title>Panel CMS</title>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-light bg-light mx-auto">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Kostka Rubika - moja pasja</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0" id="navbarContent">


                    <li class="nav-item">
                        <a class="nav-link" href="CMS.php?page=Home">Home</a></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="shop_panel.php">Panel sklepu</a>
                    </li>

                    <li class="nav-item">
                        <?php
                        if (isset($_SESSION['login']))
                            echo '<a class="nav-link" href="CMS.php?page=Wyloguj">Wyloguj</a>';
                        else
                            echo '<a class="nav-link" href="CMS.php?page=Zaloguj">Zaloguj</a>';

                        ?>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="container" id="content">

        <div class="cms-window">
            <h2><span>Panel CMS</span></h2>
            <?php

            echo 'Zalogowano jako użytkownik: ' . $_SESSION['login'];
            echo '
                    <form method="post" name="CreateForm" enctype="multipart/form-data" action="page_create.php">
                        <input class="btn btn-primary mt-2" type="submit" name="create" value="Dodaj nową stronę" />
                    </form>
                    ';
            echo '<h3 style="margin: 20px auto;">Lista dostępnych podstron:</h3>';
            ListaPodstron($dblink);

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

    <footer>
        <div class="footer">
            <table>
                <tr>
                    <td>Piotr Kowalski</td>
                    <td>numer indeksu: 156036</td>
                </tr>
                <tr>
                    <td>Strona wykonana na potrzeby przedmiotu</td>
                    <td>Programowanie aplikacji WWW</td>
                </tr>
            </table>
        </div>
    </footer>
</body>

</html>