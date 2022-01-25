<?php

    session_start();

    include 'admin.php';
    include '../cfg.php';

    if (!isset($_SESSION['logged_in'])){
        header('Location: ../index.php?idp=zaloguj');
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
                    unset($_SESSION['id_category_edit']);
                    header('Location: panel.php');
                    exit();
                }


                if($_SESSION['id_category_edit']){

                    $id = $_SESSION['id_category_edit'];

                    $query="SELECT * FROM categories WHERE id = $id LIMIT 1";
                    $category_info_query = mysqli_query($dblink, $query) or die(mysqli_error($dblink));
                    $category_info = mysqli_fetch_array($category_info_query);
                    $old_name = $category_info[1];
                    $old_mother = $category_info[2];
                    $queryMother="SELECT * FROM categories WHERE mother IS NULL LIMIT 100";
                    $resultMother = mysqli_query($dblink, $queryMother);

                    echo '<h4>Okno edycji kategorii: '.$old_name.'</h4>';

                    echo '
                    <form id="editform" method="post" name="CategoryEditForm" enctype="multipart/form-data" action="">
                        <table>    
                            <tr><td>Nazwa kategorii: </td><td><input type="text" name="new_name" value="'.$old_name.'"/></td></tr>
                            <tr><td>Kategoria matka: </td>    
                            <td>
                            <select id="mother-categories" name="motherlist" form="editform">
                                <option value="">Brak</option>
                        ';
                                
                        while($rowMother = mysqli_fetch_array($resultMother)){
                            echo '
                                <option value="'.$rowMother[1].'">'.$rowMother[1].'</option>
                            ';
                        }
                        echo '
                            </select>
                            </td>
                            </tr>
                            <tr><td><input class="btn btn-custom" type="submit" name="confirm" value="Zatwierdź zmiany"/></td>
                            <td><input class="btn btn-custom" type="submit" name="cancel" value="Anuluj"/></td></tr>
                        </table>
                     </form>
                    ';

                    if(isset($_POST["confirm"])){

                        $new_name = $_POST['new_name'];
                        $new_mother =  $_POST['motherlist'];

                        if($new_mother == ''){
                            $query_update="UPDATE categories SET name='$new_name', mother=NULL WHERE id=$id LIMIT 1";
                        }
                        else {
                            $query_update="UPDATE categories SET name='$new_name', mother='$new_mother' WHERE id=$id LIMIT 1";
                        }

                        $query_update_subcategories="UPDATE categories SET mother='$new_name' WHERE mother='$old_name'";
                        if($category_info_query = mysqli_query($dblink, $query_update)){
                            if($category_info_query2 = mysqli_query($dblink, $query_update_subcategories)){
                                echo '
                                <script type="text/javascript">
                                    window.alert("Dokonano modyfikacji kategorii.")
                                </script>
                                ';
                                unset($_SESSION['id_category_edit']);
                                
                                header('Location: panel.php');
                            }
                            else {
                                echo '
                                <script type="text/javascript">
                                    window.alert("Wystąpił błąd")
                                </script>
                                ';
                            }
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
                    echo 'Wystąpił błąd podczas pobierania id kategorii.';
                }
            ?>
        </div>
    </div>
</body>
</html>