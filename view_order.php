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

    if(isset($_GET['get_id'])){
        $get_id = $_GET['get_id'];
    }else {
        $get_id = '';
        header('locatio:order.php');
    }

    if(isset($_POST['cancel'])){
        $update_order = $conn->prepare("UPDATE `orders` set status = ? where id = ?");
        $update_order->execute(['canceled',$get_id]);
        header('location:order.php');
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
    <title>Green Coffee - order detail</title>
</head>
<body>
    <?php
        include 'components/header.php'
    ?>
    <div class="main">
        <div class="banner">
            <h1>order detail</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a>
            <span>/ order detail</span>
        </div>
        
        <section class="order-detail">
            <div class="box-container">
                <div class="title">
                    <img src="img/download.png" class="logo" alt="">
                    <h1>my orders</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, doloremque, error eaque dolor rem qui modi minu</p>
                </div>
            </div>
            
            <div  class="box-container">
                <?php
                    $grand_total = 0;
                    $select_orders = $conn->prepare("SELECT * FROM `orders` where id = ? LIMIT 1 ");
                    $select_orders->execute([$get_id]);

                    if($select_orders->rowCount()>0){
                        while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                            $select_product = $conn->prepare("SELECT * FROM `products` where id = ?  LIMIT 1 ");
                            $select_product->execute([$fetch_order['product_id']]);
                            if($select_product->rowCount()>0){
                                while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
                                    $sub_total = ($fetch_order['price']*$fetch_order['qty']);
                                    $grand_total+=$sub_total;
                ?>
            
                    <div class="box">
                        <div class="col">
                            <p class="title"><i class="bi bi-calender-fill"></i><?php echo $fetch_order['date'];?></p>
                            <img src="image/<?php echo $fetch_product['image'];?>" class="image" alt="">
                            <p class="price"><?php echo $fetch_product['price'];?> x <?php echo $fetch_order['qty'];?></p>
                            <p class="name"><?php echo $fetch_product['name'];?> </p>
                            <p class="grand_total" class="btn" >Total amount payable : DT <span class="span"><?php echo $grand_total;?>/-</span></p>
                            
                        </div>
                    <div class="col">
                            <p class="title"> Billing address</p>
                            <p class="user"><i class="bx bxs-user"></i> <?= $fetch_order['name']?>
                            </p>
                            <p class="user"> 
                                <i class="bx bx-phone"></i> <?= $fetch_order['number']?>
                            </p>
                            <p class="user"> 
                                <i class="bx bx-envelope"></i> <?= $fetch_order['email']?>
                            </p>  
                            <p class="user"> 
                                <i class="bx bx-map-pin"></i> <?= $fetch_order['address']?>
                            </p>
                            <p class="title">status</p>
                            <p class="status" style="color:<?php 
                                if($fetch_order['status']=='delivered'){
                                    echo 'green';
                                }elseif($fetch_order['status']=='canceled'){
                                    echo 'red';
                                }else{
                                    echo 'orange';
                                }?>"><?php echo $fetch_order['status'];?>

                                <?php if($fetch_order['status']=='canceled'){?>
                                    <a href="checkoutphp?get_id=<?= $fetch_product['id'];?>" class="btn">order again</a>
                                    <?php } else { ?>
                                        <form method="post">
                                            <button type="submit" name="cancel" class="btn" onclick="return confirm('do you want to cancel this order')">cancel order</button>
                                        </form>
                                    <?php } ?>

                            </p>                     
                    </div>

                </div>
                    <?php
                                        
                                }
                            }else{
                                echo '<p class="empty">product not found</p>';
                            }
                        }
                    }else{
                        echo '<p class="empty">no order found</p>';
                    }
                    ?>
            </div>

        </section>
        <?php
            include 'components/footer.php'
        ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php
        include 'components/alert.php'
    ?>
    
</body>
</html>

