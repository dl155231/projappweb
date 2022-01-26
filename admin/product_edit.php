<?php

session_start();

include 'admin.php';
include '../cfg.php';

if (!isset($_SESSION['logged_in'])) {
    echo 'Dostęp zabroniony';
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


        if (isset($_POST["cancel"])) {
            unset($_SESSION['id_product_edit']);
            header('Location: product_panel.php');
        }


        if (isset($_SESSION['id_product_edit'])) {

            $id = $_SESSION['id_product_edit'];

            $query = "SELECT * FROM products WHERE id = $id LIMIT 1";
            $product_info_query = mysqli_query($dblink, $query);
            $product_info = mysqli_fetch_array($product_info_query);

            $query_category = "SELECT * FROM categories WHERE mother IS NOT NULL LIMIT 100";
            $result_category = mysqli_query($dblink, $query_category);

            $old_name = $product_info[1];
            $old_category = $product_info[2];
            $old_desc = $product_info[3];
            $old_price = $product_info[4];
            $old_amount = $product_info[5];

            echo '<h4>Okno edycji produktu: ' . $old_name . '</h4>';

            echo '<form id="editform" method="post" name="CategoryEditForm" enctype="multipart/form-data" action="">
                        <table>    
                            <tr>
                                <td>
                                    <label for="id_new_name">Nazwa produktu:</label>
                                </td>
                                <td>
                                    <input class="form-control" id="id_new_name" type="text" name="new_name" value="' . $old_name . '"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="id_category">Kategoria:</label>
                                </td>    
                                <td>
                                    <select class="form-select" id="id_category" name="categorylist" form="editform">
                                        <option value="' . $old_category . '">' . $old_category . '</option>';

            while ($row_category = mysqli_fetch_array($result_category)) {
                echo '<option value="' . $row_category[1] . '">' . $row_category[1] . '</option>';
            }

            echo '  </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="id_new_desc">Opis:</label> 
                </td>
                <td>
                    <textarea class="form-control" id="id_new_desc" cols="50" rows="10" name="new_desc">' . $old_desc . '</textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="id_new_price">Cena:</label>
                </td>
                <td>
                    <input class="form-control" id="id_new_price" type="number" name="new_price" step="0.01" value="' . $old_price . '"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="id_new_amount">Ilość:</label>
                </td>
                <td>
                    <input class="form-control" id="id_new_amount" type="number" name="new_amount" value="' . $old_amount . '"/>
                </td>
            </tr>';

            echo '<tr>
                    <td>
                        <label for="id_new_availability">Dostępny:</label>
                    </td>
                    <td>
                        <input type="checkbox" id="id_new_availability" name="new_availability" ' . ($old_amount ? 'checked' : '') . '/>
                    </td>
                </tr>';

            echo '  <tr>
                        <td>
                            <input class="btn btn-primary" type="submit" name="confirm" value="Zatwierdź zmiany"/>
                        </td>
                        <td>
                            <input class="btn btn-danger" type="submit" name="cancel" value="Anuluj"/>
                        </td>
                    </tr>
                </table>
            </form>';

            if (isset($_POST["confirm"])) {

                if (isset($_POST["new_availability"])) {
                    $new_availability = 1;
                } else  $new_availability = 0;


                $new_name = $_POST["new_name"];
                $new_category = $_POST["categorylist"];
                $new_desc = $_POST["new_desc"];
                $new_price = $_POST["new_price"];
                $new_amount = $_POST["new_amount"];
                $query_update_product = "UPDATE products SET name='$new_name', category='$new_category', description='$new_desc', price=$new_price, amount=$new_amount WHERE id=$id";

                if ($product_update_query = mysqli_query($dblink, $query_update_product)) {
                    unset($_SESSION['id_product_edit']);
                } else echo '<script type="text/javascript">
                                window.alert("Wystąpił błąd")
                            </script>';
            }
        } else echo 'Wystąpił błąd podczas pobierania id produktu.';

        ?>
    </div>
    </div>
</body>

</html>