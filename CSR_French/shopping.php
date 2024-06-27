<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection 
include "database/db.php";

// start session
session_start();

// retrive data from database
$page_info = getStaticContent($conn, 'shopping.php', 'header');
$school_supplies_intro = getStaticContent($conn, 'shopping.php', 'schoolSupplies');
$school_uniforms_intro = getStaticContent($conn, 'shopping', 'schoolUniforms');
$school_shoes_intro = getStaticContent($conn, 'shopping.php', 'schoolShoes');

$school_supplies = getProductByCategory($conn, 'fourniture');

include "functions/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

    if ($productId > 0 && $quantity > 0) {
        addItemToCart($productId, $quantity);
    } else {
        $_SESSION['message'] = 'Invalid product ID or quantity.';
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

/**
 * Displays the products.
 *
 * @param string $product The product to display.
 * @return void
 */
function displayProducts($product)
{
?>
    <div class="col">
        <div class="productCard card shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div class="product_description">
                    <h3> <?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                </div>
                <img src="<?php echo htmlspecialchars($product['image']['src']); ?>" alt="<?php echo htmlspecialchars($product['image']['alt']); ?>" class="<?php echo htmlspecialchars($product['image']['class']); ?> products tablet-desktop">
            </div>
            <div class="card-body">
                <div id="<?php echo htmlspecialchars($product['name']); ?>-quantity" style="visibility: hidden;">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        <input type="number" name="quantity" placeholder="e.g 6">
                        <button class="button-outlined" type="submit">
                            <img src="images/buy.png" alt="Submit" class="icon">
                        </button>
                    </form>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small><?php echo htmlspecialchars($product['price']); ?></small>
                    <button class="button-rounded" onclick="displayElement('<?php echo htmlspecialchars($product['name']); ?>-quantity')">
                        <img src="images/online-shopping.png" alt="Shopping Cart" class="icon">
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php
}

// Clode database connection
$conn->close();
?>

<head>
    <!-- Canonical link -->
    <link rel="canonical" href="https://lareconnaissance.com">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Required meta tags, favicon, and CSS -->
    <?php include 'Includes/head.php'; ?>
    <!-- Title -->
    <title>Shopping | Complexe Scolaire la Reconnaissance</title>
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

    <!--Main Content Area-->
    <main class="container-fluid mt-5">

        <div class="p-5 mb-4 rounded-3">
            <h1 class="display-3 headingColor"><?php echo htmlspecialchars($school_supplies_intro['heading']); ?></h1>
            <p class="lead"><?php echo htmlspecialchars($school_supplies_intro['texts'][0]); ?></p>
            <div class="album py-5">
                <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        <?php
                        for ($i = 0; $i < count($school_supplies); $i++) :
                            displayProducts($school_supplies[$i], $i);
                        endfor;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5">

    </main>

    <!--Footer-->
    <?php include "includes/footer.php"; ?>
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