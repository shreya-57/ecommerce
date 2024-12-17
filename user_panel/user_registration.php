<?php
    include('../includes/connect.php');
    include('../functions/common_function.php');
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body{
            overflow-x:hidden;
        }
    </style>
</head>
<body>
    <div class="container-fluid my-3 mx-5">
        <h2 class="text-center">
            Signup Form
        </h2>
        <div class="row">
            <div class="lg-12 col-xl-6 mx-auto">
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- username -->
                    <div class="form-outline mb-4">
                        <label for="user_username" class="form-label">UserName:</label>
                        <input type="text" id="user_username" name="user_username" class="form-control" placeholder="Enter your username" required/>
                    </div>
                    <!-- email -->
                    <div class="form-outline mb-4">
                        <label for="user_email" class="form-label">Email:</label>
                        <input type="text" id="user_email" name="user_email" class="form-control" placeholder="Enter your email" required/>
                    </div>
                    <!-- image -->
                    <div class="form-outline mb-4">
                        <label for="user_image" class="form-label">Image:</label>
                        <input type="file" id="user_image" name="user_image" class="form-control" required/>
                    </div>
                    <!-- password -->
                    <div class="form-outline mb-4">
                        <label for="user_password" class="form-label">Password:</label>
                        <input type="password" id="user_password" name="user_password" class="form-control" placeholder="Enter your password" required/>
                    </div>
                    <!-- conform password -->
                    <div class="form-outline mb-4">
                        <label for="conf_user_password" class="form-label">Confirm password:</label>
                        <input type="password" id="conf_user_password" name="conf_user_password" class="form-control" placeholder="Confirm Password" required/>
                    </div>
                    <!-- address -->
                    <div class="form-outline mb-4">
                        <label for="user_address" class="form-label">Address:</label>
                        <input type="text" id="user_address" name="user_address" class="form-control" placeholder="Enter your address" required/>
                    </div>
                    <!-- contact -->
                    <div class="form-outline mb-4">
                        <label for="user_mobile" class="form-label">Contact Number:</label>
                        <input type="text" id="user_mobile" name="user_mobile" class="form-control" placeholder="Enter your contact number" required/>
                    </div>
                    <!-- button -->
                     <div class="text-center mt-2">
                        <input type="submit" value="Register" class="px-3 py-2 bg-primary text-white border-0" name="user_register"/>
                        <p class="small fw-bold mt-2">Already have an account? <a href="user_login.php">Login here</a></p>
                     </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<!-- inserting user data in database -->
 <?php
    if(isset($_POST['user_register'])){
        $user_username = $_POST['user_username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $hash_password = password_hash($user_password,PASSWORD_DEFAULT);
        $conf_user_password = $_POST['conf_user_password'];
        $user_address = $_POST['user_address'];
        $user_mobile = $_POST['user_mobile'];
        $user_image = $_FILES['user_image']['name'];
        $user_image_tmp = $_FILES['user_image']['tmp_name'];
        
        move_uploaded_file($user_image_tmp,"./user_images/$user_image");

        // select query
        $select_query= "select * from `user_table` where user_email='$user_email' or username='$user_username'";
        $result= mysqli_query($con, $select_query);
        $rows_count=mysqli_num_rows($result);

        if($rows_count>0){
            echo"<script>alert('username and email already exist')</script>";
        }
        else if($user_password != $conf_user_password){
            echo"<script>alert('password and conform password doesnot match')</script>";
        }
        else{
        // insert query
        $insert_query= "insert into `user_table` (username, user_email, user_password, user_image, user_address, user_mobile )
        values('$user_username','$user_email','$hash_password','$user_image','$user_address','$user_mobile')";
        $result_query= mysqli_query($con, $insert_query);

        if($result_query){
            echo"<script>alert('User credentials entered successfully')</script>";
        }
        else{
            die(mysqli_error($con));
        }
    }

    // selecting cart items and if user is not logged user then redirecting to login page where the redirection code is at checkout.php
    // $select_cart_items = "select * from `cart_details` where ip_address='$user_ip'";
    // $result_cart= mysqli_query($con, $select_cart_items);
    // $rows_count= mysqli_num_rows($result_cart);
    // if($rows_count>0){
    //     $_SESSION['username']=$user_username;
    //     echo"<script>alert('You have items inside cart')</script>";
    //     echo"<script>window.open('checkout.php','_self')</script>";
    // }
    // else{
    //     echo"<script>window.open('index.php','_self')</script>";
    // }
    }
 ?>