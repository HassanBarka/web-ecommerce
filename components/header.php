<header class="header">
    <div class="flex">
        <a href="home.php" class="logo"><img src="img/logo.jpg" alt=""></a>
        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="view_products.php">Products</a>
            <a href="order.php">Orders</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact us</a>
        </nav>

        <div class="icons" >
            <?php
                $count_wishlist = $conn->prepare("SELECT * FROM `wishlist` where user_id = ?");
                $count_wishlist->execute([$user_id]);
                $count_wishlist = $count_wishlist->rowCount();

            ?>
            <i class="bx bxs-user" id="user-btn"></i>
            <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup><?php echo $count_wishlist?></sup></a>
            <?php
                $count_cart = $conn->prepare("SELECT * FROM `cart` where user_id = ?");
                $count_cart->execute([$user_id]);
                $count_cart = $count_cart->rowCount();

            ?>
            <a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup><?php echo $count_cart?></sup></a>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem; "></i>
        </div>

        <div class="user-box">
            <p>Username : <span><?php echo $_SESSION['user_name'];?></span></p>
            <p>Email : <span><?php echo $_SESSION['user_email'];?></span></p>
            <a href="login.php" class="btn">login</a>
            <a href="register.php" class="btn">register</a>

            <form method="post">
                <button type="submit" name="logout" class="logout-btn">log out</button>
            </form>
        </div>
        
    </div>
</header>

<?php

?>