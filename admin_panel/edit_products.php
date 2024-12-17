<?php
    if(isset($_GET['edit_products'])){
        $edit_id=$_GET['edit_products'];
        $get_products="select * from `products` where product_id=$edit_id";
        $result=mysqli_query($con, $get_products);
        $row= mysqli_fetch_assoc($result);
        $product_title=$row['product_title'];
        $product_description=$row['product_description'];
        $product_keywords=$row['product_keywords'];
        $category_id=$row['category_id'];
        $product_image1=$row['product_image1'];
        $product_price=$row['product_price'];
        // echo $category_id;
        // echo $product_title;

        // fetching the category title
        $select_category = "select * from `categories` where category_id=$category_id";
        $result_category= mysqli_query($con, $select_category);
        $row_category=mysqli_fetch_assoc($result_category);
        $category_title=$row_category['category_title'];
        // echo $category_title;
    }
?>
<div class="container mt-5">
    <h1 class="text-center edit-products">Edit Products</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_title" class="form-label">Product Title</label>
            <input type="text" name="product_title" class="form-control" value="<?php echo $product_title; ?>" required>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_description" class="form-label">Product description</label>
            <input type="text" name="product_description" class="form-control" value="<?php echo $product_description; ?>" required>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_keywords" class="form-label">Product keywords</label>
            <input type="text" name="product_keywords" class="form-control" value="<?php echo $product_keywords; ?>" required>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_category" class="form-label">Product Category</label>
            <select name="product_category" class="form-select">
                <option value="<?php echo $category_title; ?>"><?php echo $category_title; ?></option>
                <?php
                    $select_category_all = "select * from `categories`";
                    $result_category_all= mysqli_query($con, $select_category_all);
                    while($row_category_all=mysqli_fetch_assoc($result_category_all)){
                        $category_title=$row_category_all['category_title'];
                        $category_id=$row_category_all['category_id'];
                        echo"<option value='$category_id'>$category_title</option>";
                    };
                ?>
            </select>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image1" class="form-label">Product image1</label>
            <div class="d-flex">
                <input type="file" name="product_image1" class="form-control" required>
                <img src="./product_images/<?php echo $product_image1; ?>" alt="" class="edit-img">
            </div>
        </div> 
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_price" class="form-label">Product price</label>
            <input type="text" name="product_price" class="form-control" value="<?php echo $product_price; ?>" required>
        </div>
        <div class="text-center">
            <input type="submit" value="Edit" name="edit_product" class="btn btn-primary px-3 py-2 text-light text-center" required>
        </div>
    </form>
</div>

<!-- edit query -->
 <?php
    if (isset($_POST['edit_product'])) {
        $product_title = $_POST['product_title'];
        $product_description = $_POST['product_description'];
        $product_keywords = $_POST['product_keywords'];
        $product_category = $_POST['product_category'];
        $product_price = $_POST['product_price'];
    
        $product_image1 = $_FILES['product_image1']['name'];
    
        $temp_image1 = $_FILES['product_image1']['tmp_name'];
    
        // Retain old images if no new images are uploaded
        if (empty($product_image1)) $product_image1 = $row['product_image1'];
        else move_uploaded_file($temp_image1, "./product_images/$product_image1");
    
        $update_query = "UPDATE `products` 
                         SET product_title='$product_title', 
                             product_description='$product_description', 
                             product_keywords='$product_keywords', 
                             category_id='$product_category', 
                             product_image1='$product_image1', 
                             product_price='$product_price', 
                             date=NOW() 
                         WHERE product_id=$edit_id";
    
        $result_update = mysqli_query($con, $update_query);
    
        if ($result_update) {
            echo "<script>alert('Products updated successfully');</script>";
            echo "<script>window.open('index.php', '_self');</script>";
        } else {
            echo "Error updating product: " . mysqli_error($con);
        }
    }    
 ?>