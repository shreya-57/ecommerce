<?php
    include('../includes/connect.php');  
    if(isset($_POST['insert_cat'])){
        $category_title=$_POST['cat_title'];

        // select query
        $select_query="select * from `categories` where category_title='$category_title'";
        $result_select=mysqli_query($con, $select_query);
        $number=mysqli_num_rows($result_select);
        if($number>0){
            echo "<script>alert('Category with same title is already present inside the database')</script>";
        }
        else{
        $insert_query="insert into `categories` (category_title) values ('$category_title')";
        $result=mysqli_query($con, $insert_query);

        if($result){
            echo "<script>alert('Category has been added successfully')</script>";
        }
    }
    }
?>

<h2 class="text-center">Insert Categories</h2>
<form action="" method="post" class="mb-2 p-3">
    <div class="input-group w-90 mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="cat_title" placeholder="Insert categories" aria-describedby="basic-addon1">
    </div>
    <div class="input-group w-10 mb-3 m-auto">
        <input type="submit" class="bg-dark text-white p-2" name="insert_cat" value="Insert Categories">
    </div>
    <!-- <button class="px-3 my-2 p-2 border-0 m-autol bg-dark text-white">
        Insert Categories
    </button> -->
</form>