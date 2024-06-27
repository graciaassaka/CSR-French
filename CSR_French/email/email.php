<?php
require 'vendor/autoload.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendWelcomeEmail($name, $email) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'assakagracia@gmail.com'; // SMTP username
        $mail->Password = 'uevl cjou veef dpbg'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('assakagracia@gmail.com', 'Mailer');
        $mail->addAddress($email, $name); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Welcome to Complexe Scolaire la Reconnaissance!';
        $mail->Body = 'Hi ' . htmlspecialchars($name) . ',<br><br>Thank you for signing up at Complexe Scolaire la Reconnaissance.';

        $mail->send();
        $_SESSION['message'] = 'Message has been sent';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}

function sendOrderConfirmationEmail($name, $email, $orderId) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'assakagracia@gmail.com'; // SMTP username
        $mail->Password = 'uevl cjou veef dpbg'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('assakagracia@gmail.com', 'Mailer');
        $mail->addAddress($email, $name); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Order Confirmation from Complexe Scolaire la Reconnaissance';
        $mail->Body = 'Hi ' . htmlspecialchars($name) . ',<br><br>Thank you for your order. Your order ID is ' . htmlspecialchars($orderId) . '.';

        $mail->send();
        $_SESSION['message'] = 'Order confirmation has been sent';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Order confirmation could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}