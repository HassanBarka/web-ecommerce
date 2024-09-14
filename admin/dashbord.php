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
    <title>green tea admin panel - dashboard</title>
</head>
<body>
    <?php
        include './components/header.php';
    ?>
    <div class="main">
        <div class="banner">
            <h1>dashboard</h1>
        </div>
        <div class="title2">
            <a href="dashbord.php">home </a>
            <span>/ dashboard</span>
        </div>

        
        <section class="dashbord">
            <h1 class="heading">dashboard</h1>
            <div class="box-container">
                <div class="box">
                    <h3>welcome!</h3>
                    <p><?= $fetch_profile['name'];?></p>
                    <a href="" class="btn">profile</a>
                </div>
                <div class="box">
                    <?php
                        $select_product = $conn->prepare("Select * from `products`");
                        $select_product->execute();                
                        $num_of_product = $select_product->rowCount();
                    ?>
                    <h3><?= $num_of_product; ?></h3>
                    <p>products added</p>
                    <a href="add_products.php" class="btn">add new product</a>
                </div>

                <div class="box">
                    <?php
                        $select_active_product = $conn->prepare("Select * from `products` where statut = ?");
                        $select_active_product->execute(['active']);
                        $num_of_active_product = $select_active_product->rowCount();
                    ?>
                    <h3><?= $num_of_active_product; ?></h3>
                    <p>total active products</p>
                    <a href="view_product.php" class="btn">view active products</a>
                </div>

                <div class="box">
                    <?php
                        $select_deactive_product = $conn->prepare("Select * from `products` where statut = ?");
                        $select_deactive_product->execute(['deactive']);
                        $num_of_deactive_product = $select_deactive_product->rowCount();
                    ?>
                    <h3><?= $num_of_deactive_product; ?></h3>
                    <p>total deactive products</p>
                    <a href="view_product.php" class="btn">view deactive products</a>
                </div>

                <div class="box">
                    <?php
                        $select_users = $conn->prepare("Select * from `users`");
                        $select_users->execute();                
                        $num_of_users = $select_users->rowCount();
                    ?>
                    <h3><?= $num_of_users; ?></h3>
                    <p>registered users</p>
                    <a href="user_account.php" class="btn">view users</a>
                </div>

                <div class="box">
                    <?php
                        $select_admin = $conn->prepare("Select * from `admin`");
                        $select_admin->execute();                
                        $num_of_admin = $select_admin->rowCount();
                    ?>
                    <h3><?= $num_of_admin; ?></h3>
                    <p>registered admin</p>
                    <a href="admin_account.php" class="btn">view admin</a>
                </div>

                <div class="box">
                    <?php
                        $select_msg = $conn->prepare("Select * from `message`");
                        $select_msg->execute();                
                        $num_of_msg = $select_msg->rowCount();
                    ?>
                    <h3><?= $num_of_msg; ?></h3>
                    <p>unread message</p>
                    <a href="message.php" class="btn">view message</a>
                </div>

                <div class="box">
                    <?php
                        $select_orders = $conn->prepare("Select * from `orders`");
                        $select_orders->execute();                
                        $num_of_order = $select_orders->rowCount();
                    ?>
                    <h3><?= $num_of_order; ?></h3>
                    <p>total order placed</p>
                    <a href="order.php" class="btn">view orders</a>
                </div>

                <div class="box">
                    <?php
                        $select_conf_orders = $conn->prepare("Select * from `orders` where status = ?");
                        $select_conf_orders->execute(['in progress']);                
                        $num_of_conf_order = $select_conf_orders->rowCount();
                    ?>
                    <h3><?= $num_of_conf_order; ?></h3>
                    <p>total in progress orders</p>
                    <a href="order.php" class="btn">view in progress orders</a>
                </div>

                <div class="box">
                    <?php
                        $select_cancel_orders = $conn->prepare("Select * from `orders` where status = ?");
                        $select_cancel_orders->execute(['canceled']);                
                        $num_of_cancel_order = $select_cancel_orders->rowCount();
                    ?>
                    <h3><?= $num_of_cancel_order; ?></h3>
                    <p>total canceled orders</p>
                    <a href="order.php" class="btn">view canceled orders</a>
                </div>

                <div class="box">
                    <?php
                        $select_delivered_orders = $conn->prepare("Select * from `orders` where status = ?");
                        $select_delivered_orders->execute(['delivered']);                
                        $num_of_delivered_order = $select_delivered_orders->rowCount();
                    ?>
                    <h3><?= $num_of_delivered_order; ?></h3>
                    <p>total delivered orders</p>
                    <a href="order.php" class="btn">view delivered orders</a>
                </div>
                
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