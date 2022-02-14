<?php include_once '../defaults/header.php';

session_start();
if(isset($_SESSION['id'])){
    header("location: ../index.php");
}
?>

<link rel="stylesheet" href="../styles/success.css">
<title>Success!</title>

<body>
    <?php include_once '../defaults/navbar.php'?>

    <div class="offset">
        <div class="container">

        <i class="fas fa-user icon"></i>

        <?php 
        $query = $_GET['stats'];

        if($query == 'verified'){
            echo '<h2>Your account has been verified successfully!
            <br
            >You can <a href="../views/enter.php" class="link">login</a> now!</h2>';
        }else if($query == 'emailsent'){
            echo '<h2>We sent you an email verification!
            <br>
            You need to confirm to be able to login!</h2>';
        }
        ?>

    </div>
</body>
</html>