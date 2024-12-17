<?php
    include('../includes/connect.php'); 
    if(isset($_POST['insert_product'])) {
        $product_title = $_POST['product_title'];
        $description = $_POST['description'];
        $product_keywords = $_POST['product_keywords'];
        $product_category = $_POST['product_category'];
        // $product_brand = $_POST['product_brand'];
        $product_price = $_POST['product_price'];
        $product_status = 'true';

        // Accessing images
        $product_image1 = $_FILES['product_image1']['name'];

        // Accessing image temp name
        $temp_image1 = $_FILES['product_image1']['tmp_name'];

        // Allowed file extensions
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Checking file extensions
        $image_extension1 = pathinfo($product_image1, PATHINFO_EXTENSION);

        // Checking empty fields and invalid file types
        if (empty($product_title) || empty($description) || empty($product_keywords) || empty($product_category) || empty($product_price) || empty($product_image1)) {
            echo '<div class="alert alert-danger">Please fill all the input fields</div>';
            exit();
        } elseif (!in_array(strtolower($image_extension1), $allowed_extensions)) {
            echo '<div class="alert alert-danger">Only JPG, JPEG, PNG, and GIF files are allowed for images</div>';
            exit();
        } else {
            // Move uploaded files
            move_uploaded_file($temp_image1, "./product_images/$product_image1");

            // Insert query with prepared statements
            $stmt = $con->prepare("INSERT INTO `products` 
                (product_title, product_description, product_keywords, category_id,
                product_image1, product_price, date, status) 
                VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
            $stmt->bind_param("sssisss", $product_title, $description, $product_keywords, $product_category, 
                               $product_image1, $product_price, $product_status);

            if ($stmt->execute()) {
                echo "<script>alert('Product successfully added')</script>";
                echo "<script>window.open('index.php','_self')</script>";
            } else {
                echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="../style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Insert Products</h1>
        <!-- Form for Product Insertion -->
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Product Title -->
            <div class="form-outline mb-3 w-50 mx-auto">
                <label for="product_title" class="form-label">Product Title</label>
                <input type="text" name="product_title" id="product_title" placeholder="Enter product title" class="form-control" required>
            </div>
            <!-- Description -->
            <div class="form-outline mb-3 w-50 mx-auto">
                <label for="description" class="form-label">Product Description</label>
                <input type="text" name="description" id="description" placeholder="Enter product description" class="form-control" required>
            </div>
            <!-- Keywords -->
            <div class="form-outline mb-3 w-50 mx-auto">
                <label for="product_keywords" class="form-label">Product Keywords</label>
                <input type="text" name="product_keywords" id="product_keywords" placeholder="Enter product keywords" class="form-control" required>
            </div>
            <!-- Category -->
            <div class="form-outline mb-3 w-50 mx-auto">
                <select name="product_category" id="product_category" class="form-select" required>
                    <option value="">Select a category</option>
                    <?php
                        $select_query = "SELECT * FROM `categories`";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_assoc($result_query)) {
                            $category_title = $row['category_title'];
                            $category_id = $row['category_id'];
                            echo "<option value='$category_id'>$category_title</option>";
                        }
                    ?>
                </select>
            </div>
            <!-- Images -->
            <div class="form-outline mb-3 w-50 mx-auto">
                <label for="product_image1" class="form-label">Product Image 1</label>
                <input type="file" name="product_image1" id="product_image1" class="form-control" required>
            </div>
            <!-- Price -->
            <div class="form-outline mb-3 w-50 mx-auto">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="number" name="product_price" id="product_price" placeholder="Enter product price" class="form-control" required>
            </div>
            <!-- Submit Button -->
            <div class="form-outline mb-3 w-50 mx-auto">
                <input type="submit" name="insert_product" class="btn btn-primary text-white" value="Insert Product">
            </div>
        </form>
    </div>
</body>
</html>
