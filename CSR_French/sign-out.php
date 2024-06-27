<?php
session_start();

session_unset();

session_destroy();

setcookie(session_name(), '', time() - 42000);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();
    $_SESSION['message'] = 'Signed out successfully';
    header("Location: index.php");
    exit();
}
