<?php


    //-----------------------------//
    //     8. PLIK WYLOGUJ.PHP    //
    //-----------------------------//

    //-------------------------------------------------------//
    //     8.1. Plik wyloguj.php - Wylogowanie z systemu     //
    //-------------------------------------------------------//

    // Wylogowanie z systemu polega wyłącznie na zniszczeniu sesji przeglądarki i przekierowaniu użytkownika na stronę główną.

    session_start();

    session_unset();

    header('Location: ../index.php');
    
?>