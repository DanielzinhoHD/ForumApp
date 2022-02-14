<?php

$topicID = $_GET['id'];

$topic = getTopics($dbh, $topicID);

function getTopics($dbh, $topicID){
    $sql = "SELECT * FROM topics WHERE id = ?;";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($topicID));
    $row = $stmt->fetch();
    $stmt = null;

    if($row){
        return $row;
    }else{
        header("location: ../index.php");
        exit();
    }
}

function getTopicName($topic){
    echo $topic['name'];
}


function getPostsFromTopicID($dbh, $topicID){
    $sql = "SELECT id, name, text, creation_date FROM posts WHERE id_topic = ? AND deleted = 0;";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($topicID));
    $row = $stmt->fetchAll();
    $stmt = null;

    return $row;
}

function getAmoutOfComments($dbh, $postID){
    $sql = "SELECT COUNT(comment) AS NumberOfComments FROM comments WHERE id_post = ?;";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($postID));
    $row = $stmt->fetch();
    $stmt = null;

    if($row['NumberOfComments'] === 1){
        echo $row['NumberOfComments'].' comment';
    }else{
        echo $row['NumberOfComments'].' comments';
    }
}