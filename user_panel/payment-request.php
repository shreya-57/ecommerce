<?php
session_start();
include('../includes/connect.php');
if (isset($_POST['submit'])) {
    $amount = $_POST['inputAmount4']*100; //amount to paisa as the amount should be in paisa for khalti
    $payment_amount= $_POST['inputAmount4'];
    $purchase_order_id = $_POST['inputPurchasedOrderId4'];
    $purchase_order_name = $_POST['inputPurchasedOrderName'];
    $name = $_POST['inputName'];
    $email = $_POST['inputEmail'];
    $phone = $_POST['inputPhone'];
    $paymentMode = 'Khalti';  

    // Update orders_pending table
    $updateQuery = "UPDATE `orders_pending` SET order_status = 'completed' WHERE order_id = '$purchase_order_id'";
    $updateStmt = mysqli_query($con, $updateQuery);

    if ($updateStmt) {
        // Update user_orders table
        $update_user_orders = "UPDATE `user_orders` SET order_status = 'paid' WHERE order_id = '$purchase_order_id'";
        $result_update_user_orders = mysqli_query($con, $update_user_orders);

        // Insert into user_payments table
        $insertQuery = "
            INSERT INTO `user_payments` (order_id, invoice_number, amount, payment_mode, status)
            VALUES ('$purchase_order_id', '$purchase_order_name', '$payment_amount', '$paymentMode', NOW())
        ";
        $insertStmt = mysqli_query($con, $insertQuery);

        if ($insertStmt) {
            echo "<script>alert('Payment table updated successfully.')</script>";
        } else {
            echo "<script>alert('Failed to update payment table: " . mysqli_error($con) . "')</script>";
        }
    } else {
        echo "<script>alert('Failed to update orders_pending: " . mysqli_error($con) . "')</script>";
    }

    //here validate the data
    if(empty($amount) || empty($purchase_order_id) || empty($purchase_order_name) || empty($name) || empty($email) || empty($phone)){
        $_SESSION["validate_msg"] = '<script>
        Swal.fire({
            icon: "error",
            title: "All fields are required",
            showConfirmButton: false,
            timer: 1500
        });
    </script>';
        header("Location: checkout.php");
        exit();
    }
    //check if the amount is a number
    if(!is_numeric($amount)){
        $_SESSION["validate_msg"] = '<script>
        Swal.fire({
            icon: "error",
            title: "Amount must be a number",
            showConfirmButton: false,
            timer: 1500
        });
    </script>';
        header("Location: checkout.php");
        exit();
    }

    //check if the phone number is a number
    if(!is_numeric($phone)){
        $_SESSION["validate_msg"] = '<script>
        Swal.fire({
            icon: "error",
            title: "Phone must be a number",
            showConfirmButton: false,
            timer: 1500
        });
    </script>';
        header("Location: checkout.php");
        exit();
    }

    //check if the email is valid
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION["validate_msg"] = '<script>
        Swal.fire({
            icon: "error",
            title: "Email is not valid",
            showConfirmButton: false,
            timer: 1500
        });
    </script>';
        header("Location: checkout.php");
        exit();
    }

    $postFields = array(
        "return_url" => "http://localhost/ecommerce/user_panel/payment-response.php",
        "website_url" => "http://localhost/ecommerce/",
        "amount" => $amount,
        "purchase_order_id" => $purchase_order_id,
        "purchase_order_name" => $purchase_order_name,
        "customer_info" => array(
            "name" => $name,
            "email" => $email,
            "phone" => $phone
        )
    );

}
$jsonData = json_encode($postFields);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $jsonData,
    CURLOPT_HTTPHEADER => array(
        'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455',
        'Content-Type: application/json',
    ),
));

$response = curl_exec($curl);


if (curl_errno($curl)) {
    echo 'Error:' . curl_error($curl);
} else {
    $responseArray = json_decode($response, true);

    if (isset($responseArray['error'])) {
        echo 'Error: ' . $responseArray['error'];
    } elseif (isset($responseArray['payment_url'])) {
        header('Location: ' . $responseArray['payment_url']);
    } else {
        echo 'Unexpected response: ' . $response;
    }
}

curl_close($curl);
