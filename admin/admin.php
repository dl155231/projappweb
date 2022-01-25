<?php

if (!isset($_SESSION['login']))
    session_start();

include '../cfg.php';

function ListaPodstron($dblink)
{
    if (isset($_SESSION)) {

        $query = "SELECT * FROM page_list ORDER BY id ASC LIMIT 100";
        $result = mysqli_query($dblink, $query);

        echo '<table class="page-list">';
        while ($row = mysqli_fetch_array($result)) {
            echo '
                    <tr><td class="list-id">' . $row['id'] . '</td><td>' . $row['page_title'] . '
                    <td><a class="edit" href="CMS.php?id=' . $row['id'] . '">Edytuj</a></td>
                    <td><a class="delete" href="CMS.php?id_delete=' . $row['id'] . '">Usuń</a></td>
                    <tr><td colspan="4"><hr></hr></td></tr>
                ';
        }
        echo '</table>';
    } else echo "Funkcjonalność dostępna wyłącznie po zalogowaniu";
}
function Zaloguj($login, $password, $admin_login, $admin_passwd)
{
    if ($login and $password) {
        if (($login == $admin_login) && (md5($password) == md5($admin_passwd))) {
            return 1;
        } else {
            return 0;
        }
    } else
        return 0;
}

function EdytujPodstrone($id)
{
    $id_clear = htmlspecialchars($id);
    $_SESSION['id'] = $id_clear;
    header('Location: page_edit.php');
}
function UsunPodstrone($id, $dblink)
{
    $id_clear = htmlspecialchars($id);

    $query = "SELECT * FROM page_list WHERE id = $id LIMIT 1";
    $page_info = mysqli_query($dblink, $query);
    $page_info = mysqli_fetch_array($page_info);
    $title = $page_info[1];

    $query_delete = "DELETE FROM page_list WHERE id=$id_clear LIMIT 1";

    if ($delete = mysqli_query($dblink, $query_delete)) {
        echo '
                <script type="text/javascript">
                    window.alert("Usunięto stronę ' . $title . '")
                </script>
                ';
    } else {
        echo '
                <script type="text/javascript">
                    window.alert("Wystąpił błąd przy próbie usunięcia strony nr ' . $title . '")
                </script>
                ';
    }
}

function ListaKategorie($dblink)
{
    if (isset($_SESSION)) {

        $queryMother = "SELECT * FROM categories WHERE category_mother IS NULL LIMIT 100";
        $resultMother = mysqli_query($dblink, $queryMother);

        echo '<table class="category-list">';
        while ($rowMother = mysqli_fetch_array($resultMother)) {
            echo '
                    <tr>
                    <td>' . $rowMother['category_name'] . '</td>
                    <td><a class="edit" href="shop_panel.php?id_category=' . $rowMother['id'] . '">Edytuj</a></td>
                    <td><a class="delete" href="shop_panel.php?id_delete_category=' . $rowMother['id'] . '">Usuń</a></td>
                    </tr>
                    <tr><td colspan="3"><hr></hr></td></tr>
                ';
            $mother = $rowMother['category_name'];
            $querySubCategories = "SELECT * FROM categories WHERE category_mother='$mother' LIMIT 100";
            $resultSubCategories = mysqli_query($dblink, $querySubCategories);
            echo '<tr><td></td>';
            echo '<td colspan="3">';
            echo '<table class="category-list">';
            while ($rowSubCategories = mysqli_fetch_array($resultSubCategories)) {
                echo '
                    <tr>
                    <td>' . $rowSubCategories['category_name'] . '
                    <td><a class="edit" href="shop_panel.php?id_category=' . $rowSubCategories['id'] . '">Edytuj</a></td>
                    <td><a class="delete" href="shop_panel.php?id_delete_category=' . $rowSubCategories['id'] . '">Usuń</a></td>
                    </tr>
                    <tr><td colspan="3"><hr></hr></td></tr>
                    ';
            }
            echo '</td>';
            echo '</tr>';
            echo '</table>';
        }
        echo '</table>';
    } else echo "Funkcjonalność dostępna wyłącznie po zalogowaniu";
}

