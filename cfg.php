<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'moja_strona';

$connection =  mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$connection) echo '<b>Błąd podczas łączenia serwerem bazy danych.</b>';
if (!mysqli_select_db($connection, $db)) echo '<b>Błąd podczas łączenia z bazą danych.</b>';
?>