<?php
include('../includes/connect.php');
include('../functions/common_function.php');
@session_start(); 

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id']; 
} else {
    die("User ID not provided.");
}

// Ensure the user is logged in by checking the session
if (!isset($_SESSION['username'])) {
    echo "<script>alert('You need to log in to proceed!')</script>";
    echo "<script>window.open('../login.php', '_self')</script>";
    exit;
} 
$total_price = 0;

$cart_query = "SELECT * FROM `cart` WHERE user_id = $user_id";
$result_cart = mysqli_query($con, $cart_query);

if (!$result_cart || mysqli_num_rows($result_cart) === 0) {
    echo mysqli_error($result_cart);
    echo "<script>alert('Your cart is empty!')</script>";
    echo "<script>window.open('../index.php', '_self')</script>";
    exit;
}

$invoice_number = mt_rand();
$status = 'pending';
$count_products = mysqli_num_rows($result_cart);

while ($row_price = mysqli_fetch_assoc($result_cart)) {
    $product_id = $row_price['product_id'];

    // Fetch the product's price
    $cart_product_query = "SELECT product_price FROM `products` WHERE product_id = $product_id";
    $result_product = mysqli_query($con, $cart_product_query);

    if ($result_product) {
        $row_product_price = mysqli_fetch_assoc($result_product);
        $product_price = floatval($row_product_price['product_price']);
        $total_price += $product_price;
    }
}

$get_cart_query = "SELECT quantity FROM `cart` WHERE user_id = '$user_id' LIMIT 1";
$run_cart = mysqli_query($con, $get_cart_query);
$row_cart_quantity = mysqli_fetch_assoc($run_cart);
$quantity = intval($row_cart_quantity['quantity'] ?? 1);

// Calculate the subtotal
$subtotal = ($quantity === 1) ? $total_price : $total_price * $quantity;

// Insert the order into the `user_orders` table
$insert_order_query = "
    INSERT INTO `user_orders` 
    (user_id, amount_due, invoice_number, total_products, order_date, order_status) 
    VALUES 
    ($user_id, $subtotal, $invoice_number, $count_products, NOW(), '$status')
";
$result_insert = mysqli_query($con, $insert_order_query);

if ($result_insert) {
    echo "<script>alert('Order submitted successfully!')</script>";
    echo "<script>window.open('profile.php', '_self')</script>";
} else {
    echo "<script>alert('Failed to submit order. Please try again.')</script>";
    echo "<script>window.open('cart.php', '_self')</script>";
}

// Insert pending orders for each product in the cart
mysqli_data_seek($result_cart, 0); // Reset pointer to the beginning of the result set
while ($row_cart = mysqli_fetch_assoc($result_cart)) {
    $product_id = $row_cart['product_id'];
    $quantity = intval($row_cart['quantity']);

    $insert_pending_order = "
        INSERT INTO `orders_pending` 
        (user_id, invoice_number, product_id, quantity, order_status) 
        VALUES 
        ($user_id, $invoice_number, $product_id, $quantity, '$status')
    ";

    $result_pending = mysqli_query($con, $insert_pending_order);
    if (!$result_pending) {
        echo "Error inserting pending order for product ID $product_id: " . mysqli_error($con);
    }
}

// Delete cart items for the logged-in user
$empty_cart = "DELETE FROM `cart` WHERE user_id = '$user_id'";
$result_delete = mysqli_query($con, $empty_cart);

if ($result_delete) {
    echo "Cart items deleted successfully.";
} else {
    echo "Error deleting cart items: " . mysqli_error($con);
}
?>