function ListaProdukty($dblink)
{
    if (isset($_SESSION)) {

        $query = "SELECT * FROM products LIMIT 100";
        $result = mysqli_query($dblink, $query);

        echo '<table class="page-list">';
        echo '<tr><th>ID</th><th>NAZWA</th><th>KATEGORIA</th><th>CENA NETTO</th><th>ILOŚĆ DOSTĘPNYCH SZTUK</th></tr>';
        while ($row = mysqli_fetch_array($result)) {
            echo '
                    <tr><td class="list-id">' . $row['id'] . '</td><td>' . $row['nazwa'] . '</td><td>' . $row['kategoria'] . '</td>
                    <td>' . $row['cena_netto'] . '</td><td>' . $row['ilosc_sztuk'] . '</td>
                    <td><a class="edit" href="product_panel.php?id_product=' . $row['id'] . '">Edytuj</a></td>
                    <td><a class="delete" href="product_panel.php?id_delete_product=' . $row['id'] . '">Usuń</a></td>
                    <tr><td colspan="7"><hr></hr></td></tr>
                ';
        }
        echo '</table>';
    } else echo "Funkcjonalność dostępna wyłącznie po zalogowaniu";
}

function UsunKategorie($id, $dblink)
{
    $id_clear = htmlspecialchars($id);

    $query = "SELECT * FROM categories WHERE id = $id LIMIT 1";
    $category_info_query = mysqli_query($dblink, $query);
    $category_info = mysqli_fetch_array($category_info_query);
    $name = $category_info[1];

    $query_delete = "DELETE FROM categories WHERE id=$id_clear LIMIT 1";

    if ($delete = mysqli_query($dblink, $query_delete)) {
        echo '
                <script type="text/javascript">
                    window.alert("Usunięto kategorię ' . $name . '")
                </script>
                ';
    } else {
        echo '
                <script type="text/javascript">
                    window.alert("Wystąpił błąd przy próbie usunięcia kategorii ' . $name . '")
                </script>
                ';
    }
}

function EdytujKategorie($id)
{
    $id_clear = htmlspecialchars($id);
    $_SESSION['id_category'] = $id_clear;
    header('Location: edit_category.php');
}

function EdytujProdukt($id)
{
    $id_clear = htmlspecialchars($id);
    $_SESSION['id_product'] = $id_clear;
    header('Location: edit_product.php');
}

function UsunProdukt($id, $dblink)
{
    $id_clear = htmlspecialchars($id);

    $query = "SELECT * FROM products WHERE id = $id LIMIT 1";
    $product_info_query = mysqli_query($dblink, $query);
    $product_info = mysqli_fetch_array($product_info_query);
    $name = $product_info[1];

    $query_delete = "DELETE FROM products WHERE id=$id_clear LIMIT 1";

    if ($delete = mysqli_query($dblink, $query_delete)) {
        echo '<script type="text/javascript">window.alert("Usunięto produkt ' . $name . '")</script>';
    } else {
        echo '<script type="text/javascript">window.alert("Wystąpił błąd przy próbie usunięcia kategorii ' . $name . '")</script>';
    }
}

if (isset($_GET['id'])) {
    EdytujPodstrone($_GET['id'], $dblink);
}
if (isset($_GET['id_delete'])) {
    UsunPodstrone($_GET['id_delete'], $dblink);
}
if (isset($_GET['id_category'])) {
    EdytujKategorie($_GET['id_category'], $dblink);
}
if (isset($_GET['id_delete_category'])) {
    UsunKategorie($_GET['id_delete_category'], $dblink);
}
if (isset($_GET['id_product'])) {
    EdytujProdukt($_GET['id_product'], $dblink);
}
if (isset($_GET['id_delete_product'])) {
    UsunProdukt($_GET['id_delete_product'], $dblink);
}
?>
</body>

</html>