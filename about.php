<?php
    include 'components/connection.php';
    session_start();

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';
        $_SESSION['user_name'] = '';
        $_SESSION['user_email'] = '';
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
    <title>Green Coffee - home page</title>
</head>
<body>
    <?php
        include 'components/header.php'
    ?>
    <div class="main">
        <div class="banner">
            <h1>about us</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a>
            <span>/ about us</span>
        </div>
        <div class="about-category">
            <div class="box">
                <img src="img/3.webp" alt="">
                <div class="detail">
                    <span>coffee</span>
                    <h1>lemon green</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="img/about.png" alt="">
                <div class="detail">
                    <span>coffee</span>
                    <h1>lemon Teaname</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="img/2.webp" alt="">
                <div class="detail">
                    <span>coffee</span>
                    <h1>lemon Teaname</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="img/1.webp" alt="">
                <div class="detail">
                    <span>coffee</span>
                    <h1>lemon green</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <section class="services">
            <div class="title">
                <img src="img/download.png" class="logo" alt="">
                <h1>why shoose us</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt temporibus quod eius molestias minus reprehenderit delectus</p>
            </div>
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
        <div class="about">
            <div class="row">
                <div class="img-box">
                    <img src="img/3.png" alt="">
                </div>
                <div class="detail">
                    <h1>visit our beautiful showroom!</h1>
                    <p>
                        Our showroom is an expression of what we love doing; being creative with floral
                        and plant arrangements.
                        Whether you are looking for a florist for your perfect wedding, or just want to uplift any room
                        with some one of a kind living decor, Blossom with love can help.
                    </p>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <div class="testimonial-container">
            <div class="title">
                <img src="img/download.png" alt="" class="logo">
                <h1>what people say about us</h1>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit amet consectetur adipisicing elit.
                </p>
            </div>
            <div class="container">
                <div class="testimonial-item active">
                    <img src="img/01.jpg" alt="">
                    <h1>sara smith</h1>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum illum distinctio
                         repellat quibusdam ratione, odit veritatis odio possimus, quasi 
                        repellendus minima! In a non officia consequatur praesentium fugiat assumenda maiores.
                    </p>
                </div>
                <div class="testimonial-item">
                    <img src="img/02.jpg" alt="">
                    <h1>john smith</h1>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum illum distinctio
                         repellat quibusdam ratione, odit veritatis odio possimus, quasi 
                        repellendus minima! In a non officia consequatur praesentium fugiat assumenda maiores.
                    </p>
                </div>
                <div class="testimonial-item">
                    <img src="img/03.jpg" alt="">
                    <h1>selena ansari</h1>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum illum distinctio
                         repellat quibusdam ratione, odit veritatis odio possimus, quasi 
                        repellendus minima! In a non officia consequatur praesentium fugiat assumenda maiores.
                    </p>
                </div>
                <div class="testimonial-item">
                    <img src="img/04.png" alt="">
                    <h1>alweena ansari</h1>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum illum distinctio
                         repellat quibusdam ratione, odit veritatis odio possimus, quasi 
                        repellendus minima! In a non officia consequatur praesentium fugiat assumenda maiores.
                    </p>
                </div>
                <div class="left-arrow" onclick="prevSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
                <div class="right-arrow" onclick="nextSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
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

<!-- arrter a 1:19:00 lien: https://www.youtube.com/watch?v=RlT_sxhQWYk -->
