<?php

session_start();

if(isset($_POST["submit"])){

    $topic = $_POST["topic"];
    $title = $_POST["title"];
    $img = $_POST["img"];
    $text = $_POST["text"];
    $userID = $_SESSION['id'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputsAddPost($topic, $title, $text) !== false){
        echo "You need to fill all the inputs!";
        exit();
    }

    if(toShortTitle($title) !== false){
        echo "You need to make a bigger title for your post!";
        exit();
    }

    if(submitPost($dbh, $userID, $topic, $title, $text) !== false){
        exit();
    }else{
        echo 'Something went wrong!';
    }

}else{
    header("location: ../index.php");
}
