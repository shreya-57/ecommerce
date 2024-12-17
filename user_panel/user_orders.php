<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My orders page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
        $username= $_SESSION['username'];
        $get_user= "select * from `user_table` where username='$username'";
        $result= mysqli_query($con, $get_user);
        $row_fetch=mysqli_fetch_assoc($result);
        $user_id=$row_fetch['user_id'];
        // echo $user_id;
    ?>
    <h3 class="text-center">
        All my orders
    </h3>
    <table class="table table-bordered mt-5 p-5 w-[94%] mx-auto">
        <thead class='bg-dark text-light'>
        <tr>
            <th>S.No.</th>
            <th>Amount Due</th>
            <th>Total Products</th>
            <th>invoice number</th>
            <th>Date</th>
            <th>Complete/Incomplete</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
            <?php
                $get_order_details= "select * from `user_orders` where user_id=$user_id";
                $result_query=mysqli_query($con, $get_order_details);
                while($row_data=mysqli_fetch_assoc($result_query)){
                    $order_id=$row_data['order_id'];
                    $amount_due=$row_data['amount_due'];
                    $invoice_number=$row_data['invoice_number'];
                    $total_products=$row_data['total_products'];
                    $order_status=$row_data['order_status'];
                    if($order_status=='pending'){
                        $order_status='incomplete';
                    }
                    else{
                        $order_status='complete';
                    }
                    $order_date=$row_data['order_date'];
                    $number=1;
                    echo"
                    <tr>
                        <td>$number</td>
                        <td>$amount_due</td>
                        <td>$total_products</td>
                        <td>$invoice_number</td>
                        <td>$order_date</td>
                        <td>$order_status</td>
                        ";
                    ?>
                        <?php
                            if($order_status=='complete'){
                            echo"<td>Paid</td>";
                        }
                        else{
                        echo"
                        <td><a href='confirmpayment.php?order_id=$order_id' class='text-black'>Confirm</a></td>
                        </tr>
                        ";
                    }
                    $number++;
                }?>
        </tbody>
    </table>
</body>
</html>