<?php

//---------------------------//
//     1. PLIK INDEX.PHP     //
//---------------------------//

//---------------------------------------------//
//     1.1. Plik index.php - główna strona     //
//---------------------------------------------//

// Rozpoczynamy sesję przeglądarki, dzięki temu możemy korzystać ze zmiennych sesji
// utworzonych w innych obszarach systemu niezależnie od tego gdzie się aktualnie znajdujemy.

session_start();
// error_reporting(E_ALL);
include 'cfg.php';

//-----------------------------------------//
//     1.2. Odpowiednie przekierowanie     //
//-----------------------------------------//

// warunek sprawdza czy istnieje zmienna GET 'page', jest to zmienna, której system używa 
// do przekierowań na inne podstrony, w przypadku poniżej jeżeli zmienna page nie istnieje- 
// system nie przekierowuje nas do podstrony lub innej części systemu wyświetlona 
// zostaje strona główna 

if (!isset($_GET['page'])) {
  $_GET['page'] = 'Home';
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Kostka Rubika to moje hobby</title>

  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/custom.css">

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="js/timedate.js"></script>

</head>

<body>
  <div class="container" id="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mx-auto">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Kostka Rubika - moja pasja</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mb-2 mb-lg-0" id="navbarContent">
            <?php include('html/navbar.php'); ?>
            <li class="nav-item">
              <a class="nav-link" href="?page=Kontakt">Kontakt</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?page=Sklep">Sklep</a>
            </li>
            <li class="nav-item">
              <span class="nav-link disabled" id="date"></span>
            </li>
            <li class="nav-item">
              <span class="nav-link disabled" id="clock"></span>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <?php
    function showPage($strona, $connection)
    {

      $query = "SELECT * FROM page_list WHERE page_title LIKE '$strona' LIMIT 1";
      $result = mysqli_query($connection, $query);
      $row = mysqli_fetch_array($result);

      if (empty($row['id'])) {
        $web = '404 - strona nie istnieje';
      } else {
        $web = $row['page_content'];
      }

      echo $web;
    }

    $strona = $_GET['page'];
    switch ($strona) {
      case 'Wyloguj':
        header('Location: admin/logout.php');
        exit();
        break;
      case 'Zaloguj':
        include 'admin/form_login.php';
        break;
      case 'Kontakt':
        include 'admin/contact.php';
        break;
      case 'cms':
        if (isset($_SESSION['login'])) {
          header('Location: admin/cms.php');
          exit();
          break;
        }
        include 'admin/form_login.php';
        break;
      default:
        showPage($strona, $connection);
        break;
    }
    ?>
  </div>



  <script src="js/kolorujtlo.js" type="text/javascript"></script>
  <script>
    $(document).ready(() => {
      startClock();
    })
  </script>
  <?php
  $nr_indeksu = 155231;
  $nrGrupy = '3';
  echo 'Autor: Dominik Lewandowski ' . $nr_indeksu . ' grupa ' . $nrGrupy;
  ?>
</body>


</html>