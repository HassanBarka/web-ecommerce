<?php
    include 'components/connection.php';
    session_start();

    if(isset($_SESSION['admin_id'])){
        $admin_id = $_SESSION['admin_id'];
    }

    //register user
    if(!isset($admin_id)){
        header('location: login.php');
    }

    //update product
    if(isset($_POST['update'])){
        $post_id = $_POST['product_id'];

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);

        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);

        $status = $_POST['status'];
        $status = filter_var($status, FILTER_SANITIZE_STRING);

        //update product
        $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, products_details = ?, statut = ? WHERE id = ?");
        $update_product->execute([$name,$price,$content,$status,$post_id]);

        $success_msg[]='product updated';


        $old_image = $_POST['old_image'];

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);

        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../image/'.$image;

        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
        $select_image->execute([$image]);

        if(!empty($image)){
            if($image_size>2000000){
                $warning_msg[] = 'image size too large';
            }elseif($select_image->rowCount() > 0 AND $image != ''){
                $warning_msg[] = 'please rename your image name';
            }else{
                $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
                $update_image->execute([$image,$post_id]);
                move_uploaded_file($image_tmp_name,$image_folder);

                $success_msg[]='image updated';

            }
        }
        header('location: view_product.php');

    
    }


    //delete product
    if(isset($_POST['delete'])){
        $p_id = $_POST['product_id'];
        $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

       

        $del_prod = $conn->prepare("Delete FROM `products` WHERE id = ?");
        $del_prod->execute([$p_id]);

        $success_msg[]='product deleted succefully';
        header('location: view_product.php');

        
    }
      

?>
<style type="text/css">
    <?php
        include 'style_admin.css'
    ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <title>green tea admin panel - edit product</title>
</head>
<body>
    <?php
        include './components/header.php';
    ?>
    <div class="main">
        <div class="banner">
            <h1>edit product</h1>
        </div>
        <div class="title2">
            <a href="dashbord.php">dashboard </a>
            <span>/ edit product</span>
        </div>

        
        <section class="read-post">
            <h1 class="heading">edit product</h1>
            <?php
                $post_id = $_GET['id'];
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_products->execute([$post_id]);

                if($select_products->rowCount() > 0){
                    while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                 
            ?>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id'];?>">
                    <input type="hidden" name="old_image" value="<?= $fetch_product['image'];?>">
                    
                    <div class="input-field">
                        <label for="">update status</label>
                        <select name="status" id="">
                            <option selected disabled value="<?= $fetch_product['statut'];?>"><?= $fetch_product['statut'];?></option>
                            <option value="active">active</option>
                            <option value="deactive">deactive</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="">product name</label>
                        <input type="text" name="name" id="" value="<?= $fetch_product['name'];?>">
                    </div>

                    <div class="input-field">
                        <label for="">product price</label>
                        <input type="text" name="price" id="" value="<?= $fetch_product['price'];?>">
                    </div>

                    <div class="input-field">
                        <label for="">product description</label>
                        <textarea name="content" ><?= $fetch_product['products_details'];?>"</textarea>
                    </div>

                    <div class="input-field">
                        <label for="">product image</label>
                        <input type="file" name="image" accept="image/*">
                        <img src="../image/<?= $fetch_product['image'];?>" alt="" >
                    </div>

                    <div class="flex-btn">
                        <button type="submit" name="update" class="btn">update product </button>
                        <a href="view_product.php" class="btn"> go back </a>
                        <button type="submit" name="delete" class="btn" onclick="return confirm('delete this product');">delete product</button>
                    </div>

                </form>

            </div>
            <?php
                    }
                }else{
                    echo '
                        <div class="empty">
                            <p>no product added yet <br>
                            <a href="add_products"
                            style="margin-top 1.5rem;" class="btn">add product</a></p>
                        </div>
                    ';
                }
            ?>
        </section>
        

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php
        include 'components/alert.php'
    ?>
</body>
</html>