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
    <title>green tea admin panel - register user's</title>
</head>
<body>
    <?php
        include './components/header.php';
    ?>
    <div class="main">
        <div class="banner">
            <h1>register user's</h1>
        </div>
        <div class="title2">
            <a href="dashbord.php">dashboard </a>
            <span>/ register user's</span>
        </div>

        
        <section class="acconts">
            <h1 class="heading">register users</h1>
            <div class="box-container">
            <?php
                $select_users = $conn->prepare("Select * from `users`");
                $select_users->execute();                
                if( $select_users->rowCount() > 0){
                    while($fetch_user = $select_users->fetch(PDO::FETCH_ASSOC)){

                   
            ?>
            <div class="box">
                <p>user id: <span><?=$fetch_user['id']?></span></p>
                <p>user name: <span><?=$fetch_user['name']?></span></p>
                <p>user email: <span><?=$fetch_user['email']?></span></p>

            </div>
            <?php
                    }
                }else{
                    echo '
                    <div class="empty">
                        <p>no user registred yet </p>
                       
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