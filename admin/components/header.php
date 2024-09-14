<header class="header">
    <div class="flex">
        <a href="dashbord.php" class="logo"><img src="img/logo.jpg" alt=""></a>
        <nav class="navbar">
            <a href="dashbord.php">dashboard</a>
            <a href="add_products.php">add products</a>
            <a href="view_product.php">view products</a>
            <a href="user_account.php">accounts</a>
        </nav>

        <div class="icons" >
            <i class="bx bxs-user" id="user-btn"></i>        
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem; "></i>
        </div>

        <div class="profile-detail">
            <?php
                $select_profile = $conn->prepare("select * from `admin` where id =?");
                $select_profile->execute([$admin_id]);

                if ($select_profile->rowCount() > 0) {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                }
            ?>
            <div class="profile">
                <img src="../image/<?= $fetch_profile['profile'];?>" alt="" class="logo-img">
                <p><?= $fetch_profile['name'];?></p>
            </div>
            <div class="flex-btn">
                <a href="profile.php" class="btn">profile</a>
                <a href="./components/adminlogout.php" onclick="return confirm('logout from this website');" class="btn">logout</a>

            </div>



        </div>
        
    </div>
</header>

<?php

?>