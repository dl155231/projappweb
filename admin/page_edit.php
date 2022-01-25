<?php

    session_start();

    include 'admin.php';
    include '../cfg.php';
    
    if (!isset($_SESSION['logged_in'])){
        header('Location: ../index.php?page=Zaloguj');
        exit();
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
    <script src="/www/js/custom.js"></script>
  
  </head>
  
  <body>
    <?php include('../navbar.php'); ?>
    <div class="container" id="content">
            <?php

                if(isset($_POST["cancel"])){
                    unset($_SESSION['id']);
                    header('Location: panel.php');
                    exit();
                }

                if(isset($_SESSION['id'])){

                    $id = $_SESSION['id'];

                    $query="SELECT * FROM page_list WHERE id = $id LIMIT 1";
                    $page_info = mysqli_query($dblink, $query);
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
                        $result_update = mysqli_query($dblink, $query_update) or die(mysqli_error($dblink));
                        if($page_info = mysqli_query($dblink, $query_update)){
                            echo '
                            <script type="text/javascript">
                                window.alert("Dokonano modyfikacji strony.")
                            </script>
                            ';
                            unset($_SESSION['id']);
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