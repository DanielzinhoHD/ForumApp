<?php

include_once '../includes/dbh.inc.php';

$textID;
if(isset($_POST['textID'])){
    $textID = $_POST['textID'];
}

if($_POST['delete'] === 'comment'){
    $sql = 'UPDATE comments SET deleted = 1 WHERE id = ?;';

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($textID));
    $result = $stmt->fetch();
    $stmt = null;
    
    $sql = 'SELECT id FROM comments WHERE id = ? AND deleted = 1 LIMIT 1;';
    
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($textID));
    $result = $stmt->fetch();
    $stmt = null;
    
    if($result){
        echo json_encode(['bool'=>true]);
    }else{
        echo json_encode(['bool'=>false]);
        exit();
    }

}elseif($_POST['delete'] === 'post'){
    $sql = 'UPDATE posts SET deleted = 1 WHERE id = ?;';

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($textID));
    $result = $stmt->fetch();
    $stmt = null;

    $sql = 'SELECT id FROM posts WHERE id = ? AND deleted = 1 LIMIT 1;';
    
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($textID));
    $result = $stmt->fetch();
    $stmt = null;
    
    if($result){
        echo json_encode(['bool'=>true]);
    }else{
        echo json_encode(['bool'=>false]);
        exit();
    }
}elseif($_POST['delete'] === 'account'){
    $userId = $_POST['id'];

    $sql = 'UPDATE accounts SET deleted = 1 WHERE id = ?;';

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($userId));
    $result = $stmt->fetch();
    $stmt = null;

    
}