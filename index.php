<?php include('cfg.php');
include('showpage.php'); ?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="utf-8">
  <title>Kostka Rubika to moje hobby</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src='js/timedate.js' type="text/javascript"></script>

</head>

<body onload="startClock()">
  <?php
  error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
  /* po tym komentarzu będzie kod do dynamicznego ładowania stron */
  ?>
  <table id="layout" class="container-fluid" width="1200">
    <tr id="heading">
      <td colspan="6">
        <h1>Kostka Rubika - moja pasja</h1>
      </td>
    </tr>
    <?php include('html/navbar.php'); ?>
    <tr id="spacer" height="10">
      <td>
      </td>
    </tr>
    <?php
    switch ($_GET['page']) {
      case '':
        showSubpage(1);
        break;
      case 'history':
        showSubpage(2);
        break;
      case 'facts':
        showSubpage(3);
        break;
      case 'gallery':
        showSubpage(4);
        break;
      case 'contact':
        showSubpage(5);
        break;
    }
    ?>


  </table>

  <script src="js/kolorujtlo.js" type="text/javascript"></script>
  <?php
  $nr_indeksu = 155231;
  $nrGrupy = '3';
  echo 'Autor: Dominik Lewandowski ' . $nr_indeksu . ' grupa ' . $nrGrupy;
  ?>
</body>


</html>