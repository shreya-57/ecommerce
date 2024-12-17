<?php
        @session_start();
        // getting products
        function getproducts(){
            global $con;
        
            if(!isset($_GET['category'])){
                $select_query = "SELECT * FROM `products` ORDER BY RAND() LIMIT 0,3"; 
                $result_query = mysqli_query($con, $select_query);
        
                while($row = mysqli_fetch_assoc($result_query)){
                    $product_id = $row['product_id'];
                    $product_title = $row['product_title'];
                    $product_description = $row['product_description'];
                    $product_image1 = $row['product_image1'];
                    $product_price = $row['product_price'];
                    $category_id = $row['category_id'];
        
                    echo "
                        <div class='col-md-4 mb-3'>
                            <div class='card h-100'>
                                <img src='./admin_panel/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                                <div class='card-body'>
                                    <h5 class='card-title'>$product_title</h5>
                                    <p class='card-text'>$product_description</p>
                                    <p class='card-text'>Price: $product_price/-</p>";
        
                    // Check if the user is logged in and display the Add to cart button
                    if (isset($_SESSION['username'])) {
                        echo "<a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>";
                    } else {
                        echo "<a href='./user_panel/user_login.php' class='btn btn-primary'>Login to add</a>";
                    }
        
                    echo "
                                </div>
                            </div>
                        </div>
                    "; 
                }
            }
        }       

        // display all the products
        function get_all_products(){
            global $con;
    
            // condition to check isset or not
            if(!isset($_GET['category'])){
            $select_query ="select * from `products` order by rand()"; 
            $result_query= mysqli_query($con, $select_query);
            // $row= mysqli_fetch_assoc($result_query);
            while($row= mysqli_fetch_assoc($result_query)){
                $product_id= $row['product_id'];
                $product_title= $row['product_title'];
                $product_description= $row['product_description'];
                $product_image1= $row['product_image1'];
                $product_price= $row['product_price'];
                $category_id= $row['category_id'];
                echo "
                    <div class='col-md-4 mb-3'>
                    <div class='card h-100'>
                        <img src='./admin_panel/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'>Price: $product_price/-</p>";

                            if(!isset($_SESSION['username'])){
                                echo"<a href='./user_panel/user_login.php' class='btn btn-primary'>Login to add</a>";
                            }
                            else{
                                echo"<a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>";
                            }

                        echo"</div>
                    </div>
                    </div>
                "; 
            }
        }
        }
    
        // getting unique categories
        function get_unique_cat(){
            global $con;
            // condition to check isset or not
            if(isset($_GET['category'])){
                $category_id=$_GET['category'];
                $select_query ="select * from `products` where category_id=$category_id"; 
                $result_query= mysqli_query($con, $select_query);
                $num_of_rows= mysqli_num_rows($result_query);
    
                if($num_of_rows==0){
                    echo "<h2 class='text-center text-danger'>No stock in inventory for this category</h2>";
                }
    
                // $row= mysqli_fetch_assoc($result_query);
                while($row= mysqli_fetch_assoc($result_query)){
                    $product_id= $row['product_id'];
                    $product_title= $row['product_title'];
                    $product_description= $row['product_description'];
                    $product_image1= $row['product_image1'];
                    $product_price= $row['product_price'];
                    $category_id= $row['category_id'];
                    echo "
                        <div class='col-md-4 mb-3'>
                        <div class='card h-100'>
                            <img src='./admin_panel/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                            <div class='card-body'>
                                <h5 class='card-title'>$product_title</h5>
                                <p class='card-text'>$product_description</p>
                                <p class='card-text'>Price: $product_price/-</p>
                                <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>
                            </div>
                        </div>
                        </div>
                    "; 
                }
            }
        }

        // displaying categories in sidenav
        function getcategories(){
            global $con;
            $select_categories= "select * from `categories`";
            $result_categories= mysqli_query($con, $select_categories);
            // $row_data= mysqli_fetch_assoc($result_categories);
            // echo $row_data['category_title'];
            
            while($row_data= mysqli_fetch_assoc($result_categories)){
                $category_title= $row_data['category_title'];
                $category_id= $row_data['category_id'];
                // echo $category_title;
                echo "<li class='nav-item text-dark'>
                        <a href='index.php?category=$category_id' class='nav-link text-dark fw-semibold'>$category_title</a>
                    </li>";
            }
        }

        // search products
        function search_products(){
            global $con;
            if(isset($_GET['search_data_product'])){
            $search_data =$_GET['search_data'];
            $search_query= "select * from `products` where product_keywords like '%$search_data%'";
            $result_query= mysqli_query($con, $search_query);
            // $row= mysqli_fetch_assoc($result_query);
            $num_of_rows= mysqli_num_rows($result_query);
            if($num_of_rows==0){
                echo "<h2 class='text-center text-danger my-4'>No product found</h2>";
            }
            while($row= mysqli_fetch_assoc($result_query)){
                $product_id= $row['product_id'];
                $product_title= $row['product_title'];
                $product_description= $row['product_description'];
                $product_image1= $row['product_image1'];
                $product_price= $row['product_price'];
                $category_id= $row['category_id'];
                $brand_id= $row['brand_id']; 
                echo "
                    <div class='col-md-4 mb-3'>
                    <div class='card h-100'>
                        <img src='./admin_panel/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'>Price: $product_price/-</p>
                            <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>
                        </div>
                    </div>
                    </div>
                "; 
            }
        }
        }

        // insert the items in cart table
        function cart() {
            if (isset($_GET['add_to_cart'])) {
                global $con;
        
                if (!isset($_SESSION['username'])) {
                    echo "<script>alert('Please login to add items to your cart.');</script>";
                    echo "<script>window.open('login.php', '_self');</script>";
                    return;
                }
        
                $get_product_id = $_GET['add_to_cart'];
                $username = $_SESSION['username'];
                
                $get_user_id = "SELECT user_id FROM `user_table` WHERE username = ?";
                $stmt = mysqli_prepare($con, $get_user_id);
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $user_id = $row['user_id'];
        
                $select_query = "SELECT * FROM `cart` WHERE product_id = ? AND user_id = ?";
                $stmt = mysqli_prepare($con, $select_query);
                mysqli_stmt_bind_param($stmt, "ii", $get_product_id, $user_id);
                mysqli_stmt_execute($stmt);
                $result_query = mysqli_stmt_get_result($stmt);
                $num_of_rows = mysqli_num_rows($result_query);
        
                if ($num_of_rows > 0) {
                    echo "<script>alert('This item is already in the cart');</script>";
                    echo "<script>window.open('index.php', '_self');</script>";
                } else {
                    $insert_query = "INSERT INTO `cart` (product_id, quantity, user_id) VALUES (?, 1, ?)";
                    $stmt = mysqli_prepare($con, $insert_query);
                    mysqli_stmt_bind_param($stmt, "ii", $get_product_id, $user_id);
                    mysqli_stmt_execute($stmt);
        
                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        echo "<script>alert('Item added to the cart successfully');</script>";
                        echo "<script>window.open('index.php', '_self');</script>";
                    } else {
                        echo "<script>alert('Failed to add item to the cart');</script>";
                    }
                }
            }
        }
        

        // count numbers of items from cart
        function cart_item_number() {
            @session_start();
        
            if (!isset($_SESSION['username'])) {
                echo 0; 
                return;
            }
        
            $username = $_SESSION['username'];
        
            global $con;
            $get_user_id = "SELECT user_id FROM `user_table` WHERE username = ?";
            $stmt = mysqli_prepare($con, $get_user_id);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id']; 
        
            $select_cart = "SELECT * FROM `cart` WHERE user_id = ?";
            $stmt = mysqli_prepare($con, $select_cart);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result_query = mysqli_stmt_get_result($stmt);
        
            $count_cart_items = mysqli_num_rows($result_query);
        
            echo $count_cart_items;
        }
        
        // function to add the cart item price and sum it and update it 
        function total_cart_price() {
            global $con;
            
            if (!isset($_SESSION['username'])) {
                echo 0; 
                return;
            }

            $username = $_SESSION['username'];
            $get_user_id = "SELECT user_id FROM `user_table` WHERE username = ?";
            $stmt = mysqli_prepare($con, $get_user_id);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
        
            $total = 0;
        
            $cart_query = "SELECT * FROM `cart` WHERE user_id = ?";
            $stmt = mysqli_prepare($con, $cart_query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        
            while ($row = mysqli_fetch_assoc($result)) {
                $product_id = $row['product_id'];
        
                $select_products = "SELECT * FROM `products` WHERE product_id = ?";
                $stmt = mysqli_prepare($con, $select_products);
                mysqli_stmt_bind_param($stmt, "i", $product_id);
                mysqli_stmt_execute($stmt);
                $result_products = mysqli_stmt_get_result($stmt);
        
                while ($row_product_price = mysqli_fetch_assoc($result_products)) {
                    $product_price = $row_product_price['product_price'];
                    $total += $product_price;
                }
            }
        
            echo $total;
        }
        
        // get users order details 
    function get_user_order_details() {
        global $con;
    
        // Check if the session username is set
        if (!isset($_SESSION['username'])) {
            echo "<h3 class='text-center text-danger'>Please log in to view your orders.</h3>";
            return;
        }
    
        $username = mysqli_real_escape_string($con, $_SESSION['username']);
    
        // Query to get the user ID
        $get_user_id = "SELECT user_id FROM `user_table` WHERE username = '$username'";
        $user_result = mysqli_query($con, $get_user_id);
    
        if (!$user_result || mysqli_num_rows($user_result) === 0) {
            echo "<h3 class='text-center text-danger'>User not found.</h3>";
            return;
        }
    
        $user_row = mysqli_fetch_assoc($user_result);
        $user_id = $user_row['user_id'];
    
        $get_orders = "SELECT COUNT(*) as order_count FROM `user_orders` WHERE user_id = $user_id AND order_status = 'pending'";
        $order_result = mysqli_query($con, $get_orders);
    
        if (!$order_result) {
            echo "<h3 class='text-center text-danger'>Failed to fetch order details.</h3>";
            return;
        }
    
        $order_row = mysqli_fetch_assoc($order_result);
        $order_count = $order_row['order_count'];
    
        if ($order_count > 0) {
            echo "<h3 class='text-center text-dark my-6'>You have <span class='text-danger'>$order_count</span> pending orders</h3>
            <p class='text-center'>
                <a href='profile.php?my_orders' class='text-center fw-bold h2'>Order_details</a>";
        } else {
            echo "<h3 class='text-center text-dark'>You have no pending orders.</h3>";
        }
    }
?>