<?php
    include('../includes/connect.php');
    include('../functions/common_function.php');
    @session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $_SESSION['username']?></title>
    <!-- bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css" />
    <style>
        .profile-img{
            width:90%;
            height:90%;
            /* border-radius: 50%; */
            object-fit:contain;
            margin: auto;
        }
        body{
            overflow-x: hidden;
        }
        /* .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px; 
        } */
    </style>
</head>
<body>
     <div class="container-fluid p-0 text-white">
    <!-- header section -->
    <nav class="navbar navbar-expand-lg bg-body-secondary text-dark">
        <div class="container-fluid w-[94%]">
            <a class="navbar-brand" href="#">
                <img src="../images/logo.png" class="logo-index" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 px-2 fs-6 fw-semibold">
                <li class="nav-item">
                    <a class="nav-link text-black" href="../index.php">Home</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link text-black" href="../display_products.php">All Products</a>
                </li>
                <li class="nav-item px-2">
                    <?php 
                    if(!isset($_SESSION['username'])){
                        echo"
                            <li class='nav-item'>
                                <a class='nav-link text-black' href='user_registration.php'>Register</a>
                            </li>
                        ";
                    }
                    else{
                        echo"
                            <li class='nav-item'>
                                <a class='nav-link text-black' href='profile.php'>My Account</a>
                            </li>
                        ";
                    }
                    ?>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link text-black" href="#">Contact</a>
                </li>
                <?php
                    if(isset($_SESSION['username'])){
                        echo"
                            <li class='nav-item px-2'>
                                <a class='nav-link text-black' href='../cart.php' name=''><i class='fa fa-shopping-cart' aria-hidden='true'></i><sup>"; cart_item_number(); echo"</sup></a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link text-black' href='#'>Total Price:"; total_cart_price(); echo"/-</a>
                            </li>
                        ";
                    }
                    else{
                        echo"";
                    }
                ?>
            </ul>
            <form class="d-flex" action="search_product.php" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                <!-- <button class="btn btn-outline-light" type="submit">Search</button> -->
                 <input type="submit" value="Search" class="btn btn-outline-primary" name="search_data_product">
            </form>
            <?php
                cart();
            ?>
            </div>
        </div>
    </nav>

    <!-- user name and login section here -->
    <nav class="navbar navbar-extend-lg navbar-primary bg-primary bg-gradient">
        <ul class="navbar-nav me-auto flex-lg-row flex-column gap-lg-3 px-2">
            <?php 
                    if(!isset($_SESSION['username'])){
                        echo"<li class='nav-item'>
                            <a class='nav-link text-light fw-semibold' href='/'>Welcome users</a>
                        </li>";
                    }
                    else{
                        echo"
                        <li class='nav-item'>
                            <a class='nav-link text-light fw-semibold' href='/'>Welcome ".$_SESSION['username']."</a>
                        </li>";
                    }
                ?>
            
            <?php 
                if(!isset($_SESSION['username'])){
                    echo"<li class='nav-item'>
                            <a class='nav-link text-light fw-semibold' href='./user_panel/user_login.php'>Login</a>
                        </li>";
                }
                else{
                    echo"
                    <li class='nav-item'>
                        <a class='nav-link text-light fw-semibold' href='./user_panel/user_logout.php'>Logout</a>
                    </li>";
                }
            ?>
        </ul>
    </nav>

    <!-- user profile section -->
     <div class="row">
        <!-- user profile -->
        <div class="col-md-2 p-0">
                <ul class="navbar-nav navbar-dark bg-dark text-center" style="height:100vh">
                    <li class="nav-item bg-secondary">
                        <a class="nav-link active h4 text-light fw-bold" aria-current="page" href="#">Your Profile</a>
                    </li>
                    <?php
                        $username= $_SESSION['username'];
                        $user_image= "select * from `user_table` where username='$username'";
                        $result_img= mysqli_query($con, $user_image);
                        $row_image=mysqli_fetch_array($result_img);
                        $user_image=$row_image['user_image'];
                        echo"
                            <li class='nav-item my-2'>
                                <img src='./user_images/$user_image' alt='' class='profile-img mx-auto'>
                            </li>
                        ";
                    ?>
                    
                    <li class="nav-item ">
                        <a class="nav-link active h4 text-light fw-bold" aria-current="page" href="profile.php">Pending Orders</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active h4 text-light fw-bold" aria-current="page" href="profile.php?my_orders">My orders</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active h4 text-light fw-bold" aria-current="page" href="user_logout.php">Logout</a>
                    </li>
                </ul>
        </div>
        <div class="col-md-10 text-center text-dark">
            <?php
                get_user_order_details();
                if(isset($_GET['my_orders'])){
                    include('user_orders.php');
                }
            ?>
        </div>
     </div>
    
    </div>
    <!-- bootstrap js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>