<?php

if (!isset($_SESSION['cart'])) {
    $query_delete = "DELETE * FROM cart";

    if ($delete = mysqli_query($dblink, $query_delete)) {
        echo '';
    } else {
        echo '';
    }
}

$query = "SELECT * FROM cart ORDER BY id DESC LIMIT 100";
$result = mysqli_query($dblink, $query);

while ($row = mysqli_fetch_array($result)) {
    echo '<div>
    <img  src="img/obraz' . $row[0] . '.jpg" style="height: 225px;">
                <div>
                    <ul>
                        <li><b>Nazwa:</b> ' . $row[1] . '</li>
                        <li><b>Ilość:</b> ' . $row[2] . '</li>
                        <li><b>Cena:</b> ' . $row[3] . '</li>
                    </ul>
                </div>
                <form method="post" name="product_form" enctype="multipart/form-data" action="">
                    <div>
                        <label for="product-number">Ilość produktu:</label>
                        <input class="form-control" style="width: 75px;" id="id_amount" type="number" name="value" value="' . $row[2] . '"/>

                        <input type="hidden" name="product-id" value="' . $row[0] . '"/>

                        <input class="btn btn-danger" type="submit" name="remove" value="Usuń z koszyka"/>
                        <input class="btn btn-primary" type="submit" name="confirm" value="Aktualizuj ilość"/>
                    </div>
                </form>
            </div>';
}


if (isset($_POST['confirm'])) {
    $id = $_POST['product-id'];

    $new_amount = $_POST['value'];

    $query_price = "SELECT price FROM products WHERE id=$id";
    $result_price = mysqli_query($dblink, $query_price) or die(mysqli_error($dblink));
    $row_price = mysqli_fetch_array($result_price);

    $new_price = $row_price[0] * $new_amount;

    $query_update_cart = "UPDATE cart SET amount=$new_amount, price=$new_price WHERE id=$id";
    if ($query_update_cart_result = mysqli_query($dblink, $query_update_cart)) {
        echo '<script type="text/javascript">
                window.alert("Koszyk został zaktualizowany.");
            </script>';
            header('Location: index.php?page=Koszyk');
    } else echo '<script type="text/javascript">
                    window.alert("Wystąpił błąd")
                </script>';
    
}

$total_price = "SELECT sum(price) from cart";
$result_price = mysqli_query($dblink, $total_price);

$row_price = mysqli_fetch_array($result_price);
$total_price_row = $row_price[0];
echo '<p style="text-align:right;">Cena całkowita: ' . $total_price_row . '</p>';

?>

<div>
    <form method="post" name="product_form" enctype="multipart/form-data" action="">
        <div class="button-and-amount">
            <input class="btn btn-danger" type="submit" name="clear" value="Wyczyść koszyk" />
            <input class="btn btn-success" type="submit" name="pay" value="Zapłać za zakupy" />
        </div>
    </form>
</div>

<?php

if (isset($_POST['clear'])) {

    $query_delete = "DELETE FROM cart";

    if ($delete = mysqli_query($dblink, $query_delete)) {
        echo '<script type="text/javascript">
                window.alert("Koszyk został opróżniony")
            </script>';
    } else echo '<script type="text/javascript">
                    window.alert("Wystąpił błąd")
                </script>';
    
}

if (isset($_POST['pay'])) {
    $query = "SELECT * FROM cart ORDER BY id DESC LIMIT 100";
    $result = mysqli_query($dblink, $query);

    while ($row = mysqli_fetch_array($result)) {
        $amount = $row[2];
        $id = $row[0];
        $queryold = "SELECT amount FROM products WHERE id=$id";
        $old_amount = mysqli_query($dblink, $queryold);
        $old_row = mysqli_fetch_array($old_amount);
        $new_amount = $old_row[0] - $amount;
        $update_product = "UPDATE products SET amount=$new_amount WHERE id=$id";
        if ($update_query = mysqli_query($dblink, $update_product)) {
        } else echo 'Wystąpił błąd.';
        
    }
    $query_delete = "DELETE FROM cart";

    if ($delete = mysqli_query($dblink, $query_delete)) {
        echo '<script type="text/javascript">
                window.alert("Dokonano zakupu")
            </script>';
    } else echo 'Wystąpił błąd rzy płatności.';
    
}

if (isset($_POST['remove'])) {
    $id = $_POST['product-id'];
    $query_delete = "DELETE FROM cart WHERE id=$id";

    if ($delete = mysqli_query($dblink, $query_delete)) {
        echo '
                <script type="text/javascript">
                    window.alert("Produkt został usunięty z koszyka")
                </script>
                ';
    } else echo '<script type="text/javascript">
                    window.alert("Wystąpił błąd")
                </script>';
    
}
?>