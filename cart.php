<?php
    include 'components/connection.php';
    session_start();

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';

    }

    if(isset($_POST['logout'])){
        session_destroy();
        header("location: login.php");
    }

    
    //adding product in cart
    if(isset($_POST['add_to_cart'])){
        $id = unique_id();
        $product_id = $_POST['product_id'];
        $qty = 1;
        $qty = filter_var($qty,FILTER_SANITIZE_STRING);
        $verify_cart = $conn->prepare("SELECT * FROM `cart` where user_id = ? AND product_id=?");
        $verify_cart->execute([$user_id, $product_id]);

        $max_cart_items = $conn->prepare("SELECT * FROM `cart` where user_id = ? ");
        $max_cart_items->execute([$user_id]);

        if($verify_cart->rowCount() > 0){
            $warning_msg[] = 'product already exist in your cart';

        }else if($max_cart_items->rowCount() > 20){
            $warning_msg[] = 'cart is full'; 

        }else{
            $select_price = $conn->prepare("SELECT * FROM `products` where id=? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            $insert_cart = $conn->prepare("INSERT INTO `cart`(id,user_id,product_id,price,qty) VALUES(?,?,?,?,?)");
            $insert_cart->execute([$id,$user_id,$product_id,$fetch_price['price'],$qty]);
            $success_msg[] = "product added to cart successfully";

            }

    }
    if(isset($_POST['delete_item'])){
        $wishlist_id = $_POST['cart_id'];
        $wishlist_id = filter_var($wishlist_id,FILTER_SANITIZE_STRING);

        $verify_delete = $conn->prepare("SELECT * FROM `cart` where id = ? ");
        $verify_delete->execute([$wishlist_id]);

        if($verify_delete->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `cart` where id = ? ");
            $delete_wishlist->execute([$wishlist_id]);
            $success_msg[] = "cart item delete successfully";
        }
        else{
            $warning_msg = 'cart item alreafy deleted';
        }
    }

    if(isset($_POST['empty_cart'])){
        

        $verify_delete = $conn->prepare("SELECT * FROM `cart` where user_id = ? ");
        $verify_delete->execute([$user_id]);

        if($verify_delete->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `cart` where user_id = ? ");
            $delete_wishlist->execute([$user_id]);
            $success_msg[] = "empty successfully";
        }
        else{
            $warning_msg = 'cart item alreafy deleted';
        }
    }

    if(isset($_POST['update_cart'])){
        
        $cart_id = $_POST['cart_id'];
        $cart_id = filter_var($cart_id,FILTER_SANITIZE_STRING);

        $qty = $_POST['qty'];
        $qty = filter_var($qty,FILTER_SANITIZE_STRING);


        $update_qty = $conn->prepare("UPDATE `cart` set qty = ? where id = ?");
        $update_qty->execute([$qty,$cart_id]);

        $success_msg[] = "cart quantity updated successfully";
    }

?>

<style type="text/css">
    <?php
        include 'style.css'
    ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <title>Green Coffee - wishlist page</title>
</head>
<body>
    <?php
        include 'components/header.php'
    ?>
    <div class="main">
        <div class="banner">
            <h1>cart</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a>
            <span>/ cart</span>
        </div>
        <section class="product-cart">
            <h1 class="title">products added in cart</h1>
            <div class="box-container">
                <?php
                    $grand_total = 0;
                    $select_cart = $conn->prepare("SELECT * FROM `cart` where user_id = ?");
                    $select_cart->execute([$user_id]);

                    if($select_cart->rowCount()>0){
                        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                            $select_product = $conn->prepare("SELECT * FROM `products` where id = ?");
                            $select_product->execute([$fetch_cart['product_id']]);
                            if($select_product->rowCount()>0){
                                $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);
                            
                ?>
                            <form action="" method="post" class="box">
                                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id'];?>">
                                <img src="image/<?php echo $fetch_product['image']; ?>" alt="" class="img">
                                <h3 class="name"> <?php echo $fetch_product['name'];?></h3>
                                <div class="flex">
                                    <p class="price">price DT<?php echo $fetch_product['price'];?></p>
                                
                                    <input type="number" name="qty" id="" required min="1" value="<?php echo $fetch_cart['qty'];?>" max="99" maxlength="2" class="qty">
                                    <button type="submit" name="update_cart" class="bx bxs-edit fa-edit"></button>
                                </div>
                                <p class="sub-total">sub total : <span>DT<?php echo $sub_total = ($fetch_cart['qty'] * $fetch_cart['price'] );?></span></p>
                                <button type="submit" name="delete_item" class="btn" onclick="return confirm('delete this item');">delete</button>
                            </form>
                            <?php       
                            $grand_total+=$sub_total;
                            }
                        }
                    }else {
                        echo '<p class="empty"> product was not found!</p>';
                    }
                ?>
            </div>
            <?php
                if ($grand_total != 0){
                                    
            ?>
            <div class="cart-total">
                <p>total amount payable :  <span><span>DT<?php echo $grand_total ;?></span></p>
                <div class="button">
                    <form method="post">
                        <button type="submit" name="empty_cart" class="btn" onclick="return confirm('are you sure to empty your cart')">empty cart</button>
                    </form>

                    <a href="checkout.php" class="btn">proceed to checkout</a>


                </div>
            </div>
            <?php
                }
            ?>
        </section>
        <?php
            include 'components/footer.php'
        ?>
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php
        include 'components/alert.php'
    ?>
    
</body>
</html>

