<?php
require 'vendor/autoload.php';

// Database connection 
include "database/db.php";

// Email
include "email/email.php";

// start session
session_start();

// Check if the form was submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $birthdate = $_POST['birthdate'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Assuming getStudentDetailsByEmail function returns null or an empty array if no record found
    if (empty(getStudentDetailsByEmail($conn, $email)) && insertStudent($conn, $name, $birthdate, $email, $phone, $hashedPassword)){
        sendWelcomeEmail($name, $email);
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Email already exists. Use a different email.');</script>";
    }
}

// Clode database connection
$conn->close();

?>
<!doctype html>
<html lang="fr">

<head>
    <!-- Canonical link -->
    <link rel="canonical" href="https://lareconnaissance.com/sign-in.php">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Required meta tags, favicon, and CSS -->
    <?php include 'Includes/head.php'; ?>
    <!-- Title -->
    <title>Sign-up | Complexe Scolaire la Reconnaissance</title>
</head>

<body>
    <!-- Navigation bar -->
    <?php include 'includes/navbar.php'; ?>

    <main class="container-fluid mt-5">

        <h1 class="display-3 headingColor text-center">Connectez vous:</h1>
        <form class="signup" id="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="name" data-original-text="Nom">Nom</label>
            <input type="text" name="name" id="name" placeholder="First and last name" required>
            <label for="birthdate" data-original-text="Né(e) le">Né(e) le</label>
            <input type="date" name="birthdate" id="birthdate">
            <label for="phone" data-original-text="Téléphone">Téléphone</label>
            <input type="tel" name="phone" placeholder="+243 xxx-xxx-xxx" id="phone">
            <label for="email" data-original-text="Email">Email</label>
            <input type="email" name="email" placeholder="example@example.com" id="email">
            <label for="password" data-original-text="Password">Password</label>
            <input type="password" name="password" id="password">
            <div id="confirm" style="display: none">
                <label for="passwordConfirmation" data-original-text="Confirm Password">Confirm Password</label>
                <input type="password" name="passwordConfirmation" id="passwordConfirmation">
            </div>
            <br>
            <br>
            <input type="submit" value="Sign-up" id="finish">

            <a href="sign-in.php">Already have an account?</a>
            <br>
            <br>
        </form>
    </main>

    <!--Footer-->
    <?php include 'Includes/footer.php'; ?>
    <!--Back_to_top_button-->
    <?php include "includes/back_to_top.php"; ?>
    <!-- Scripts -->
    <?php include "includes/scripts.php"; ?>

</body>

</html>