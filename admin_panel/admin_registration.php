<?php
    include('../includes/connect.php');
    include('../functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Admin Registration</title>
    <style>
        body{
            overflow:hidden;
        }
    </style>
</head>
<body>
    <div class="container-fluid m-3">
        <h2 class="text-center">Admin Registration</h2>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-6">
                <img src="../images/admin.jpg" alt="admin-img" class="img-fluid">
            </div>
            <div class="col-lg-6">
                <form action="" method="post">
                    <div class="form-outline mb-4 w-50">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" class="form-control">
                    </div>
                    <div class="form-outline mb-4 w-50">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control">
                    </div>
                    <div class="form-outline mb-4 w-50">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control">
                    </div>
                    <div class="form-outline mb-4 w-50">
                        <label for="con_password" class="form-label">confirm password</label>
                        <input type="password" id="con_password" name="con_password" placeholder="confirm password" class="form-control">
                    </div>
                    <div>
                        <input type="submit" value="Register" class="bg-primary text-light px-3 py-2 border-0" name="admin_register">
                        <p class="small fw-bold my-2">
                            Already have an account?<a href="admin_login.php">Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    if (isset($_POST['admin_register'])) {
        $admin_name = $_POST['username'];
        $admin_email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['con_password'];
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        // Check for username or email duplication
        $select_query = "SELECT * FROM `admin_table` WHERE admin_name = ? OR admin_email = ?";
        $stmt = $con->prepare($select_query);
        $stmt->bind_param("ss", $admin_name, $admin_email);
        $stmt->execute();
        $result_query = $stmt->get_result();
        $rows_count = $result_query->num_rows;

        if ($rows_count > 0) {
            echo "<script>alert('Username or email already exists in the database.')</script>";
        } elseif ($password !== $confirm_password) {
            echo "<script>alert('Password and confirm password do not match.')</script>";
        } else {
            // Insert new admin
            $insert_query = "INSERT INTO `admin_table` (admin_name, admin_email, admin_password) VALUES (?, ?, ?)";
            $stmt = $con->prepare($insert_query);
            $stmt->bind_param("sss", $admin_name, $admin_email, $hash_password);
            if ($stmt->execute()) {
                echo "<script>alert('Admin credentials entered successfully');</script>";
                echo "<script>window.open('admin_login.php','_self')</script>";
            } else {
                echo "<script>alert('Error: Could not execute the query.')</script>";
            }
        }
    }
?>
