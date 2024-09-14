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
    

    //delete orders
    if(isset($_POST['delete_order'])){
        $ord_id = $_POST['order_id'];
        $ord_id = filter_var($ord_id, FILTER_SANITIZE_STRING);

       

        $ord_msg = $conn->prepare("Delete FROM `orders` WHERE id = ?");
        $ord_msg->execute([$ord_id]);

        $success_msg[]='order deleted succefully';
        
    }

    //update orders
    if(isset($_POST['update_order'])){
        $ord_id = $_POST['order_id'];
        $ord_id = filter_var($ord_id, FILTER_SANITIZE_STRING);

        $update_pay = $_POST['update_payment'];
        $update_pay = filter_var($update_pay, FILTER_SANITIZE_STRING);


        $update_ord = $conn->prepare("update `orders` set payment_status = ? WHERE id = ?");
        $update_ord->execute([$update_pay,$ord_id]);

        $success_msg[]='order updated succefully';

        if ($update_pay == 'complete'){
            $update_ord = $conn->prepare("update `orders` set status = ? WHERE id = ?");
            $update_ord->execute(['delivered',$ord_id]);
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
    <title>green tea admin panel - order placed page</title>
</head>
<body>
    <?php
        include './components/header.php';
    ?>
    <div class="main">
        <div class="banner">
            <h1>order placed</h1>
        </div>
        <div class="title2">
            <a href="dashbord.php">dashboard </a>
            <span>/ order placed</span>
        </div>

        
        <section class="order_container">
            <h1 class="heading">total order placed</h1>
            <div class="box-container">
                <?php
                    $select_orders =  $conn->prepare("Select * from `orders`");
                    $select_orders->execute(); 
                    if( $select_orders->rowCount() > 0){
                        while($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)){                 
                ?>
                <div class="box">
                    <div class="status" style="color: <?php if ($fetch_order['status'] == 'in progress'){echo 'orange';}elseif($fetch_order['status'] == 'delivered'){echo 'green';}
                        else {echo 'red';}?>"><?=$fetch_order['status'];?>
                    </div>
                    <div class="detail">
                        <p>user name : <span><?= $fetch_order['name'];?></span></p>
                        <p>user id : <span><?= $fetch_order['id'];?></span></p>
                        <p>placed on : <span><?= $fetch_order['date'];?></span></p>
                        <p>user number : <span><?= $fetch_order['number'];?></span></p>
                        <p>user email : <span><?= $fetch_order['email'];?></span></p>
                        <p>total price : <span><?= $fetch_order['price'];?></span></p>
                        <p>method : <span><?= $fetch_order['method'];?></span></p>
                        <p>address : <span><?= $fetch_order['address'];?></span></p>

                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?=$fetch_order['id'];?>">
                        <select name="update_payment" id="">
                            <option selected disabled value="<?= $fetch_order['payment_status'];?>"><?= $fetch_order['payment_status'];?></option>
                            <option value="pending">pending</option>
                            <option value="complete">complete</option>
                        </select>

                        <div class="flex-btn">
                            <button type="submit" name="update_order" class="btn" style=" text-align: center; text-transform:capitalize;">update</button>
                            <button type="submit" name="delete_order" class="btn" onclick="return confirm('delete this product');">delete</button>
                        </div>
                    </form>


    
                </div>
                <?php
                        }
                    }else{
                        echo '
                        <div class="empty">
                            <p>no order takes placed yet !</p>                           
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