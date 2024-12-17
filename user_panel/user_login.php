<?php
    include('../includes/connect.php');
    include('../functions/common_function.php');
    @session_start();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body{
            overflow-x:hidden;
        }
    </style>
</head>
<body>
<div class="container-fluid my-3 mx-5 mt-10">
        <h2 class="text-center text-black">
            Login Form
        </h2>
        <div class="row">
            <div class="lg-12 col-xl-6 mx-auto">
                <form action="" method="post" enctype="multipart/form-data" class="text-black">
                    <!-- email -->
                    <div class="form-outline mb-4">
                        <label for="user_username" class="form-label">Username:</label>
                        <input type="text" id="user_username" name="user_username" class="form-control" placeholder="Enter your username" required/>
                    </div>
                    <!-- password -->
                    <div class="form-outline mb-4">
                        <label for="user_password" class="form-label">Password:</label>
                        <input type="password" id="user_password" name="user_password" class="form-control" placeholder="Enter your password" required/>
                    </div>
                    <!-- button -->
                     <div class="text-center mt-2">
                        <input type="submit" value="Login" class="px-3 py-2 bg-primary text-white border-0" name="user_login"/>
                        <p class="small fw-bold mt-2">Already have an account? <a href="user_registration.php">Register</a></p>
                     </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    if(isset($_POST['user_login'])){
        $user_username = $_POST['user_username'];
        $user_password = $_POST['user_password'];

        $select_query="select * from `user_table` where username='$user_username'";
        $result_query=mysqli_query($con, $select_query);
        $row_count= mysqli_num_rows($result_query);
        $row_data= mysqli_fetch_assoc($result_query);
        $user_id=$row_data['user_id'];
        echo $user_id;

        // cart item
        $select_cart="select * from `cart` where user_id='$user_id'";
        $result_cart=mysqli_query($con, $select_cart);
        $row_cart = mysqli_num_rows($result_cart);
        if($row_count>0){
            $_SESSION['username']=$user_username;
            $_SESSION['user_id']=$user_id;
            if(password_verify($user_password, $row_data['user_password'])){
            // echo"<script>alert('You have logged in successfully')</script>";
                if($row_count==1){
                    $_SESSION['username']=$user_username;
                    echo"<script>alert('You have logged in successfully')</script>";
                    echo"<script>window.open('../index.php','_self')</script>";
                }
            }
            else{
            echo"<script>alert('Invalid Credentials')</script>";
            }
        }
        else{
            echo"<script>alert('Invalid Credentials')</script>";
        }
    }
?>