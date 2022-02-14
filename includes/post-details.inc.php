<?php

$postID = $_GET['id'];

$post = getPost($dbh, $postID);

function getPost($dbh, $postID){
    $sql = "SELECT 
                p.*, 
                a.img_dir 
            FROM posts p 
            LEFT JOIN accounts a 
                ON a.id = p.id_account_owner
            WHERE
                p.id = ?;";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($postID));
    $row = $stmt->fetch();
    $stmt = null;

    if($row){
        return $row;
    }else{
        header("location: ../index.php");
    }
}

function getTopic($dbh, $post){
    $sql = "SELECT name FROM topics WHERE id = ?;";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($post['id_topic']));
    $row = $stmt->fetch();
    $stmt = null;

    echo $row['name'];
}

function getAccount($dbh, $accountID){
    $sql = "SELECT name, creation_date, adm, img_dir FROM accounts WHERE id = ?;";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($accountID));
    $row = $stmt->fetch();
    $stmt = null;

    return $row;
}

function getAccountName($dbh, $accountID){
    $row = getAccount($dbh, $accountID);

    echo ucfirst($row['name']);
}

function getAccountPfp($dbh, $accountID){
    $row = getAccount($dbh, $accountID);

    echo $row['img_dir'];
}

function getAccountCreationDate($dbh, $accountID){
    $row = getAccount($dbh, $accountID);

    echo date_format(date_create($row['creation_date']), 'm/d/y');
}

function getAccountAdm($dbh, $accountID){
    $row = getAccount($dbh, $accountID);

    echo $row['adm'];
}

function getPostOwner($post){
    return $post['id_account_owner'];
}

function getPostOwnerPfp($post){
    return $post['img_dir'];
}

function getPostOwnerName($dbh, $post){
    $row = getAccount($dbh, $post['id_account_owner']);

    echo ucfirst($row['name']);
}

function getPostOwnerCreationDate($dbh, $post){
    $row = getAccount($dbh, $post['id_account_owner']);

    echo date_format(date_create($row['creation_date']), 'm/d/y');
}

function getPostTitle($post){
    return $post['name'];
}

function getPostText($post){
    echo $post['text'];
}

function getPostCreationDate($post){
    echo date_format(date_create($post['creation_date']), 'm/d/y');
}

function getPostCreationTime($post){
    echo date_format(date_create($post['creation_date']), 'H:i:s');
}

function getComments($dbh, $postID){
    $sql = "SELECT id, comment, id_account, deleted, creation_date FROM comments WHERE id_post = ?;";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($postID));
    $row = $stmt->fetchAll();
    $stmt = null;

    return $row;
}

function getCommentCreationDate($comment){
    echo date_format(date_create($comment), 'm/d/y');
}

function getCommentCreationTime($comment){
    echo date_format(date_create($comment), 'H:i:s');
}