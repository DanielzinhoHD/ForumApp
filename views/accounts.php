<?php 
include_once '../defaults/header.php';
include_once '../includes/dbh.inc.php';

session_start();
if(isset($_SESSION['deleted'])){
    if($_SESSION['deleted'] === 1){
        header("location: ../includes/logout.inc.php");
    }
}
if(!isset($_SESSION['id']) || $_SESSION['adm'] !== 1){
    header('location: ../views/enter.php');
}
?>
<link rel="stylesheet" href="../styles/accounts.css">
<title>Accounts</title>

<body>
    <?php include_once '../defaults/navbar.php';?>


    <div class="offset">

        <div class="container">

            <h2>Account list:</h2>
            <input name="search-accounts" type="text" class="search" placeholder="Search for accounts">
            <div class="suggestions"></div>
    
            <div class="account-list">
                <?php
                    
                    $sql = "SELECT
                                a.id, 
                                a.name, 
                                a.creation_date, 
                                a.img_dir,
                                COUNT(DISTINCT p.name) AS posts_amount,
                                COUNT(DISTINCT c.comment) AS comments_amount
                            FROM accounts a
                            LEFT JOIN posts p
                                ON p.id_account_owner = a.id
                            LEFT JOIN comments c
                                ON c.id_account = a.id
                            WHERE a.deleted = 0 AND
                            a.verified = 1
                            GROUP BY 
                                a.id";

                    $result = $dbh->query($sql);

                    foreach($result as $row){ ?>
                    <a href="../views/profile.php?id=<?php echo $row['id']?>">
                        <div class="account">
                            <img src="../imgs/<?= $row['img_dir']?>" alt="">
                            <div class="account-container">
                                <div class="account-body">
                                    <p class="account-name"><?php echo ucfirst($row['name'])?></p>
                                    <p class="creation-date"><?php echo date_format(date_create($row['creation_date']), 'm/d/y')?></p>
                                </div>
                                <div class="account-feet">
                                    <p class="account-posts">
                                        <?php if($row['posts_amount'] == 1){
                                            echo $row['posts_amount'] . ' post';
                                        }else{
                                            echo $row['posts_amount'] . ' posts';
                                        }
                                        ?>
                                    </p>
                                    <p class="account-comments">
                                        <?php if($row['comments_amount'] == 1){
                                            echo $row['comments_amount'] . ' comment';
                                        }else{
                                            echo $row['comments_amount'] . ' comments';
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
                
            </div>

        </div>

    </div>
</body>
<script src="../scripts/return-accounts.js"></script>
</html>