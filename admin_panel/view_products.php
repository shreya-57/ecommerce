<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <style>
        .all-products{
            overflow-y:hidden;
        }
        .product-img{
            width:100px;
            object-fit:contain;
        }
    </style>
</head>
<body>
    <h2 class="text-center all-products">All products</h2>
    <table class="table table-bordered mt-5">
        <thead>
            <tr class='bg-dark fw-bold text-center'>
                <td>Product Id</td>
                <td>Product Title</td>
                <td>Product Image</td>
                <td>Product Price</td>
                <td>Total Sold</td>
                <!-- <td>Status</td> -->
                <td>Edit</td>
                <td>Delete</td>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
            // include('../includes/connect.php');
                $get_products="select * from `products`";
                $result= mysqli_query($con, $get_products);
                $number=0;
                while($row=mysqli_fetch_assoc($result)){
                    $product_id=$row['product_id'];
                    $product_title=$row['product_title'];
                    $product_image1=$row['product_image1'];
                    $product_price=$row['product_price'];
                    $status=$row['status'];
                    $number++;
                    ?>
                        <tr>
                            <td><?php echo $number; ?></td>
                            <td><?php echo $product_title; ?></td>
                            <td><img src='./product_images/<?php echo $product_image1; ?>'/ class='product-img'></td>
                            <td><?php echo $product_price; ?></td>
                            <td>
                                <?php
                                    $get_count= "select * from `orders_pending` where product_id=$product_id";
                                    $result_count= mysqli_query($con, $get_count);
                                    $rows_count= mysqli_num_rows($result_count);
                                    echo $rows_count;
                                ?>
                            </td>
                            <!-- <td><php echo $status; ?></td> -->
                            <td><a href='index.php?edit_products=<?php echo $product_id; ?>'><i class='fa-solid fa-pen-to-square'></i></a></td>
                            <td><a href='index.php?delete_products=<?php echo $product_id; ?>'><i class='fa-solid fa-trash text-danger'></i></a></td>
                        </tr>
                        <?php   
                }?>
        </tbody>
    </table>
</body>
</html>