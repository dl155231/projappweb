
<?php
session_start();

include 'admin.php';
include '../cfg.php';

$login = $_POST['login_email'];
$passwd = $_POST['login_pass'];

if (Login($login, $passwd, $admin_login, $admin_passwd) == 0) {
    $_SESSION['error'] = 'Wystąpił błąd podczas logowania';
    header('Location: login_form.php');
} else {
    $_SESSION['logged_in'] = $login;
    unset($_SESSION['error']);
    header('Location: panel.php');
}
?>