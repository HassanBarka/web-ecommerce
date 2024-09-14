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

    if(isset($_POST['submit-btn'])){
        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $subject = $_POST['subject'];
        $subject = filter_var($subject, FILTER_SANITIZE_STRING);
        $message = $_POST['message'];
        $message = filter_var($message, FILTER_SANITIZE_STRING);



        $insert_user = $conn->prepare("INSERT INTO `message` (id, user_id,name, email, subject,message) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_user->execute([$id,$user_id,$name,$email,$subject,$message]);
        
        $warning_msg[] = 'message send succefully';

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
    <title>Green Coffee - contact us page</title>
</head>
<body>
    <?php
        include 'components/header.php'
    ?>
    <div class="main">
        <div class="banner">
            <h1>contact us</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a>
            <span>/ contact us</span>
        </div>
        <section class="services">
            <div class="box-container">
                <div class="box">
                    <img src="img/icon2.png" alt="">
                    <div class="detail">
                        <h3>great saving</h3>
                        <p>save big every order</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon1.png" alt="">
                    <div class="detail">
                        <h3>24*7 support</h3>
                        <p>one-on-one support</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon0.png" alt="">
                    <div class="detail">
                        <h3>git vouchers</h3>
                        <p>vouchers on every festivals</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon.png" alt="">
                    <div class="detail">
                        <h3>worldwide delivery</h3>
                        <p>dropship worldwide</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="main-container">

            <div class="form-container">
                <form method="post" >
                    <div class="title">
                        <img src="img/download.png" class="logo">
                        <h1>leave a message</h1>
                    </div>
                    <div class="input-field">
                        <p>your name <sup>*</sup></p>
                        <input type="text" name="name">
                    </div>
                    <div class="input-field">
                        <p>your email <sup>*</sup></p>
                        <input type="email" name="email">
                    </div>
                    <div class="input-field">
                        <p>your subject <sup>*</sup></p>
                        <input type="text" name="subject">
                    </div>
                    <div class="input-field">
                        <p>your message <sup>*</sup></p>
                        <textarea rows="" cols="" name="message"></textarea>
                    </div>
                    <button type="submit" name="submit-btn" class="btn">send message</button>
                </form>
            </div>
        </section>
        <div class="address">
            <div class="title">
                <img src="img/download.png" alt="" class="logo">
                <h1>contact detail</h1>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. </p>
            </div>
            <div class="box-container">
                <div class="box">
                    <i class="bx bxs-map-pin"></i>
                    <div>
                        <h4>address</h4>
                        <p>1095 Sfax Lane, Cornich</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bxs-phone-call"></i>
                    <div>
                        <h4>phone number</h4>
                        <p>+216 51837846</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bx-mail-send"></i>
                    <div>
                        <h4>email</h4>
                        <p>hassanbarka@gmail.com</p>
                    </div>
                </div>
            </div>

        </div>

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

