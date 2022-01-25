<?php

session_start();

include 'admin.php';
include '../cfg.php';

if (!isset($_SESSION['login'])) {
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

        if (isset($_POST["cancel"])) {
            header('Location: product_panel.php');
            exit();
        }
        $query_category = "SELECT * FROM categories WHERE mother IS NOT NULL LIMIT 100";
        $result_category = mysqli_query($dblink, $query_category);

        echo '<h1>Okno tworzenia produktu</h1>';

        echo '
            <form id="editform" method="post" name="CategoryEditForm" enctype="multipart/form-data" action="">
                <table>    
                    <tr>
                        <td>
                            <label for="id_new_name">Nazwa produktu:</label>
                        </td>
                        <td>
                        <input id="id_new_name" type="text" name="new_name" value="nazwa produktu"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <label for="product-categories">Opis produktu:</label> 
                    </td>    
                    <td>
                    <select id="product-categories" name="categorylist" form="editform">
                ';

        while ($row_category = mysqli_fetch_array($result_category)) {
            echo '<option value="' . $row_category[1] . '">' . $row_category[1] . '</option>';
        }

        echo '</select>
            </td>
        </tr>';

        echo '
            <tr>
            <td>
                <label for="id_new_desc">Opis produktu: </label>
            </td>
            <td>
                <textarea id="id_new_desc" cols="50" rows="10" name="new_desc">Opis</textarea>
            </td>
            </tr>
            <tr>
                <td>
                    <label for="id_new_price">Cena produktu:</label>
                </td>
                <td>
                    <input id="id_new_price" type="number" name="new_price" step="0.01" value="0" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="id_new_amount">Liczba sztuk:</label> 
                </td>
                <td>
                    <input id="id_new_amount" type="number" name="new_amount" value="1" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="id_new_availability">Dostępność:</label>
                </td>
                <td>
                    <input id="id_new_availability" type="checkbox" name="new_availability" checked />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="confirm" value="Utwórz produkt" />
                </td>
                <td>
                    <input type="submit" name="cancel" value="Anuluj" />
                </td>
            </tr>';
        echo '
                    </table>
                </form>
                ';

        if (isset($_POST["confirm"])) {

            if (isset($_POST["new_availability"])) {
                $new_availability = 1;
            } else {
                $new_availability = 0;
            }

            $new_name = $_POST["new_name"];
            $new_category = $_POST["categorylist"];
            $new_desc = $_POST["new_desc"];
            $new_price = $_POST["new_price"];
            $new_amount = $_POST["new_amount"];

            $query_create_product = "INSERT INTO products (name, category, description, price, amount, availability)
                     VALUES ('$new_name', '$new_category', '$new_desc', $new_price, $new_amount, $new_availability)";

            if ($product_create_query = mysqli_query($dblink, $query_create_product)) {

                unset($_SESSION['id_create_product']);
                header('Location: product_panel.php');
            } else {
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