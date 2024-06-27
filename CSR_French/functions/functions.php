<?php

/**
 * Adds an item to the cart.
 *
 * @param int $productId The ID of the product to add.
 * @param int $quantity The quantity of the product to add.
 * @return void
 */
function addItemToCart($productId, $quantity, $editing = false)
{
    global $conn;

    $product = getProductById($conn, $productId);

    if ($product['stock'] - $quantity >= 0) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $editing? $quantity : $_SESSION['cart'][$productId]['quantity'] + $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }
        $_SESSION['message'] = $quantity . ' ' . $product['name'] . ' ' . 'added to cart';
    } else {
        $_SESSION['message'] = 'not enough items in stock';
    }
}


