<?php

function toShortName($name){
    if(strlen($name) >= 5){
        return false;
    }else{
        return true;
    }
}

function toShortMsg($msg){
    if(strlen($msg) >= 20){
        return false;
    }else{
        return true;
    }
}

function emptyInputPost($msg){
    if(empty($msg)){
        return true;
    }else{
        return false;
    }
}

function emptyInputsRegister($name, $email, $password, $password2){
    $result;
    if(empty($name) || empty($email) || empty($password) || empty($password2)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function emptyInputsLogin($email, $password){
    $result;
    if(empty($email) || empty($password)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function loginUser($dbh, $email, $password){
    
    $userEmail = existingEmail($dbh, $email);

    if($userEmail === false){
        echo 'Email doesn\'t exist!';
        exit();
    }

    $verified = $userEmail['verified'];

    if($userEmail['deleted'] !== 1){
        if($verified == 1){
        // Login;
            $hashedPwd = $userEmail["password"];
            $checkedPwd = password_verify($password, $hashedPwd);
    
            if($checkedPwd === false){
                echo 'Wrong password!';
                exit();
            }else if($checkedPwd === true){
                session_start();
                $_SESSION["id"] = $userEmail["id"];
                $_SESSION["name"] = $userEmail["name"];
                $_SESSION["adm"] = $userEmail['adm'];
                exit();
            }
        }else{
            echo 'This account hasn\'t been verified yet!';
        }   
    }else{
        return false;
    }
    
}

function pwdMatch($password, $password2){
    $result;
    if($password !== $password2){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function existingEmail($dbh, $email){
    $sql = "SELECT * FROM accounts WHERE email = ?;";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($email));
    $result = $stmt->fetch();
    $stmt = null;

    if($result){
        return $result;
    }else{
        return false;
    }
}

function createUser($dbh, $name, $email, $password, $vkey){
    $sql = "INSERT INTO accounts (name, email, password, vkey) VALUES (?, ?, ?, ?);";
    
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($name, $email, $hashedPwd, $vkey));
    $result = $stmt->fetch();
    $stmt = null;

    if($result){
        return true;
    }else{
        return false;
    }
}

function alreadyAdded($conn, $userID, $recipeID){
    $sql = "SELECT * FROM favorites WHERE idAccounts = ? AND idRecipe = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        // header("location: ../views/loginSignUp.php?error=stmtfailedemail");
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "ii", $userID, $recipeID);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        
        if($row = mysqli_fetch_assoc($result)){            
            return true;
        }else{
            return false;
        }
    }
    mysqli_stmt_close($stmt);
}

function emptyInputsAddPost($topic, $title, $text){
    if(empty($topic) || empty($title) || empty($text)){
        return true;
    }else{
        return false;
    }
}

function toShortTitle($title){
    if(strlen($title) >= 10){
        return false;
    }else{
        return true;
    }
}

function submitPost($dbh, $userID, $topic, $title, $text){
    $topicID = findTopic($dbh, $topic);
// Creating post;
    $sql = "INSERT INTO posts (id_account_owner, id_topic, name, text) VALUES (?, ?, ?, ?);";
    
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($userID, $topicID, $title, $text));
    $stmt = null;

// Getting post ID;
    $sql = "SELECT id FROM posts WHERE id_account_owner = ? AND id_topic = ? AND name = ?";
    
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($userID, $topicID, $title));
    $result = $stmt->fetch();
    $stmt = null;
    
// Returns the post;
    if($result){
        echo json_encode(['location'=>'../views/post.php?id=' . $result['id']]);
    }else{
        exit();
    }
}

function submitComment($dbh, $msg, $userID, $postID){
// Creating comment;
    $sql = "INSERT INTO comments (id_account, id_post, comment) VALUES (?, ?, ?);";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($userID, $postID, $msg));
    $result = $stmt->fetch();
    $stmt = null;

// Getting comment ID;
    $sql = "SELECT id FROM comments WHERE id_account = ? AND id_post = ? AND comment = ?";
    
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($userID, $postID, $msg));
    $result = $stmt->fetch();
    $stmt = null;

    if($result){
        return $result;
    }else{
        return false;
    }
}

function findTopic($dbh, $topic){
    $sql = "SELECT * FROM topics WHERE name = ? LIMIT 1;";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($topic));
    $result = $stmt->fetch();
    $stmt = null;

    if($result){
        return $result['id'];
    }else{
        createTopic($dbh, $topic);
        return findTopic($dbh, $topic);
    }
}

function createTopic($dbh, $topic){
    $sql = "INSERT INTO topics (name) VALUES (?);";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($topic));
    $result = $stmt->fetch();
    $stmt = null;

    return $result;
}