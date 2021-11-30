<?php include('cfg.php'); ?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="utf-8">
  <title>Kostka Rubika to moje hobby</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
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
    7
    <?php
    if ($_GET['page'] == '') $strona = 'html/index.html';
    if ($_GET['page'] == 'contact') $strona = 'html/contact.html';
    if ($_GET['page'] == 'history') $strona = 'html/history.html';
    if ($_GET['page'] == 'gallery') $strona = 'html/gallery.html';
    if ($_GET['page'] == 'facts') $strona = 'html/interesting_facts.html';
    include($strona);
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