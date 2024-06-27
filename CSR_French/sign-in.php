<?php
// Database connection 
include "database/db.php";

// start session
session_start();

// check credentials 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $credentials = getStudentDetailsByEmail($conn, $email);

    if (!empty($credentials)) {
        if (password_verify($password, $credentials['password'])) {
            $_SESSION['id'] = $credentials['id'];
            $_SESSION['name'] = $credentials['name'];
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $credentials['phone'];
            $_SESSION['cart'] = [];
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['message'] = 'Invalid Password. Try again.';
        }
    } else {
        $_SESSION['message'] = 'Invalid Email. Try again.';
    }
}

// Close database connection
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
    <title>Sign-in | Complexe Scolaire la Reconnaissance</title>
</head>

<body>
    <!-- Message -->
    <?php if (isset($_SESSION['message'])) : ?>
        <div class="toast">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Navigation bar -->
    <?php include 'includes/navbar.php'; ?>

    <main class="container-fluid mt-5">

        <h1 class="display-3 headingColor text-center">Connectez vous:</h1>
        <form class="signin" id="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="email" data-original-text="Email">Email</label>
            <input type="email" name="email">
            <label for="password" data-original-text="Password">Password:</label>
            <input type="password" name="password">
            <br>
            <br>
            <input type="submit" value="Sign-in" id="finish">

            <a href="forgot-password.php">Forgot Password?</a>
            <br>
            <br>
            <a href="sign-up.php" class="button-rounded">Sign-up</a>
        </form>

    </main>

    <!--Footer-->
    <?php include 'Includes/footer.php'; ?>
    <!--Back_to_top_button-->
    <?php include "includes/back_to_top.php"; ?>
    <!-- Scripts -->
    <?php include "includes/scripts.php"; ?>
    <?php if (isset($_SESSION['message'])) : ?>
        <script>
            showToast();
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

</body>

</html>