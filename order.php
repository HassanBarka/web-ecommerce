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
    <title>Green Coffee - order page</title>
</head>
<body>
    <?php
        include 'components/header.php'
    ?>
    <div class="main">
        <div class="banner">
            <h1>order</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a>
            <span>/ order</span>
        </div>
        
        <section class="orders">
            <div class="box-container">
                <div class="title">
                    <img src="img/download.png" class="logo" alt="">
                    <h1>my orders</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, doloremque, error eaque dolor rem qui modi minu</p>
                </div>
            </div>
            
            <div  class="box-container">
                <?php
                    $select_orders = $conn->prepare("SELECT * FROM `orders` where user_id = ? ORDER BY date desc ");
                    $select_orders->execute([$user_id]);

                    if($select_orders->rowCount()>0){
                        while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                            $select_product = $conn->prepare("SELECT * FROM `products` where id = ?");
                            $select_product->execute([$fetch_order['product_id']]);
                            if($select_product->rowCount()>0){
                                while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
                ?>
            
                <div class="box"
                    <?php
                        if($fetch_order['status']=='cancel'){
                            echo 'style="border:2px solid red";';
                        }
                    ?>>
                    <a href="view_order.php?get_id=<?php echo $fetch_order['id']; ?>">
                        <p class="date"><i class="bi bi-calender-fill"></i>
                            <span> <?php echo $fetch_order['date']; ?></span>
                        </p>
                        <img src="image/<?php echo $fetch_product['image']; ?>" alt="" class="img">
                        <div class="row">
                            <h3 class="name"><?php echo $fetch_product['name']; ?></h3>
                            <p class="price">Price : <?php echo $fetch_order['price']; ?> X <?php echo $fetch_order['qty']; ?></p>
                            <p class="status" style="color:<?php 
                                if($fetch_order['status']=='delivered'){
                                    echo 'green';
                                }elseif($fetch_order['status']=='canceled'){
                                    echo 'red';
                                }else{
                                    echo 'orange';
                                }
                            ?>"><?php echo $fetch_order['status']; ?> </p>
                        </div>
                    </a>

                </div>
                    <?php
                                        
                                        }
                                    }
                                }
                            }else {
                                echo '<p class="empty"> no order takes placed </p>';
                            }
                    ?>
                
                
                </div>
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

