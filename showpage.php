<?php

if (!$link) echo '<b> Przerwane polaczenie</b>';
function showSubpage($id)
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza = 'moja_strona';
    $link = mysqli_connect($dbhost, $dbuser, $dbpass);
    $id_clear = htmlspecialchars($id);
    $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1;";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);
    echo $row;
}
?>