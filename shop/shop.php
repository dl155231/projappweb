<div class="shop">

    <?php
    if (!isset($_SESSION['cart'])) {
        $query_delete = "DELETE * FROM koszyk";

        if ($delete = mysqli_query($dblink, $query_delete)) {
            echo '';
        } else {
            echo '';
        }
    }

    $query = "SELECT * FROM products LIMIT 100";
    $result = mysqli_query($dblink, $query);

    while ($row = mysqli_fetch_array($result)) {
        echo '
            <div>
                <div>
                    <img src="img/obraz'.$row[0].'.jpg"

                    <ul>
                        <li><b>Nazwa:</b> ' . $row[1] . '</li>
                        <li><b>Kategoria:</b> ' . $row[2] . '</li>
                        <li><b>Opis:</b> ' . $row[3] . '</li>
                        <li><b>Cena:</b> ' . $row[4] . '</li>
                        <li><b>Dostępnych sztuk:</b> ' . $row[5] . '</li>
                    </ul>
                </div>
                <form method="post" name="product_form" enctype="multipart/form-data" action="">
                    <div>
                        <label for="id_amount">Ilość:</label>
                        <input class="form-control" style="width: 75px;" id="id_amount" type="number" name="value" value="1"/>

                        
                        <input class="btn btn-primary" type="submit" name="confirm" value="Dodaj do koszyka"/>
                        <input type="hidden" name="product-id" value="' . $row[0] . '"/>
                    </div>
                </form>
            </div>
        ';
    }
    // <a href="index.php?page=Sklep&product='.$row[0].'">Dodaj do koszyka</a>
    if (isset($_POST['confirm'])) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = 1;
        }
        $product_id = $_POST['product-id'];
        $id = htmlspecialchars($product_id);
        $amount = $_POST['value'];

        $query_amount = "SELECT amount, price, name FROM products WHERE id=$id";
        $result_amount = mysqli_query($dblink, $query_amount);
        $row_amount = mysqli_fetch_array($result_amount);

        if ($row_amount[0] < $amount) {
            echo '
                <script>
                    window.alert("Brak odpowiedniej ilości sztuk produktów w magazynie - aktualny stan: ' . $row_amount[0] . '")
                </script>
                ';
        } else if ($row_amount[0] == 0) {
            echo '
                <script>
                    window.alert("Produkt chwilowo niedostępny")
                </script>
                ';
        } else {
            $check = "SELECT * FROM cart WHERE id=$id LIMIT 1";
            $check_result = mysqli_query($dblink, $check);
            $check_rows = mysqli_fetch_array($check_result);
            if ($check_rows != 0) {
                $_SESSION[$product_id] = $product_id;
            }
            if (isset($_SESSION[$product_id])) {
                $query_amount = "SELECT amount FROM cart WHERE id=$id";
                $result_amount = mysqli_query($dblink, $query_amount);
                $row_amount2 = mysqli_fetch_array($result_amount);
                $old_amount = $row_amount2[0];
                $new_amount = $old_amount + $amount;
                $new_price = $row_amount[1] * $new_amount;
                $query_update_cart = "UPDATE cart SET amount=$new_amount, price=$new_price WHERE id=$id";
                if ($query_update_cart_result = mysqli_query($dblink, $query_update_cart)) {
                    echo '
                        <script>
                            window.alert("Dodano nowe produkty do koszyka")
                        </script>
                        ';
                } else {
                    echo '
                        <script>
                            window.alert("Wystąpił błąd")
                        </script>
                        ';
                }
            } else {
                $_SESSION[$product_id] = $product_id;
                $name = $row_amount[2];
                $price = $amount * $row_amount[1];
                echo $_SESSION[$product_id];
                echo $name . '</br>';
                echo $price . '</br>';
                echo $amount . '</br>';
                echo $row_amount[1] . '</br>';
                $add_to_cart = "INSERT INTO cart (id, name, amount, price) VALUES ($id, '$name', $amount, $price)";
                if ($query = mysqli_query($dblink, $add_to_cart)) {
                    echo '
                        <script>
                            window.alert("Dodano nowe produkty do koszyka")
                        </script>
                        ';
                } else {
                    echo '
                        <script>
                            window.alert("Wystąpił błąd")
                        </script>
                        ';
                }
            }
        }
    }
    ?>
</div>