<?php

    //-----------------------------//
    //     6. PLIK EDIT.PHP        //
    //-----------------------------//

    //-----------------------------------------------------------------------//
    //     6.1. Plik edit.php - Edycja strony istniejącej w bazie danych     //
    //-----------------------------------------------------------------------//

    // Rozpoczynamy sesję przeglądarki, dzięki temu możemy korzystać ze zmiennych sesji
    // utworzonych w innych obszarach systemu niezależnie od tego gdzie się aktualnie znajdujemy.

    session_start();

    include 'admin.php';
    include '../cfg.php';
    
    //-----------------------------------------//
    //     6.2. Odpowiednie przekierowanie     //
    //-----------------------------------------//

    // Warunek blokujący dostęp do okna edycji istniejącej strony użytkownikom niezalogowanym: 
    // na przykład kiedy użytkownik postanowi wpisać ręcznie adres strony 'edit.php' bez wcześniejszego
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
        <div class="logowanie edit-form">
            <?php

                //-----------------------------------//
                //     6.3. Powrót do panelu CMS     //
                //-----------------------------------//

                // Po naciśnięciu przycisku 'Anuluj' system przekieruje użytkownika spowrotem do panelu CMS i likwiduje zmienną sesji
                // zawierającą id strony, którą chcmey edytować.

                if(isset($_POST["cancel"])){
                    unset($_SESSION['id_edit']);
                    header('Location: CMS.php');
                    exit();
                }

                
                //----------------------------------------//
                //     6.4. Edycja istniejącej strony     //
                //----------------------------------------//

                // Sposób działania:
                //
                // 1. Jeżeli zmienna sesji '$_SESSION['id_edit']' nie istnieje, to wyświetlam komunikat o błędzie.
                //
                // 2. W przeciwnym wypadku zmienna '$id' przyjmuje wartość zmiennej sesji '$_SESSION['id_edit']'.
                //
                // 3. Tworzę zapytanie SQL pobierające kontent oraz tytuł strony o id równemu zmiennej '$id'.
                //
                // 4. Wyświetlam formularz zawierający pola: 
                //    4.1 Tytuł: Domyślna wartość pola to aktualny tytuł strony
                //    4.2 Treść: Domyślna wartość pola to aktualna treść strony
                //    4.3 Czy aktywna: (Pole typu radio, które determinuje czy artykuł będzie wyświetlany w menu rozwijanym)
                //    Oraz dwa przyciski: 'Zatwierdź zmiany' i 'Anuluj'.
                //
                // 5. Jeżeli Naciśnięto przycisk 'Zatwierdź zmiany' nowe wartość pól Tytuł i Treść zostają zapisane.
                //
                //    w zmiennych '$new_content' i '$new_title'.
                // 6. Jeżeli pole typu radio zostało zaznaczone, to zmienna '$status' pryjmuje wartość 1.
                //
                // 7. W przeciwnym wypadku zmienna '$status' pryjmuje wartość 0.
                //
                // 8. Tworzę zapytanie SQL edytujące istniejący wiersz w bazie danych.
                //
                // 9. Jeżeli zapytanie zostało wykonane pomyślnie, wyświetlam odpowiedni komunikat i likwiduje zmienną sesji
                //    zawierającą id strony, którą chcmey edytować.
                //
                // 10. W przeciwnym wypadku wyświetlam komunikat o błędzie.


                if(isset($_SESSION['id_edit'])){

                    $id = $_SESSION['id_edit'];

                    $query="SELECT * FROM page_list WHERE id = $id LIMIT 1";
                    $page_info = mysqli_query($connection, $query);
                    $page_info = mysqli_fetch_array($page_info);
                    $old_title = $page_info[1];

                    echo '<h4>Okno edycji strony: '.$old_title.'</h4>';

                    $old_content = $page_info[2];

                    echo '
                    <form method="post" name="EditForm" enctype="multipart/form-data" action="">
                        <table>    
                            <tr><td>Tytuł: </td><td><input type="text" name="new_title" value="'.$old_title.'"/></td></tr>
                            <tr><td>Treść: </td><td><textarea cols="100" rows="30" name="new_content">'.$old_content.'</textarea></td></tr
                            <tr><td>Czy aktywna? </td><td><input type="checkbox" name="status"/></td></tr>
                            <tr><td><input type="submit" name="confirm" value="Zatwierdź zmiany"/></td>
                            <td><input type="submit" name="cancel" value="Anuluj"/></td></tr>
                        </table>
                     </form>
                    ';

                    if(isset($_POST["confirm"])){

                        $new_content = $_POST['new_content'];
                        $new_title = $_POST['new_title'];

                        if(isset($_POST['status'])){
                            $status = 1;
                        }
                        else {
                            $status = 0;
                        }
                        $query_update="UPDATE page_list SET page_title='$new_title', page_content='$new_content', status=$status WHERE id=$id LIMIT 1";
                        if($page_info = mysqli_query($connection, $query_update)){
                            echo '
                            <script type="text/javascript">
                                window.alert("Dokonano modyfikacji strony.")
                            </script>
                            ';
                            unset($_SESSION['id_edit']);
                        }
                        else {
                            echo '
                            <script type="text/javascript">
                                window.alert("Wystąpił błąd")
                            </script>
                            ';
                        }

                    }
                }
                else {
                    echo 'Wystąpił błąd podczas pobierania id strony.';
                }
            ?>
        </div>
    </div>
</body>
</html>