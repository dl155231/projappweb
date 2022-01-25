<?php

    //-----------------------------//
    //     7. PLIK login_form.PHP    //
    //-----------------------------//

    //--------------------------------------------------------------------//
    //     7.1. Plik login_form.php - Formularz logowania do panelu CMS     //
    //--------------------------------------------------------------------//

    // Należy wspomnieć, że pomimo lokalizacji pliku 'login_form.php' w folderze admin, to zawartość
    // pliku 'login_form.php' jest wyświetlana z pozycji strony '../index.php', dlatego każdy adres przekierowania jest
    // pobierany z tej właśnie pozycji.

    //-----------------------------------------//
    //     7.2. Odpowiednie przekierowanie     //
    //-----------------------------------------//

    // Warunek sprawdza czy istnieje sesja, jeżeli nie, to sesja zostaje rozpoczęta w pliku 'login_form.php'
    // i użytkownik zostaje przekierowany do strony głównej ze zmienną 'page=zaloguj' co spowoduje wyświetlenie 
    // formularza logowania i zapewnie poprawne działanie systemu oraz przekierowań.

    // Drugi warunek sprawdza czy użytkownik jest zalogowany, jeżeli jest, to nie ma sensu wyświetlać formularza logowania,
    // a więc użytkownik zostaje przekierowany na stronę główną '../index.php'

    if(!isset($_SESSION)){
        session_start();
        if(isset($_SESSION['login'])){
            header('Location: ../index.php?page=zaloguj');
            exit();
        }
    }

    if(isset($_SESSION['login'])){
        header('Location: index.php');
        exit();
    }
?>
<div class="logowanie">

    <!-- 

        //----------------------------------//
        //     7.3. Formularz logowania     //
        //----------------------------------//

        // Po naciśnięciu przycisku 'Zaloguj', użytkownik zostaje przekierowany do strony admin/login.php

     -->
    <h1 class ="heading">Panel CMS</h1>
    <form method="post" name="LoginForm" enctype="multipart/form-data" action="admin/login.php">
        <table>
            <tr><td class="log4_t">[email]</td><td><input type="text" name="login_email" /></td></tr>
            <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" /></td></tr>
            <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" value="zaloguj" /></td></tr>
        </table>
    </form>
    <?php

        //----------------------------------//
        //     7.4. Wyświetlenie błędu      //
        //----------------------------------//

        // Za utworzenie zmiennej sesji zawierającej komunikat o błędzie logowania odpowiada funkcja 'Zaloguj()'
        // z pliku admin/admin.php. Warunek jedynie wyświetla wiadomość o błędzie logowania jeżeli takowa istnieje.

        if(isset($_SESSION['error']))
            // echo $_SESSION['error'];
            echo '
                <script type="text/javascript">
                    window.alert("'.$_SESSION['error'].'")
                </script>
                ';
    ?>
</div>