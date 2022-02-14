<?php 
include_once '../defaults/header.php';
include_once '../includes/dbh.inc.php';

session_start();
if(isset($_SESSION['deleted'])){
    if($_SESSION['deleted'] === 1){
        header("location: ../includes/logout.inc.php");
    }
}

if(!isset($_SESSION['id'])){
    header('location: ../views/enter.php');
}

$userId;
if($_SESSION['adm'] === 1){
    if(isset($_GET['id'])){
        $userId = $_GET['id'];
    };   
}
// echo $userId;

if(isset($userId)){
// Getting users stats;
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
            WHERE a.id = ?
            GROUP BY 
                a.id";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($userId));
    $account = $stmt->fetch();
    $stmt = null; 

// Getting users posts and comments;
    $sql = "SELECT
                p.id, 
                p.name, 
                p.text,
                p.creation_date,
                COUNT(c.id) AS comments_amount,
                p.id_account_owner AS post_owner,
                p.deleted
            FROM posts p
            LEFT JOIN comments c
                ON c.id_post = p.id
            WHERE p.id_account_owner = ?
            OR c.id_account = ?
            AND p.deleted = 0
            GROUP BY 
                p.creation_date";

            $stmt = $dbh->prepare($sql);
            $stmt->execute(array($userId, $userId));
            $result = $stmt->fetchAll();
            $stmt = null;
}else{
    $userId = $_SESSION['id'];

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
            WHERE a.id = ?
            GROUP BY 
                a.id";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($_SESSION['id']));
    $account = $stmt->fetch();
    $stmt = null; 

// Getting users posts and comments;
    $sql = "SELECT
                p.id, 
                p.name, 
                p.text,
                p.creation_date,
                COUNT(c.id) AS comments_amount,
                p.id_account_owner AS post_owner,
                p.deleted
            FROM posts p
            LEFT JOIN comments c
                ON c.id_post = p.id
            WHERE p.id_account_owner = ?
            OR c.id_account = ?
            AND p.deleted = 0
            GROUP BY 
                p.creation_date";

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array($userId, $userId));
        $result = $stmt->fetchAll();
        $stmt = null;
}

?>

<link rel="stylesheet" href="../styles/profile.css">

<body>
    <?php include_once '../defaults/navbar.php';?>

    <div class="offset">
        <div class="container">
        <?php if($account){ ?>
            <title>Profile of <?php echo $account['name'];?></title>

            <h1>Profile of <?= $account['name']?></h1>
            <div class="settings">
                <div class="account" data-user-id="<?php echo $account['id'];?>">
                    
                    <img src="../imgs/<?php echo $account['img_dir']?>" alt="">
                    <div class="account-container">
                        <div class="account-body">
                            <p class="account-name"><?php echo $account['name'];?></p>
                            <p class="creation-date"><?php echo date_format(date_create($account['creation_date']), 'm/d/y')?></p>
                        </div>
                        <div class="account-feet">
                            <p class="account-posts">
                                <?php if($account['posts_amount'] == 1){
                                    echo $account['posts_amount'] . ' post';
                                }else{
                                    echo $account['posts_amount'] . ' posts';
                                }
                                ?>
                            </p>
                            <p class="account-comments">
                                <?php if($account['comments_amount'] == 1){
                                    echo $account['comments_amount'] . ' comment';
                                    }else{
                                        echo $account['comments_amount'] . ' comments';
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                
                </div>

                <div class="btn-box">
                    <?php
                        if($_SESSION['adm'] !== 1 || $_SESSION['id'] == $_GET['id']){ ?>
                            <form action="" method="POST">
                                <label for="input-file">Change picture</label>
                                <input type="file" name="input-file" id="input-file">
                            </form>
                        <?php }
                    ?>
                    <button class="delete">Delete account</button>
                </div>
            </div>
            
        <?php }else{
            echo '<h1 style="text-align: center">There is no account with this ID</h1>';
        } ?>
            <hr class="horizontal">

            <div class="post-list">
                <?php 
                    if($userId){

                        foreach($result as $row){ ?>
                            <div class="post">
                                <a href="../views/post.php?id=<?php echo $row['id']?>">
                                    <div class="subject">
                                        <h3 class="title">
                                            <?php 
                                                // echo $row['post_owner'];
                                                if($userId == $row['post_owner']){
                                                    echo ucfirst($row['name']) . " (Owner)";
                                                }else{
                                                    echo ucfirst($row['name']) . " (Commented)";
                                                }
                                            ?>
                                        </h3>
                                        <div class="text">
                                            <?php echo ucfirst($row['text']); ?>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <p class="comments"><?php 
                                            if($row['comments_amount'] == 1){
                                                echo $row['comments_amount'] . ' comment';
                                            }else{
                                                echo $row['comments_amount'] . ' comments';
                                            }
                                        ?></p>
                                        <p class="date">created at: 01/01/2021</p>
                                    </div>
                                </a>
                            </div>
                        <?php }
                    }
                ?>
            </div>

        </div>
    </div>
    <div class="popup-screen">
        <div class="popup">
            <div class="popup-text">
                <p>Do you really want to delete this account?</p>
                <p>Users will no longer be able to log in!</p>
            </div>
            <hr class="horizontal">
            <div class="popup-btn-box">
                <button id="delete-btn">DELETE</button>
                <button id="cancel-btn">CANCEL</button>
            </div>
        </div>
    </div>

</body>
<script src="../scripts/profile-btns.js"></script>
</html>