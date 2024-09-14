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

    //delete product
    if(isset($_POST['delete'])){
        $p_id = $_POST['product_id'];
        $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

       

        $del_prod = $conn->prepare("Delete FROM `products` WHERE id = ?");
        $del_prod->execute([$p_id]);

        $success_msg[]='product deleted succefully';
        
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
    <title>green tea admin panel - all product</title>
</head>
<body>
    <?php
        include './components/header.php';
    ?>
    <div class="main">
        <div class="banner">
            <h1>all products</h1>
        </div>
        <div class="title2">
            <a href="dashbord.php">dashboard </a>
            <span>/ all products</span>
        </div>

        
        <section class="show-post">
            <h1 class="heading">all products</h1>
            <div class="box-container">
                <?php
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();

                    if($select_products->rowCount() > 0){
                        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                    
                        
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id'];?>">
                    <?php if($fetch_product['image']!=''){ ?>
                        <img src="../image/<?= $fetch_product['image'];?>" alt="" class="image">
                        <div class="status" style="color: <?php if ($fetch_product['statut'] == 'active'){echo 'green';}
                        else {echo 'red';}?>"><?=$fetch_product['statut'];?></div>
                        <div class="price">
                            DT <?= $fetch_product['price']; ?> /- 
                        </div>
                        <div class="title">
                            <?= $fetch_product['name']; ?>
                        </div>
                        <div class="flex-btn">
                            <a href="edit_product.php?id=<?= $fetch_product['id']; ?>" class="btn">edit</a>
                            <button type="submit" name="delete" class="btn" onclick="return confirm('delete this product');">delete</button>
                            <a href="read_product.php?post_id=<?= $fetch_product['id']; ?>" class="btn">view</a>
                        </div>
                    <?php } ?>
                    
                </form>
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
            </div>

            

        </section>
        

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php
        include 'components/alert.php'
    ?>
</body>
</html>