<?php 
    include_once '../defaults/header.php';
    include_once '../includes/dbh.inc.php';
    include_once '../includes/post-details.inc.php';
    session_start();
    if(isset($_SESSION['deleted'])){
        if($_SESSION['deleted'] === 1){
            header("location: ../includes/logout.inc.php");
        }
    }
?>
<link rel="stylesheet" href="../styles/post.css">
<title>Post</title>

<body>
    <?php include_once '../defaults/navbar.php'?>

    <div class="offset">
        <div class="container">

            <h1 class="topic">Topic: <?php getTopic($dbh, $post);?></h1>
            <div class="owner post" data-post-id=<?php echo $postID?> >
                <div class="owner-pic">
                    <img src="../imgs/<?= getPostOwnerPfp($post)?>" alt="">
                    <p><?php getPostOwnerName($dbh, $post) ?></p>
                    <p class="creation-date">Created account at:<br><?php getPostOwnerCreationDate($dbh, $post)?></p>
                </div>
                <div class="publication">
                        <?php 
                            if(isset($_SESSION['id'])){
                                if($_SESSION['id'] == getPostOwner($post)){
                                    echo '<button class="edit-comment">Edit <i class="fas fa-pen"></i></button>';
                                }
                            }
                         ?>
                    <h3 class="title">
                        <?php echo ucfirst(getPostTitle($post))?>
                    </h3>
                    <div class="text">
                        <textarea disabled class="comment"><?php getPostText($post)?></textarea>
                    </div>
                    <p class="post-creation-date">Posted in: <?php getPostCreationDate($post)?> at <?php getPostCreationTime($post)?></p>
                </div>
                <?php if(isset($_SESSION['id'])){
                    if($_SESSION['adm'] == 1){ ?>
                        <button class="remove-btn"><i class="fas fa-times"></i></button>
                    <?php }
                } ?>
            </div>

            <hr class="horizontal">

<?php 
        $result = getComments($dbh, $postID);
        // print_r($result);
        foreach($result as $key => $value){
                
    // Check if comment was made by post owner, if not, echoes a respondent class div;
        if($result[$key]['id_account'] == $post['id_account_owner']){ ?>

            <div class="owner" data-comment-id=<?php echo $result[$key]['id']?>>
                <div class="owner-pic">
                    <img src="../imgs/<?php getAccountPfp($dbh, $result[$key]['id_account'])?>" alt="">
                    <p>
                        <?php getAccountName($dbh, $result[$key]['id_account']); ?>
                        <p class="creation-date">Created account at:<br><?php getAccountCreationDate($dbh, $result[$key]['id_account'])?></p>
                    </p>
                </div>
                <div class="publication">
                <?php
                    if($result[$key]['deleted'] === 0){ 
                        if(isset($_SESSION['id'])){
                            if($_SESSION['id'] === $result[$key]['id_account']){
                                echo '<button class="edit-comment">Edit <i class="fas fa-pen"></i></button>';
                            }
                        }
                        echo '<div class="text">';
                        echo '<textarea disabled>'.$result[$key]['comment'].'</textarea>';
                        echo '</div>';
                        echo "<p class='post-creation-date'>Posted in: ";
                        echo getCommentCreationDate($result[$key]['creation_date']);
                        echo " at ";
                        echo getCommentCreationTime($result[$key]['creation_date']);
                        echo "</p>";
                    }else{
                        echo '<div class="deleted">';
                        echo 'This comment was deleted by a moderator!';
                        echo '</div>';
                        echo "<p class='post-creation-date'>Posted in: ";
                        echo getCommentCreationDate($result[$key]['creation_date']);
                        echo " at ";
                        echo getCommentCreationTime($result[$key]['creation_date']);
                        echo "</p>";
                    }
                ?> 
                </div>
                <?php if(isset($_SESSION['id'])){
                    if($_SESSION['adm'] == 1 && $result[$key]['deleted'] == 0){ ?>
                        <button class="remove-btn"><i class="fas fa-times"></i></button>
                    <?php }
                } ?>
            </div>

        <?php }else{ ?>

            <div class="respondent" data-comment-id=<?php echo $result[$key]['id']?>>
                <div class="respondent-pic">
                    <img src="../imgs/<?php getAccountPfp($dbh, $result[$key]['id_account'])?>" alt="">
                    <p>
                        <?php getAccountName($dbh, $result[$key]['id_account']); ?>
                        <p class="creation-date">Created account at:<br><?php getAccountCreationDate($dbh, $result[$key]['id_account'])?></p>
                    </p>
                </div>
                <div class="publication">
                <?php
                    if($result[$key]['deleted'] === 0){ 
                        if(isset($_SESSION['id'])){
                            if($_SESSION['id'] === $result[$key]['id_account']){
                                echo '<button class="edit-comment">Edit <i class="fas fa-pen"></i></button>';
                            }
                        }
                        echo '<div class="text">';
                        echo '<textarea disabled>'.$result[$key]['comment'].'</textarea>';
                        echo '</div>';
                        echo "<p class='post-creation-date'>Posted in: ";
                        echo getCommentCreationDate($result[$key]['creation_date']);
                        echo " at ";
                        echo getCommentCreationTime($result[$key]['creation_date']);
                        echo "</p>";
                    }else{
                        echo '<div class="deleted">';
                        echo '<p class="deleted-text">This comment was deleted by a moderator!</p>';
                        echo '</div>';
                        echo "<p class='post-creation-date'>Posted in: ";
                        echo getCommentCreationDate($result[$key]['creation_date']);
                        echo " at ";
                        echo getCommentCreationTime($result[$key]['creation_date']);
                        echo "</p>";
                    }
                ?>                       
                </div>
                <?php if(isset($_SESSION['id'])){
                    if($_SESSION['adm'] == 1 && $result[$key]['deleted'] == 0){ ?>
                        <button class="remove-btn"><i class="fas fa-times"></i></button>
                    <?php }
                } ?>
            </div>

            <?php } ?>
    <?php } ?>

        <?php
            if(isset($_SESSION['id'])){ ?>
            <div class="comment">
                <div class="text-box">
                    <h3>Type your message here:</h3>
                    <button class="send-msg-btn" id="submit">SEND MESSAGE</button>
                    <textarea name="text" id="" cols="30" rows="10" placeholder="Type it here..."></textarea>
                </div>
            </div>

            <?php }else{ ?>
            <div class="notlogged">
                <h3>Want to add a comment?</h3>
                <p><a href ="./enter.php" id="login">Login</a> now!<br>Or create your account <a href ="./enter.php?signup" id="signup">here</a>!</p>
            </div>
            <?php }
        ?>
            

            <p id="error"></p>
        </div>
    </div>

    <div class="popup-screen">
        <div class="popup">
            <div class="popup-text">
                <p>Do you really want to delete this comment?</p>
                <p>Users will no longer be able to see it!</p>
            </div>
            <hr class="horizontal">
            <div class="popup-btn-box">
                <button id="delete-btn">DELETE</button>
                <button id="cancel-btn">CANCEL</button>
            </div>
        </div>
    </div>
</body>
<script src="../scripts/auto-comment-scroll.js"></script>
<script src="../scripts/submit-comment.js"></script>
<script src="../scripts/edit-comment.js"></script>
<?php if(isset($_SESSION['adm']) == 1){ ?>
    <script src="../scripts/delete-comment.js"></script>
<?php } ?>
</html>