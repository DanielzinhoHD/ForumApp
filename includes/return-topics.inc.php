<?php

include_once '../includes/dbh.inc.php';

$word = strtolower($_POST['word']);
if($word !== ''){
    $sql = "SELECT * FROM topics WHERE name LIKE ?;";

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
}