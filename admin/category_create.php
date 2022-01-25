<?php

    session_start();

    include 'admin.php';
    include '../cfg.php';

    if (!isset($_SESSION['login'])){
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
                    header('Location: panel.php');
                    exit();
                }
                
                $queryMother="SELECT * FROM categories WHERE mother IS NULL LIMIT 100";
                $resultMother = mysqli_query($dblink, $queryMother);

                echo '<h4>Okno Tworzenia Kategorii</h4>
                <table>
                <form id="createform" method="post" name="EditForm" enctype="multipart/form-data" action="">
                    <tr><td>Nazwa kategorii: </td><td><input type="text" name="name" value="nazwa kategorii"/></td></tr>
                    <tr><td>Nadkategoria: </td>
                    <td>
                    <select id="mother-categories" name="motherlist" form="createform">
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
                    <tr><td><input type="submit" name="confirm" value="Dodaj kategorię do bazy danych"></td>
                    <td><input type="submit" name="cancel" value="Anuluj"></td></tr>
                 </form>
                 </table>
                ';

                if(isset($_POST["confirm"])) {
                    $name = $_POST['name'];
                    $mother = $_POST['motherlist'];

                    if(!isset($_POST['name'])){
                        echo '
                        <script type="text/javascript">
                            window.alert("Podaj nazwę kategorii")
                        </script>
                        ';
                    }
                    else {
                        if($mother==''){
                            $query_create="INSERT INTO categories (name, mother) VALUES ('$name', NULL)";
                        }
                        else{
                            $query_create="INSERT INTO categories (name, mother) VALUES ('$name', '$mother')";                            
                        }
                        if($category_info = mysqli_query($dblink, $query_create)){
                            echo '
                            <script type="text/javascript">
                                window.alert("Kategoria została utworzona.")
                            </script>
                            ';
                            header('Location: panel.php');
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
                }
            ?>
        </div>
    </div>
</body>
</html>



