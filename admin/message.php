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


    if(isset($_POST['delete'])){
        $d_id = $_POST['delete_id'];
        $d_id = filter_var($d_id, FILTER_SANITIZE_STRING);

       

        $del_msg = $conn->prepare("Delete FROM `message` WHERE id = ?");
        $del_msg->execute([$d_id]);

        $success_msg[]='message deleted succefully';
        
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
    <title>green tea admin panel - unread message</title>
</head>
<body>
    <?php
        include './components/header.php';
    ?>
    <div class="main">
        <div class="banner">
            <h1>unread message</h1>
        </div>
        <div class="title2">
            <a href="dashbord.php">dashboard </a>
            <span>/ unread message</span>
        </div>

        
        <section class="acconts">
            <h1 class="heading">unread message</h1>
            <div class="box-container">
            <?php
                $select_msg = $conn->prepare("Select * from `message`");
                $select_msg->execute();                
                if( $select_msg->rowCount() > 0){
                    while($fetch_msg = $select_msg->fetch(PDO::FETCH_ASSOC)){

                   
            ?>
            <div class="box">
                <h3 class="name"><?= $fetch_msg['name'];?></h3>
                <h4><?= $fetch_msg['subject'];?></h4>
                <p><?= $fetch_msg['message'];?></p>
                <form action="" method="post" class="flex-btn">
                    <input type="hidden" name="delete_id" value="<?=$fetch_msg['id'];?>">
                    <button type="submit" name="delete" class="btn" onclick="return confirm('delete this message');">delete message</button>
                </form>

                
            </div>
            <?php
                    }
                }else{
                    echo '
                    <div class="empty">
                        <p>no message sent yet </p>
                       
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