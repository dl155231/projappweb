<?php

if (!isset($_SESSION)) {
    session_start();
    if (isset($_SESSION['logged_in'])) {
        header('Location: ../index.php?page=zaloguj');
        exit();
    }
}

if (isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit();
}
?>

<h1 style="text-align: center; padding: 20px">Logowanie</h1>
<div class="container" style="max-width: 500px; padding: 25px 0;">
    <form method="post" name="LoginForm" enctype="multipart/form-data" action="admin/login.php">

        <label for="username">Login/adres e-mail</label>
        <input class="form-control" id="username" type="text" name="login_email" required />

        <label for="password">Hasło</label>
        <input class="form-control" id="password" type="password" name="login_pass" required />

        <button class="btn btn-primary" type="submit" name="x1_submit" value="zaloguj">Zaloguj</button>

    </form>
</div>

<?php

if (isset($_SESSION['error']))
    // echo $_SESSION['error'];
    echo '<script type="text/javascript">
            window.alert("' . $_SESSION['error'] . '")
        </script>';
?>