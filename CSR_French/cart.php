<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

// Database connection 
include "database/db.php";

// Email
include "email/email.php";

// start session
session_start();

include "functions/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitNewQuantity'])) {
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

        if ($productId > 0 && $quantity > 0) {
            addItemToCart($productId, $quantity, true);
        } else {
            $_SESSION['message'] = 'Invalid product ID or quantity.';
        }

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['submitOrder'])) {
        $studentId = $_SESSION['id'];
        $orderDate = $_POST['date'];
        $total = $_POST['total'];
        $orderId = insertOrder($conn, $studentId, $orderDate, $total);

        if ($orderId) {
            foreach ($_SESSION['cart'] as $productId => $productDetails){
                insertOrderDetails($conn, $orderId, $productId, $productDetails['quantity'], $productDetails['price'], $productDetails['partialTotal']);
                updateQuantityByProductId($conn, $productId, $productDetails['quantity']);
            }

            sendOrderConfirmationEmail($_SESSION['name'], $_SESSION['email'], $orderId);
        }
        header("Location: index.php");
        exit();
    }
}

// Clode database connection
$conn->close();

?>

<head>
    <!-- Canonical link -->
    <link rel="canonical" href="https://lareconnaissance.com/cart.php">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Required meta tags, favicon, and CSS -->
    <?php include 'Includes/head.php'; ?>
    <!-- Title -->
    <title>Cart | Complexe Scolaire la Reconnaissance</title>
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

    <header class="bg-light text-center py-5">
        <h1 class="display-4 headingColor">Check-out</h1>
    </header>

    <!--Main Content Area-->
    <main class="container-fluid mt-5">
        <table class="cart">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price per Item</th>
                    <th>Total Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0 ?>
                <?php foreach ($_SESSION['cart'] as $productId => $productDetails) : ?>
                    <?php
                    $partialTotal = $productDetails['quantity'] * $productDetails['price'];
                    $_SESSION['cart'][$productId]['partialTotal'] = $partialTotal;
                    $total += $partialTotal;
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <tr>
                            <td><?php echo htmlspecialchars($productDetails['name']); ?></td>
                            <td>
                                <?php $cartDisplayQuantityId = "cartDisplayQuantity" . $productId; ?>
                                <div id="<?php echo htmlspecialchars($cartDisplayQuantityId); ?>" class="visible">
                                    <?php echo htmlspecialchars($productDetails['quantity']); ?>
                                </div>
                                <?php $cartEditQuantityId = "cartEditQuantity" . $productId; ?>
                                <div id="<?php echo htmlspecialchars($cartEditQuantityId); ?>" class="hidden">
                                    <input class="cartInput" type="hidden" name="product_id" value="<?php echo htmlspecialchars($productId); ?>">
                                    <input class="cartInput" type="number" name="quantity" value="<?php echo htmlspecialchars($productDetails['quantity']); ?>">
                                    <button class="button-outlined" type="submit" name="submitNewQuantity">
                                        <img src="images/buy.png" alt="Submit" class="icon">
                                    </button>
                                </div>
                            </td>
                            <td><?php echo '$' . htmlspecialchars($productDetails['price']); ?></td>
                            <td><?php echo '$' . htmlspecialchars($partialTotal); ?></td>
                            <td>
                                <button class="button-outlined" onclick="displayEditElements(event, '<?php echo htmlspecialchars($cartEditQuantityId); ?>', '<?php echo htmlspecialchars($cartDisplayQuantityId); ?>')">
                                    <img src="images/edit.png" class="icon">
                                </button>
                            </td>
                        </tr>
                    </form>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3">Total</td>
                    <td><?php echo '$' . htmlspecialchars($total); ?></td>
                    <td>
                        <form class="cartForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>">
                            <input type="hidden" name="total" value="<?php echo htmlspecialchars($total); ?>">
                            <button type="submit" class="button-rounded" name="submitOrder">Buy</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>

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