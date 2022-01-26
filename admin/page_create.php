<?php

session_start();

include 'admin.php';
include '../cfg.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: ../index.php?page=zaloguj');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dodaj podstronę</title>

    <link rel="stylesheet" type="text/css" href="/www/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/www/css/custom.css">

    <script src="/www/js/bootstrap.bundle.min.js"></script>
    <script src="/www/js/jquery-3.6.0.min.js"></script>
    <script src="/www/js/custom.js"></script>

</head>

<body>
    <?php include '../navbar.php'; ?>
    <div class="container" id="content">
        <?php

        if (isset($_POST["cancel"])) {
            header('Location: panel.php');
            exit();
        }

        echo '<h1>Dodaj stronę</h1><br/>
                <table>
                <form method="post" name="EditForm" enctype="multipart/form-data" action="">
                    <tr>
                        <td>
                            <label for="id_title">Tytuł:</label>
                        </td>
                        <td>
                            <input id="id_title" type="text" name="title" value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="id_content">Treść:</label>
                        </td>
                        <td>
                            <textarea class="form-control" id="id_content" cols="100" rows="25" name="content"></textarea>
                        </td>
                    </tr
                    <tr>
                        <td>
                        <label for="id_status">Aktywuj</label>
                        </td>
                        <td>
                            <input class="form-check-input" id="id_status" type="checkbox" name="status">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="btn btn-primary" type="submit" name="confirm" value="Dodaj stronę">
                        </td>
                        <td>
                            <input class="btn btn-danger" type="submit" name="cancel" value="Anuluj">
                        </td>
                    </tr>
                 </form>
                 </table>';

        if (isset($_POST["confirm"])) {
            $content = $_POST['content'];
            $title = $_POST['title'];

            if (isset($_POST['status'])) {
                $status = 1;
            } else {
                $status = 0;
            }
            $query_create = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$title', '$content', $status)";
            if ($page_info = mysqli_query($dblink, $query_create)) {
                echo '<script type="text/javascript">
                        window.alert("Strona została utworzona.")
                    </script>';
                header('Location: panel.php');
                exit();
            } else {
                echo '<script type="text/javascript">
                        window.alert("Wystąpił błąd")
                    </script>';
            }
        }
        ?>
    </div>
</body>

</html>