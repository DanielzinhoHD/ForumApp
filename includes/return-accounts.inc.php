<?php

include_once '../includes/dbh.inc.php';

$word = strtolower($_POST['word']);

if($word !== ''){
    $sql = "SELECT
        a.id, 
        a.name, 
        a.creation_date, 
        a.verified,
        COUNT(DISTINCT p.name) AS posts_amount,
        COUNT(DISTINCT c.comment) AS comments_amount
    FROM accounts a
    LEFT JOIN posts p
        ON p.id_account_owner = a.id
    LEFT JOIN comments c
        ON c.id_account = a.id
    WHERE a.name LIKE ? AND
    a.deleted = 0 AND
    a.verified = 1
    GROUP BY 
        a.id;";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, "%$word%", PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt = null;
    
    if($result !== ''){
        echo json_encode($result);
    }else{
        return false;
    }
}else{
    $sql = "SELECT
        a.id, 
        a.name, 
        a.creation_date, 
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
        a.id;";

    $result = $dbh->query($sql)->fetchAll();
    
    if($result !== ''){
        echo json_encode($result);
    }else{
        return false;
    }
}