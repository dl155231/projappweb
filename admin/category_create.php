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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Panel Sklepu</title>
</head>
<body style="min-height: 100Vh;">
    <div class="edit-content">
        <div class="logowanie">
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
                    <tr><td>Kategoria-Matka: </td>
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



