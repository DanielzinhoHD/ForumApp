<?php

session_start();

if(isset($_POST["submit"])){

    $msg = $_POST['msg'];
    $postID = $_POST['postID'];
    $userID = $_SESSION['id'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputPost($msg) !== false){
        exit();
    }

    if(toShortMsg($msg) !== false){
        echo 'Your message is to short, make sure to be at least 20 characters long!';
        exit();
    }

    if(submitComment($dbh, $msg, $userID, $postID) !== false){
        exit();
    }else{
        echo 'Something went wrong!';
    }

}elseif(isset($_POST["update"])){

    if($_POST['update'] === 'comment'){
        require_once 'dbh.inc.php';

        $text = $_POST['text'];
        $commentID = $_POST['commentId'];
    
        $sql = "UPDATE comments SET comment = ? WHERE id = ?;";
    
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array($text, $commentID));
        $result = $stmt->fetch();
        $stmt = null;
    
        echo 'comment';

    }elseif($_POST['update'] === 'post'){

        require_once 'dbh.inc.php';

        $text = $_POST['text'];
        $postID = $_POST['postId'];
    
        $sql = "UPDATE posts SET text = ? WHERE id = ?;";
    
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array($text, $postID));
        $result = $stmt->fetch();
        $stmt = null;

        echo 'post';
    }

}else{
    header("location: ../index.php");
}
