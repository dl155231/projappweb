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
    echo '
                
                <div class="product">
                <svg class="product-image column" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 100 100" height="100px" viewBox="0 0 24 24" width="100px" fill="#000000"><g><rect fill="none" height="100" width="100"/></g><g><g><path d="M20,2H4C3,2,2,2.9,2,4v3.01C2,7.73,2.43,8.35,3,8.7V20c0,1.1,1.1,2,2,2h14c0.9,0,2-0.9,2-2V8.7c0.57-0.35,1-0.97,1-1.69V4 C22,2.9,21,2,20,2z M19,20H5V9h14V20z M20,7H4V4h16V7z"/><rect height="2" width="6" x="9" y="12"/></g></g></svg>
                    <div class="column">
                        <ul>
                            <li><b>Nazwa:</b> ' . $row[1] . '</li>
                            <li><b>Ilość:</b> ' . $row[2] . '</li>
                            <li><b>Cena:</b> ' . $row[3] . '</li>
                        </ul>
                    </div>
                    <form class="column" method="post" name="product_form" enctype="multipart/form-data" action="">
                        <div class="button-and-amount">
                            <label for="product-number">Ilość produktu:</label>
                            <input id="product-number" type="number" name="value" value="' . $row[2] . '"/>
                            <input class="product-id" type="hidden" name="product-id" value="' . $row[0] . '"/>
                            <input class="add-to-cart" type="submit" name="remove" value="Usuń z koszyka"/>
                            <input class="clear-cart" type="submit" name="confirm" value="Aktualizuj ilość"/>
                        </div>
                    </form>
                </div>
            ';
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
        echo '
                    <script type="text/javascript">
                        window.alert("Koszyk został zaktualizowany.");
                    </script>
                    ';
    } else {
        echo '
                    <script type="text/javascript">
                        window.alert("Wystąpił błąd")
                    </script>
                    ';
    }
}

$total_price = "SELECT sum(price) from cart";
$result_price = mysqli_query($dblink, $total_price);

$row_price = mysqli_fetch_array($result_price);
$total_price_row = $row_price[0];
echo '<p style="text-align:right;">Cena całkowita: ' . $total_price_row . '</p>';



?>

<div class="finish">
    <form class="column" method="post" name="product_form" enctype="multipart/form-data" action="">
        <div class="button-and-amount">
            <input class="clear-cart" type="submit" name="clear" value="Wyczyść koszyk" />
            <input class="pay-for-cart" type="submit" name="pay" value="Zapłać za zakupy" />
        </div>
    </form>
</div>

<?php

if (isset($_POST['clear'])) {

    $query_delete = "DELETE FROM cart";

    if ($delete = mysqli_query($dblink, $query_delete)) {
        echo '
                <script type="text/javascript">
                    window.alert("Koszyk został opróżniony")
                </script>
                ';
    } else {
        echo '
                <script type="text/javascript">
                    window.alert("Wystąpił błąd")
                </script>
                ';
    }
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
            echo 'wszystko git';
        } else {
            echo 'Wystąpił błąd1';
        }
    }
    $query_delete = "DELETE FROM cart";

    if ($delete = mysqli_query($dblink, $query_delete)) {
        echo '
                <script type="text/javascript">
                    window.alert("Dokonano zakupu")
                </script>
                ';
    } else {
        echo 'Wystąpił błąd2';
    }
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
    } else {
        echo '
                <script type="text/javascript">
                    window.alert("Wystąpił błąd")
                </script>
                ';
    }
}
?>