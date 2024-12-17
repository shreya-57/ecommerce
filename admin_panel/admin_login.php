<?php
    include('../includes/connect.php');
    include('../functions/common_function.php');
    @session_start();

    if (isset($_POST['admin_login'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        // echo $username;
    
        // Use prepared statements to fetch user details
        $query = "SELECT * FROM `admin_table` WHERE admin_name = ?";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
            echo("MySQL error: " . mysqli_error($con));
        }
        mysqli_stmt_bind_param($stmt, 's', $username);
        if (!mysqli_stmt_execute($stmt)) {
            echo("Query execution failed: " . mysqli_error($con));
        }
        $result = mysqli_stmt_get_result($stmt);
        // echo $result;
    
        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
    
            // Verify the password
            if (password_verify($password, $row['admin_password'])) {
                $_SESSION['admin_username'] = $username;
    
                echo "<script>alert('Login successful!');</script>";
                echo "<script>window.open('index.php', '_self');</script>";
                exit();
            } else {
                echo "<script>alert('Invalid username or password');</script>";
            }
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    
        mysqli_stmt_close($stmt);
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Admin Registration</title>
    <style>
        body{
            overflow:hidden;
            text:black;
        }
    </style>
</head>
<body>
    <div class="container-fluid m-3">
        <h2 class="text-center">Admin Login</h2>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-6">
                <img src="../images/admin.jpg" alt="admin-img" class="img-fluid">
            </div>
            <div class="col-lg-6">
                <form action="" method="post">
                    <div class="form-outline mb-4 w-50 ">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" class="form-control">
                    </div>
                    <div class="form-outline mb-4 w-50">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control">
                    </div>
                    <div>
                        <input type="submit" value="Login" class="bg-primary text-light px-3 py-2 border-0" name="admin_login">
                        <p class="small fw-bold my-2">
                            <!-- Don't have an account?<a href="admin_registration.php">Register</a> -->
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
