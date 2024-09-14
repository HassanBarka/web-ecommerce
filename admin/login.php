<?php
    include 'components/connection.php';
    session_start();

    if(isset($_SESSION['admin_id'])){
        $admin_id = $_SESSION['admin_id'];
    }

    //register user
    if(isset($_POST['submit'])){
        $id = unique_id();
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = $_POST['pass'];
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        

        $select_user = $conn->prepare("SELECT * FROM `admin` WHERE email = ? AND password = ?");

        $select_user->execute([$email, $pass]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($select_user->rowCount() > 0){
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            header("location: dashbord.php"); 
        }
        else{
            $warning_msg[] = 'incorrect username or password';
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
    <title>green tea admin panel- login now</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="img/download.png" alt="">
                <h1>login now</h1>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                    Corrupti tenetur accusantium quae assumenda enim asperiores 
                </p>
            </div>
            <form action="" method="post">
              
                <div class="input-field">
                    <p>your email <sup>*</sup></p>
                    <input type="email" name="email" required placeholder = "enter your email" maxlength="50"
                    oninput = "this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>your password <sup>*</sup></p>
                    <input type="password" name="pass" required placeholder = "enter your password" maxlength="50"
                    oninput = "this.value = this.value.replace(/\s/g, '')">
                </div>
               

                <input type="submit" value="login" name="submit" style=" text-align: center; text-transform:capitalize;">
                <p>do not have an account? <a href="register.php" class="btn">register now</a></p>
            </form>

        </section>
        

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php
        include 'components/alert.php'
    ?>
</body>
</html>