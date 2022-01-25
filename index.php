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

  <link rel="stylesheet" type="text/css" href="/www/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/www/css/custom.css">

  <script src="/www/js/bootstrap.bundle.min.js"></script>
  <script src="/www/js/jquery-3.6.0.min.js"></script>

</head>

<body>
  <?php include('navbar.php'); ?>
  <div class="container" id="content">



    <?php
    function showPage($strona, $dblink)
    {

      $query = "SELECT * FROM page_list WHERE page_title LIKE '$strona' LIMIT 1";
      $result = mysqli_query($dblink, $query);
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
        include 'admin/login_form.php';
        break;
      case 'Kontakt':
        include 'admin/contact.php';
        break;
      case 'Sklep':
        include 'shop/shop.php';
        break;
      case 'Koszyk':
        include 'shop/cart.php';
        break;
      case 'cms':
        if (isset($_SESSION['login'])) {
          header('Location: admin/cms.php');
          exit();
          break;
        }
        include 'admin/login_form.php';
        break;
      default:
        showPage($strona, $dblink);
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