<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'moja_strona';
$admin_login = 'admin';
$admin_passwd = 'admin';
$dblink =  mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$dblink) echo '<b>Błąd podczas łączenia serwerem bazy danych.</b>';
if (!mysqli_select_db($dblink, $db)) echo '<b>Błąd podczas łączenia z bazą danych.</b>';
?>