<?php
include_once './dbh.inc.php';
session_start();

if(isset($_FILES['input-file']['name'])){
    $allowedExt = array('jpg', 'jpeg', 'png');

    $dir = '../imgs/';
    $file_name = time().basename($_FILES['input-file']['name']);
    $file_path = $dir . $file_name;
    $imgExtension = pathinfo($file_path, PATHINFO_EXTENSION);

    if(in_array($imgExtension, $allowedExt)){

        $sql = "SELECT img_dir FROM accounts WHERE id = ? AND img_dir != 'face1.png';";

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array($_SESSION['id']));
        $result = $stmt->fetch();
        $stmt = null;
        echo $result['img_dir'];
    // If user already has a pfp, delete the last one to use the new one;
        if(isset($result['img_dir'])){
            unlink(($dir.$result['img_dir']));
        }
    // Save user's pfp;
        if(move_uploaded_file($_FILES['input-file']['tmp_name'], $file_path)){
            $sql = "UPDATE accounts SET img_dir = ? WHERE id = ?;";

            $stmt = $dbh->prepare($sql);
            $stmt->execute(array($file_name, $_SESSION['id']));
            $result = $stmt->fetch();
            $stmt = null;

            echo 'Success';
        }else{
            echo 'Try again!';
        }

    }else{
        return false;
    }
}else{
    exit();
}