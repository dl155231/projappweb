
<?php

if (!isset($_SESSION['logged_in']))
    session_start();

include '../cfg.php';

function SubpageList($dblink)
{
    if (isset($_SESSION)) {
        $query = "SELECT * FROM page_list ORDER BY id ASC LIMIT 100";
        $result = mysqli_query($dblink, $query);
        echo '<div class="page-list">';
        echo '<table>';
        echo '<tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Edycja</th>
            </tr>';

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['page_title'] . '</td>
                    <td>
                        <a class="btn btn-primary ms-auto" href="panel.php?id=' . $row['id'] . '">Edytuj</a>
                        <a class="btn btn-danger" href="panel.php?id_delete=' . $row['id'] . '">Usuń</a>
                    </td>
                    </tr>
                    <tr>
                        <td colspan="3"><hr></td>
                    </tr>';
        }
        echo '</table>';
        echo '</div>';
    } else echo "Funkcjonalność dostępna wyłącznie po zalogowaniu";
}

function Login($login, $password, $admin_login, $admin_passwd)
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

function PageEdit($id)
{
    $id_clear = htmlspecialchars($id);
    $_SESSION['id'] = $id_clear;
    header('Location: page_edit.php');
}

function PageDelete($id, $dblink)
{
    $id_clear = htmlspecialchars($id);

    $query = "SELECT * FROM page_list WHERE id = $id LIMIT 1";
    $page_info = mysqli_query($dblink, $query);
    $page_info = mysqli_fetch_array($page_info);
    $title = $page_info[1];

    $query_delete = "DELETE FROM page_list WHERE id=$id_clear LIMIT 1";

    if ($delete = mysqli_query($dblink, $query_delete)) {
        echo '<script type="text/javascript">
                window.alert("Usunięto stronę ' . $title . '")
            </script>';
    } else {
        echo '<script type="text/javascript">
                window.alert("Wystąpił błąd przy próbie usunięcia strony nr ' . $title . '")
            </script>';
    }
}

function CategoryList($dblink)
{
    if (isset($_SESSION)) {

        $queryMother = "SELECT * FROM categories WHERE mother IS NULL LIMIT 100";
        $resultMother = mysqli_query($dblink, $queryMother) or die(mysqli_error($dblink));
        echo '<div class="page-list">';
        echo '<table>';
        echo '<tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Edycja</th>
            </tr>';

        while ($rowMother = mysqli_fetch_array($resultMother)) {
            echo '<tr>
                    <td>' . $rowMother['id'] . '</td>
                    <td>' . $rowMother['name'] . '</td>
                    <td>
                        <a class="btn btn-primary" href="panel.php?id_category_edit=' . $rowMother['id'] . '">Edytuj</a>
                        <a class="btn btn-danger" href="panel.php?id_delete_category=' . $rowMother['id'] . '">Usuń</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><hr></td>
                </tr>';

            $mother = $rowMother['name'];
            $querySubCategories = "SELECT * FROM categories WHERE mother='$mother' LIMIT 100";
            $resultSubCategories = mysqli_query($dblink, $querySubCategories);

            echo '<tr> <td></td>';
            echo '<td colspan="3">';
            echo '<table>';

            while ($rowSubCategories = mysqli_fetch_array($resultSubCategories)) {
                echo '<tr>
                        <td>' . $rowSubCategories['name'] . '</td>
                        <td>
                            <a class="btn btn-primary" href="category_edit.php?id_category_edit=' . $rowSubCategories['id'] . '">Edytuj</a>
                            <a class="btn btn-danger" href="panel.php?id_delete_category=' . $rowSubCategories['id'] . '">Usuń</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr></td>
                    </tr>';
            }

            echo '</td>
                </tr>
            </table>';
        }
        echo '</table></div>';
    } else echo "Funkcjonalność dostępna wyłącznie po zalogowaniu";
}

function ProductList($dblink)
{
    if (isset($_SESSION)) {

        $query = "SELECT * FROM products LIMIT 100";
        $result = mysqli_query($dblink, $query);
        echo '<div class="page-list">';
        echo '<table>';
        echo '<tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Kategoria</th>
                <th>Cena</th>
                <th>Dostępne sztuki</th>
                <th>Edycja</th>
            </tr>';

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr>
                    <td class="list-id">' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td><td>' . $row['category'] . '</td>
                    <td>' . $row['price'] . '</td><td>' . $row['amount'] . '</td>
                    <td>
                        <a class="btn btn-primary" href="product_panel.php?id_product_edit=' . $row['id'] . '">Edytuj</a>
                        <a class="btn btn-danger" href="product_panel.php?id_product_delete=' . $row['id'] . '">Usuń</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="6"><hr></td>
                </tr>';
        }
        echo '</table>';
        echo '</div>';
    } else echo "Funkcjonalność dostępna wyłącznie po zalogowaniu";
}

function CategoryDelete($id, $dblink)
{
    $id_clear = htmlspecialchars($id);

    $query = "SELECT * FROM categories WHERE id = $id LIMIT 1";
    $category_info_query = mysqli_query($dblink, $query);
    $category_info = mysqli_fetch_array($category_info_query);
    $name = $category_info[1];

    $query_delete = "DELETE FROM categories WHERE id=$id_clear LIMIT 1";

    if ($delete = mysqli_query($dblink, $query_delete)) {
        echo '<script type="text/javascript">
                window.alert("Usunięto kategorię ' . $name . '")
            </script>';
    } else {
        echo '<script type="text/javascript">
                window.alert("Wystąpił błąd przy próbie usunięcia kategorii ' . $name . '")
            </script>';
    }
}

function CategoryEdit($id)
{
    $id_clear = htmlspecialchars($id);
    $_SESSION['id_category_edit'] = $id_clear;
    header('Location: category_edit.php');
}

function ProductEdit($id)
{
    $id_clear = htmlspecialchars($id);
    $_SESSION['id_product_edit'] = $id_clear;
    header('Location: product_edit.php');
}

function ProductDelete($id, $dblink)
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
        echo '<script type="text/javascript">window.alert("Wystąpił błąd przy próbie usunięcia produktu ' . $name . '")</script>';
    }
}

if (isset($_GET['id'])) {
    PageEdit($_GET['id'], $dblink);
}
if (isset($_GET['id_delete'])) {
    PageDelete($_GET['id_delete'], $dblink);
}
if (isset($_GET['id_category_edit'])) {
    CategoryEdit($_GET['id_category_edit'], $dblink);
}
if (isset($_GET['id_delete_category'])) {
    CategoryDelete($_GET['id_delete_category'], $dblink);
}
if (isset($_GET['id_product_edit'])) {
    ProductEdit($_GET['id_product_edit'], $dblink);
}
if (isset($_GET['id_product_delete'])) {
    ProductDelete($_GET['id_product_delete'], $dblink);
}
?>