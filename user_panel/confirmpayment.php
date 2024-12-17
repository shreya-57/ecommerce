<?php
@session_start();
include('../includes/connect.php'); 

if(isset($_GET['order_id'])){
    $order_id = $_GET['order_id'];  // Corrected typo
    // Use prepared statement to prevent SQL injection
    $orderQuery = "SELECT amount_due, order_id, invoice_number FROM user_orders WHERE order_id = ?";
    $stmt = mysqli_prepare($con, $orderQuery);
    mysqli_stmt_bind_param($stmt, "i", $order_id);  // 'i' stands for integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $fetch_order = mysqli_fetch_assoc($result);
    $amount = $fetch_order['amount_due'];
    $invoice = $fetch_order['invoice_number'];

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        // Use prepared statement for user query
        $user_query = "SELECT username, user_email, user_mobile FROM `user_table` WHERE username = ?";
        $stmt_user = mysqli_prepare($con, $user_query);
        mysqli_stmt_bind_param($stmt_user, "s", $username);  // 's' stands for string
        mysqli_stmt_execute($stmt_user);
        $result_user = mysqli_stmt_get_result($stmt_user);
        $row_user = mysqli_fetch_assoc($result_user);
        $name = $row_user['username'];
        $email = $row_user['user_email'];
        $mobile = $row_user['user_mobile'];
    } else {
        echo "Failed to fetch user details.";
    }
} else {
    echo "Failed to fetch order details.";
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khalti Payment Integration</title>

    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="m-4">
    <?php
    if (isset($_SESSION['transaction_msg'])) {
        echo $_SESSION['transaction_msg'];
        unset($_SESSION['transaction_msg']);
    }

    if (isset($_SESSION['validate_msg'])) {
        echo $_SESSION['validate_msg'];
        unset($_SESSION['validate_msg']);
    }
    ?>
    <h1 class="text-center">Payment</h1>
    <div class="d-flex justify-content-center mt-3">
        <form class="row g-3 w-50 mt-4" action="payment-request.php" method="POST">
            <label for="">Product Details:</label>
            <div class="col-md-6">
                <label for="inputAmount4" class="form-label">Amount</label>
                <input type="text" class="form-control" id="inputAmount4" name="inputAmount4" value="<?php echo htmlspecialchars($amount); ?>">
            </div>
            <div class="col-md-6">
                <label for="inputPurchasedOrderId4" class="form-label">Purchased Order Id</label>
                <input type="text" class="form-control" id="inputPurchasedOrderId4" name="inputPurchasedOrderId4" value="<?php echo htmlspecialchars($order_id); ?>">
            </div>
            <div class="col-12">
                <label for="inputPurchasedOrderName" class="form-label">Purchased invoice number</label>
                <input type="text" class="form-control" id="inputPurchasedOrderName" name="inputPurchasedOrderName" value="<?php echo htmlspecialchars($invoice); ?>">
            </div>
            <label for="">Customer Details:</label>
            <div class="col-12">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control" id="inputName" name="inputName" value="<?php echo htmlspecialchars($name); ?>">
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail" name="inputEmail" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="col-md-6">
                <label for="inputPhone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="inputPhone" name="inputPhone" value="<?php echo htmlspecialchars($mobile); ?>">
            </div>
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Pay with Khalti</button>
            </div>
        </form>
    </div>
</body>
</html>
