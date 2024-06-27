<?php

session_start();

include 'send_confirmation_email.php';

$site = $_POST['site'];
$visitDate = $_POST['visitDate'];
$name= $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$phoneRegex = '/^(\+243\s\d{3}-\d{3}-\d{3})$/';
$emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

if (empty($site) || empty($visitDate) || empty($name) || empty($email) || empty($phone)) {
    die('All fields are required.');
}

if (!preg_match($emailRegex, $email)) {
    die('Invalid email address.');
}

if (!preg_match($phoneRegex, $phone)) {
    die('Invalid phone number');
}

// TODO: Database connection and database operations
$result = true;

if ($result) {
    // Send the confirmation email
    // sendConfirmationEmail($email, $visitDate, $site);

    $_SESSION['confirmation'] = "Votre visite a $site a ete programme pour le $visitDate";
    header('Location: index.php');
} else {
    $_SESSION['error'] = "Il y a eu une erreur lors de l'enregistrement de votre visite";
    header('Location: visite.php');
}
?>
