<?php

include_once '../includes/dbh.inc.php';

$word = strtolower($_POST['word']);
// echo $word;
if($word !== ''){
    $sql = "SELECT name, id FROM posts WHERE name LIKE ? AND deleted = 0 LIMIT 5;";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, "%$word%", PDO::PARAM_STR);
    $stmt->execute();
    $postName = $stmt->fetchAll();
    $stmt = null;
    
    $sql = "SELECT text, id FROM posts WHERE text LIKE ? AND deleted = 0 LIMIT 5;";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, "%$word%", PDO::PARAM_STR);
    $stmt->execute();
    $postText = $stmt->fetchAll();
    $stmt = null;

    $sql = "SELECT comment, id, id_post FROM comments WHERE comment LIKE ? AND deleted = 0 LIMIT 5;";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, "%$word%", PDO::PARAM_STR);
    $stmt->execute();
    $comment = $stmt->fetchAll();
    $stmt = null;

    // echo json_encode($postName) . json_encode($postText) . json_encode($comment);
    echo json_encode(array($postName, $postText, $comment));

}