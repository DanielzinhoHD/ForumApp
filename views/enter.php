<?php
session_start();

if(isset($_SESSION['id'])){
    header('location: ../index.php');
}

include_once '../defaults/header.php';

?>
<link rel="stylesheet" href="../styles/enter.css">
<title>Enter our forum!</title>

<body>
    <?php include_once '../defaults/navbar.php'?>

    <div class="offset">
        <div class="container">

            <div class="sign-up">
                <h2 class="title">Sign Up</h2>

                <form action="../includes/register.inc.php" method="POST" class="form-signup">
                    <div class="field">
                        <h3>Name</h3>
                        <input type="text" name="r-name">
                    </div>

                    <div class="field">
                        <h3>Email</h3>
                    <input type="email" name="r-email">
                    </div>

                    <div class="field">
                        <h3>Password</h3>
                    <input type="password" name="r-pwd">
                    </div>

                    <div class="field">
                        <h3>Repeat password</h3>
                    <input type="password" name="r-pwd2">
                    </div>

                    <button name="signup">SIGN UP</button>
                </form>

                <p>Already have an account? <a href="" id="login-btn">Login</a></p>

            </div>

            <div class="slider">
                <img src="../imgs/trees.jpg" alt="">
            </div>

            <div class="login">
                
                <h2 class="title">Login</h2>

                <form action="../includes/login.inc.php" method="POST" class="form-login">
                    <div class="field">
                        <h3>Email</h3>
                        <input type="email" name="l-email">    
                    </div>

                    <div class="field">
                        <h3>Password</h3>
                    <input type="password" name="l-pwd">
                    </div>
                    
                    <button name="login">LOGIN</button>
                </form>

                <p>Don't have an account yet? <a href="" id="signup-btn">Register</a></p>

            </div>

        </div>
        <p id="error"></p>

    </div>
</body>
<script src="../scripts/enter-slider.js"></script>
<script src="../scripts/create-account.js"></script>
<script src="../scripts/login-account.js"></script>
</html>
