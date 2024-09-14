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
      
    //add product in database
    if(isset($_POST['publish'])){
        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);

        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);

        $stauts = 'active';

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);

        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../image/'.$image;

        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
        $select_image->execute([$image]);
        
        if(isset($image)){
            if ($select_image->rowCount() > 0){
                $warning_msg[] = 'image name repeated';
            }elseif($image_size>2000000){
                $warning_msg[] = 'image size too large';
            }else{
                move_uploaded_file($image_tmp_name,$image_folder);
            }
        }else{
            $image = '';
        }
        if($select_image->rowCount() > 0 AND $image != ''){
            $warning_msg[] = 'please rename your image name';
        }

        else{
            $insert_product = $conn->prepare("INSERT INTO `products` (id, name, price, image,products_details,statut) VALUES (?, ?, ?, ?, ?,?)");
            $insert_product->execute([$id,$name,$price,$image,$content,$stauts]);
            $success_msg[] = 'product inserted successfully';
        }
    }

    //save product in database as draft
    if(isset($_POST['draft'])){
        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);

        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);

        $stauts = 'deactive';

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);

        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../image/'.$image;

        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
        $select_image->execute([$image]);
        
        if(isset($image)){
            if ($select_image->rowCount() > 0){
                $warning_msg[] = 'image name repeated';
            }elseif($image_size>2000000){
                $warning_msg[] = 'image size too large';
            }else{
                move_uploaded_file($image_tmp_name,$image_folder);
            }
        }else{
            $image = '';
        }
        if($select_image->rowCount() > 0 AND $image != ''){
            $warning_msg[] = 'please rename your image name';
        }

        else{
            $insert_product = $conn->prepare("INSERT INTO `products` (id, name, price, image,products_details,statut) VALUES (?, ?, ?, ?, ?,?)");
            $insert_product->execute([$id,$name,$price,$image,$content,$stauts]);
            $success_msg[] = 'product inserted as draft successfully';
        }
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
    <title>green tea admin panel - add_products</title>
</head>
<body>
    <?php
        include './components/header.php';
    ?>
    <div class="main">
        <div class="banner">
            <h1>add products</h1>
        </div>
        <div class="title2">
            <a href="dashbord.php">dashboard </a>
            <span>/ add products</span>
        </div>

        
        <section class="form-container">
            <h1 class="heading">add products</h1>
            <form action="" method="post" enctype="multipart/form-data">

                <div class="input-field">
                    <label for="">product name <sup>*</sup></label>
                    <input type="text" name="name" id="" maxlength="100" required placeholder="add product name">
                </div>

                <div class="input-field">
                    <label for="">product price <sup>*</sup></label>
                    <input type="number" name="price" id="" maxlength="100" required placeholder="add product price">
                </div>

                <div class="input-field">
                    <label for="">product detail <sup>*</sup></label>
                    <textarea name="content" required maxlength="1000" placeholder="write product description" > </textarea>
                </div>

                <div class="input-field">
                    <label for="">product image <sup>*</sup></label>
                    <input type="file" name="image" required accept="image/*">
                </div>
                <div class="flex-btn">
                    <button type="submit" name="publish" class="btn">publish product</button>
                    <button type="submit" name="draft" class="btn">save as draft</button>
                </div>

            </form>
                
        </section>
        

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php
        include 'components/alert.php'
    ?>
</body>
</html>