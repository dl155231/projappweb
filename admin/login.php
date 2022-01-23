
<?php
session_start();

include 'admin.php';
include '../cfg.php';

$login = $_POST['login_email'];
$passwd = $_POST['login_pass'];

if (Zaloguj($login, $passwd, $admin_login, $admin_passwd) == 0) {
    $_SESSION['error'] = 'Wystąpił błąd podczas logowania';
    header('Location: form_log.php');
} else {
    $_SESSION['login'] = $login;
    unset($_SESSION['error']);
    header('Location: CMS.php');
}
?>