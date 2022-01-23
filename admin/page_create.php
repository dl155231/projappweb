<?php
    //-----------------------------//
    //     5. PLIK CREATE.PHP     //
    //-----------------------------//

    //------------------------------------------------------------------//
    //     5.1. Plik create.php - Tworzenie nowej podstrony w bazie     //
    //------------------------------------------------------------------//

    // Rozpoczynamy sesję przeglądarki, dzięki temu możemy korzystać ze zmiennych sesji
    // utworzonych w innych obszarach systemu niezależnie od tego gdzie się aktualnie znajdujemy.

    session_start();

    include 'admin.php';
    include '../cfg.php';

    //-----------------------------------------//
    //     5.2. Odpowiednie przekierowanie     //
    //-----------------------------------------//

    // Warunek blokujący dostęp do okna tworzenia nowej strony użytkownikom niezalogowanym: 
    // na przykład kiedy użytkownik postanowi wpisać ręcznie adres strony 'create.php' bez wcześniejszego
    // zalogowania się to warunek przekieruje użytkownika do formularza logowania.
    
    if (!isset($_SESSION['login'])){
        header('Location: ../index.php?page=zaloguj');
        exit();
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Panel CMS</title>
</head>
<body style="min-height: 100Vh;">
    <div class="edit-content">
        <div class="logowanie">
            <?php

                //-----------------------------------//
                //     5.3. Powrót do panelu CMS     //
                //-----------------------------------//

                // Po naciśnięciu przycisku 'Anuluj' system przekieruje użytkownika spowrotem do panelu CMS.

                if(isset($_POST["cancel"])){
                    header('Location: CMS.php');
                    exit();
                }

                //---------------------------------------//
                //     5.4. Template nowego artykułu     //
                //---------------------------------------//

                // Do utworzenia poprawnego ukłądu strony i kontentu potrzebne jest wprowadzenie danych w odpowiednie miejsca i pojemniki.
                // W tym celu wykorzystywana jest zmienna '$content_template', która wyświetla podstawowy szablon artykułu w miejscu,
                // w którym użytkownik będzie wprowadzał kontent nowej strony.

                $content_template='
                    <h2><span>Tytuł strony</span></h2>
                    <hr></hr>
                    <h3>Tytuł sekcji</h3>
                    <div class="text-block">
                        <p>
                          Tutaj umieść tekst
                        </p>
                        <div class="image-cropper">
                            <img src="Żródło obrazka" alt="text alternatywny obrazka">
                        </div>
                    </div>
                ';

                //-----------------------------------------------//
                //     5.5. Formularz tworzenia nowej strony     //
                //-----------------------------------------------//

                // Wyświetlenie formularza pozwalającego na wprowadzenie danych:

                // 1. Tytuł
                // 2. Treść
                // 3. Czy aktywna (Pole typu radio, które determinuje czy artykuł będzie wyświetlany w menu rozwijanym)

                // oraz wyświetlającego przyciski 'Dodaj stronę do bazy danych' i 'Anuluj'

                echo '<h4>Okno Tworzenia Strony</h4>
                <table>
                <form method="post" name="EditForm" enctype="multipart/form-data" action="">
                    <tr><td>Tytuł: </td><td><input type="text" name="title" value="tytuł strony"/></td></tr>
                    <tr><td>Treść: </td><td><textarea cols="100" rows="30" name="content">'.$content_template.'</textarea></td></tr
                    <tr><td>Czy aktywna? </td><td><input type="checkbox" name="status"></td></tr>
                    <tr><td><input type="submit" name="confirm" value="Dodaj stronę do bazy danych"></td>
                    <td><input type="submit" name="cancel" value="Anuluj"></td></tr>
                 </form>
                 </table>
                ';

                //--------------------------------------//
                //     5.6. Utworzenie nowej strony     //
                //--------------------------------------//
                
                // Sposób działania: 

                // 1. Jeżeli naciśnięto przycisk 'Dodaj stronę do bazy danych' tworzone są zmienne '$content' i '$title',
                //    które pobierają tytuł i treść nowej strony z formularza z podpunktu 5.5.
                //
                // 2. Jeżeli pole typu radio zostało zaznaczone, to zmienna '$status' pryjmuje wartość 1.
                //
                // 3. W przeciwnym wypadku zmienna '$status' pryjmuje wartość 0.
                //
                // 4. Tworzę zapytanie SQL dodające nowy wiersz do bazy danych
                //
                // 5. Jeżeli zapytanie zostało wykonane pomyślnie, wyświetlam odpowiedni komunikat i przekierowuję użytkownika
                //    do głównego okna panelu CMS.
                //
                // 6. W przeciwnym wypadku wyświetlam komunikat o błędzie.

                if(isset($_POST["confirm"])) {
                    $content = $_POST['content'];
                    $title = $_POST['title'];

                    if(isset($_POST['status'])){
                        $status = 1;
                    }
                    else {
                        $status = 0;
                    }
                    $query_create="INSERT INTO page_list (page_title, page_content, status) VALUES ('$title', '$content', $status)";
                    if($page_info = mysqli_query($connection, $query_create)){
                        echo '
                        <script type="text/javascript">
                            window.alert("Strona została utworzona.")
                        </script>
                        ';
                        header('Location: CMS.php');
                        exit();
                    }
                    else {
                        echo '
                        <script type="text/javascript">
                            window.alert("Wystąpił błąd")
                        </script>
                        ';
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>



